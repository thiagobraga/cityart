<?php if (count($recentlyImages) >= 3) { ?>
    <div id="recently-images" class="panel panel-default panel-list last-images">
        <div class="panel-heading">
            {{recently_images_title}}
        </div>

        <!-- Listando imagens -->
        <div class="panel-body no-padding-top">
            <ul class="list-image">
                <?php foreach ($recentlyImages as $image) {
                    $src = '/image/bares/' . $image->char_filename_photobar . '/90/90/c';
                    $link = $location->url . '/' . $image->char_nomeamigavel_bar; ?>

                    <li class="list-image-item">
                        <img src="<?php echo $src ?>"
                            class="thumbnail thumbnail-square no-padding no-border img-shadow"
                            data-href="<?php echo $link ?>"
                            data-title="<?php echo sliceSentence($image->char_nome_bar, 18) ?>"
                            alt="{{recently_images_title}}"
                            width="90"
                            height="90" />
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>
