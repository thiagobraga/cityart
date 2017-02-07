<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * MY_Controller
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @access public
 * @version 1.0
 */
class MY_Controller extends CI_Controller
{

    /**
     * Variável que armazena dados no controller
     * e envia para as views.
     *
     * @var {stdClass}
     */
    public $data;

    /**
     * Armazena o nome do controller
     *
     * @var {String}
     */
    public $controller;

    /**
     * Armazena o nome do método
     *
     * @var {String}
     */
    public $method;

    /**
     * Call the Controller constructor
     * This function is used to call
     * default languages, layout views, etc.
     * @since 1.0
     */
    public function __construct()
    {
        parent::__construct();

        $this->data     = [
            'controller'  => $this->router->fetch_class(),
            'method'      => $this->router->fetch_method(),
            'title'       => 'CityArt Artes Gráficas | Design & Pré-Impressão',
            'description' => 'Empresa bauruense no ramo de design e desenvolvimento web com visão de mercado, usabilidade e simplicidade. Também prestamos consultoria e suporte para essas áreas.',
            'keywords'    => 'design, sites, bauru, desenvolvimento web'
        ];

        // Defining controllers and navbar itens.
        // The fields are URL, class name and display name.
        $this->data['modules'] = [
            ['design', 'design', 'Design'],
            ['pre-impressao', 'pre-impressao', 'Pré-Impressão'],
            ['contato', 'contato', 'Contato']
        ];

        // Define active item on navbar based on current controller.
        foreach ($this->data['modules'] as $key => $module) {
            if ($module[0] === $this->router->uri->uri_string) {
                $this->data['modules'][$key][] = true;
            }
        }

        // Load assets
        // ==========================================
        self::loadAssets([
            'assets/css/dist/styles.css',
            'assets/js/dist/scripts.js'
        ], false);
    }

    /**
     * Load assets files.
     *
     * @access  protected
     * @param   {Array}    $files   Array of paths to assets files.
     * @param   {Boolean}  $concat  Concatenate new files to existent array or not.
     * @return  {String}
     */
    protected function loadAssets(array $files, $minify = false, $concat = true)
    {
        $countFiles = count($files);

        if ($concat === true) {
            $css = $this->load->get_var('css');
            $js  = $this->load->get_var('js');
        }

        for ($i = 0; $i < $countFiles; $i++) {
            // The absolute path of the file.
            $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $files[$i];

            // Get the path info of the file and extract variables.
            extract(pathinfo($files[$i]));

            // In production environments, the minified version of the
            // file will be called and the make time of file will be
            // concatenated in the path to avoid caching problems.
            if (ENVIRONMENT === 'production') {
                $files[$i]  = $dirname . '/' . $filename;

                if ($minify === true) {
                    $files[$i] .= '.min.';
                }

                $files[$i] .= $extension;
                $mktime     = filemtime($path);
                $files[$i] .= '?v=' . $mktime;
            }

            // Node modules alias.
            if (strpos($files[$i], 'assets') !== 0) {
                $files[$i] = 'node_modules/' . $files[$i];
            }

            ${$extension}[] = $files[$i];
        }

        $this->load->vars('css', array_unique($css));
        $this->load->vars('js', array_unique($js));
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
