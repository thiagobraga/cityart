<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class MY_Upload
{
    public $CI = null;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('upload');
        $this->CI->load->library('image_lib');
    }

    /*
    * @folder    [string] Destiny folder
    * @file_name [string] Name of the file
    * @key       [string] Related index from $_FILES
    *
    * @return    [boolean] If 1, the file were successfully saved.
    *                       If 0, an error occurred.
    */
    public function saveImage($folder, $file_name, $key)
    {
        $config['upload_path']   = 'assets/images/' . $folder;
        $config['file_name']     = $file_name;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite']     = true;
        $config['max_filename']  = 38;
        $config['remove_spaces'] = true;

        $this->CI->upload->initialize($config);

        $errors = array();

        // Uploading original image
        if( !$this->CI->upload->do_upload($key))
        {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        } else {

            // If file has a different type
            $info = $this->CI->upload->data();

            if($info['image_type'] != 'jpeg') {
                $info = $this->createJpegImage($info);
            }

            // If the file was converted
            if ($info) {

                $this->createCopies($info);

                return 1;

            } else { // Error

               array_push($errors, 'File cannot be converted to JPEG.');

            }
        }

        return $errors;
    }

    /**
     * Save an image given an url as parameter
     * @param  [type] $folder        [description]
     * @param  [type] $char_filename [description]
     * @param  [type] $url           [description]
     * @return [type]                [description]
     */
    public function saveImageFromURL($folder, $char_filename, $url)
    {
        $name = basename($url);
        file_put_contents("assets/images/$folder/$char_filename.jpg", file_get_contents($url));

        $image_properties = getimagesize("/var/www/barpedia/assets/images/$folder/$char_filename.jpg");

        $width  = $image_properties[0];
        $height = $image_properties[1];
        $mime   = $image_properties["mime"];
        $ext    = substr($mime, 6);

        $errors = array();

        // Load downloaded info image
        $info =  array (
            'full_path'      => "/var/www/barpedia/assets/images/$folder/$char_filename.jpg",
            'file_path'      => "/var/www/barpedia/assets/images/$folder/",
            'file_name'      => "$char_filename.jpg",
            'raw_name'       => $char_filename,
            'image_width'    => $width,
            'image_height'   => $height,
            'image_type'     => substr($mime, 6)
        );

        if($info['image_type'] != 'jpeg') {
            $info = $this->createJpegImage($info);
        }

        $this->createCopies($info);

        return 1;
    }

    // Create a jpg's copy
    public function createJpegImage ($info)
    {
        switch ($info['image_type']) {
            case 'gif':
                $image = imagecreatefromgif($info['full_path']);
            break;

            case 'png':
                $image = imagecreatefrompng($info['full_path']);
                // list($width, $height) = getimagesize($input);
                // $image = imagecreatetruecolor($width, $height);
                // $white = imagecolorallocate($image, 255, 255, 255);
                // imagefilledrectangle($image, 0, 0, $width, $height, $white);
                // $image = imagecopy($image, $input, 0, 0, 0, 0, $width, $height);
            break;

            default:
                return false;
            break;
        }

        // Deleting the original
        unlink($info['full_path']);

        // Creating jpeg version
        $ok = imagejpeg($image, $info['file_path'] . $info['raw_name'] . '.jpg', 100);
        chmod($info['file_path'] . $info['raw_name'] . '.jpg', 0755); // Permission

        // Successfully created
        if($ok) {
            // Updating file info
            $info['file_name']  = $info['raw_name'] . '.jpg';
            $info['file_type']  = 'image/jpeg';
            $info['full_path']  = $info['file_path'] . $info['raw_name'] . '.jpg';
            $info['file_ext']   = '.jpg';
            $info['image_type'] = 'jpeg';

            return $info;
        } else {
            return false;
        }
    }

    // Resizing image
    public function resize ($info, $size)
    {
        $config['image_library']  = 'gd2';
        $config['source_image']   = $info['full_path'];
        $config['new_image']      = $info['file_path'] . $info['file_name'];
        $config['maintain_ratio'] = TRUE;
        $config['create_thumb']   = TRUE;

        switch ($size) {
            case 'icon':
                $config['thumb_marker'] = '_ico';
                $config['width']        = $info['image_width'] < 48 ? $info['image_width'] : 48;
                $config['height']       = ($config['width'] * $info['image_height']) / $info['image_width'];
            break;

            case 'extra_small':
                $config['thumb_marker'] = '_xs';
                $config['width']        = $info['image_width'] < 70 ? $info['image_width'] : 70;
                $config['height']       = ($config['width'] * $info['image_height']) / $info['image_width'];
            break;

            case 'small':
                $config['thumb_marker'] = '_s';
                $config['width']        = $info['image_width'] < 150 ? $info['image_width'] : 150;
                $config['height']       = ($config['width'] * $info['image_height']) / $info['image_width'];
            break;

            case 'medium':
                $config['thumb_marker'] = '_m';
                $config['width']        = $info['image_width'] < 300 ? $info['image_width'] : 300;
                $config['height']       = ($config['width'] * $info['image_height']) / $info['image_width'];
            break;

            case 'large':
                $config['thumb_marker'] = '_l';
                $config['width']        = $info['image_width'] < 550 ? $info['image_width'] : 550;
                $config['height']       = ($config['width'] * $info['image_height']) / $info['image_width'];
            break;

            default:
                return 0;
            break;
        }

        $this->CI->image_lib->initialize($config);

        $ok = $this->CI->image_lib->resize(); // Successfully resized

        if(!$ok)
        {
            echo $this->CI->image_lib->display_errors();
        }

        chmod($info['file_path'] . $info['raw_name'] . $config['thumb_marker'] . '.jpg', 0755); // Permission

        $this->CI->image_lib->clear();

        return $ok;
    }

    public function createCopies ($info)
    {
        chmod($info['full_path'], 0755);

        // Resizing it
        // Creating thumbnail (extra_small)
        if (!$this->resize($info, 'icon')) {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        }

        // Creating thumbnail (extra_small)
        if (!$this->resize($info, 'extra_small')) {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        }

        // Creating thumbnail (small)
        if (!$this->resize($info, 'small')) {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        }

        // Creating a medium size image
        if (!$this->resize($info, 'medium')) {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        }

        // Creating a large size image
        if (!$this->resize($info, 'large')) {
            array_push($errors, $this->CI->upload->display_errors());
            return 0;
        }

        return 1;
    }
}
