<section class="panel panel-default">
    <header class="panel-heading">
        {{user_photos}}
    </header>

    <?php

    $total = count($photos_from_users);
    $is_logged = ($session['ainc_id_usuario'] != null);

    if ($total > 0) { ?>
        <section class="panel-body">
            <?php
            $i         = 0; // Counter of images
            $full_size = 240; // Full width of the image

            // First always has width = 250
            $images[0][0] = array(
                'file_name' => $photos_from_users[$i]->char_filename_photobar,
                'title'     => $photos_from_users[0]->char_nome_bar,
                'width'     => 1,
                'height'    => 0.75
            );

            if ($total > 1) {
                $images[0][0]['height'] = 0.5;
            }
            $i++;

            // Further lines
            $rows = 1; // Line
            $max = 2; // Total of images per line
            $k   = 0; // Counter of images

            while ($i < $total) {

                $images[$rows][$k] = array(
                    'file_name' => $photos_from_users[$i]->char_filename_photobar,
                    'title'     => $photos_from_users[$i]->char_nome_bar,
                    'width'     => 1 / $max,
                    'height'    => 0.33);

                $i++;
                $k++;

                if ($k == $max) {
                    $k = 0;
                    $rows++;

                    // A partir da linha 2, mostra 3 imagens
                    if ($rows == 2) $max = 3;
                }
            }

            // Displaying images
            for ($i = 0; $i < $rows; $i++) {
                $list_images = $images[$i];
                ?>

                <div class="row">
                    <div class="col-xs-12 photo-container">
                        <?php foreach ($list_images as $image) {
                            $file_name        = $image['file_name'];
                            $width            = $image['width']  * $full_size;
                            $height           = $image['height'] * $full_size;
                            $original_source  = '/image/bares/' . $file_name;
                            $thumbnail_source = '/image/bares/' . $file_name . '/' . $width . '/' . $height . '/c';
                            $title            = $image['title'];
                            ?>

                            <a href="<?php echo $original_source ?>"
                                data-lightbox="image-1"
                                data-title="<?php echo $title ?>">

                                <img src="<?php echo $thumbnail_source ?>"
                                    class="photo-border pull-left"
                                    width="<?php echo $width ?>"
                                    height="<?php echo $height?>" />
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </section>
    <?php } ?>

    <footer class="panel-footer">
        <label for="upload-photos" class="btn btn-success btn-block text-uppercase">
            {{send_images}}
        </label>

        <input id="upload-photos"
            class="hidden"
            type="file"
            multiple />
    </footer>
</section>
