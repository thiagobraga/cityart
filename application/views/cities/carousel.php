<?php

if (
    $total_bares >= $config_cities['carousel']['minimum_bars_to_show_carousel']
    && count($carousel) >= $config_cities['carousel']['amount_of_photos_to_show']
) { ?>
    <div class="cycle-carousel-container">
        <div id="bares-carousel"
            class="cycle-slideshow cycle-carousel"
            data-cycle-fx="carousel"
            data-cycle-timeout="5000"
            data-cycle-pause-on-hover="true"
            data-cycle-allow-wrap="true"
            data-cycle-slides="> div"
            data-cycle-speed="3000"
            data-cycle-log="false"
            data-cycle-swipe="true">

            <?php foreach ($carousel as $item) {
                $img = '/image/bares/' . $item->char_filename . '/262/175/c';
                $url = base_url(uri_string() . '/' . $item->char_nomeamigavel_bar);

                if ($item->nota_bar >= 4.5) {
                    $html_nota = '<span class="bar-rate beer beer-5"></span>';
                } else {
                    $html_nota = '<span class="bar-rate beer beer-hidden"></span>';
                } ?>

                <div class="cycle-carousel-item">
                    <a href="<?php echo $url ?>">
                        <img src="<?php echo $img ?>" />
                    </a>
                    <div class="cycle-carousel-caption">
                        <div class="row">
                            <div class="col-xs-8">
                                <a href="<?php echo $url ?>">
                                    <h4><?php echo $item->char_nome_bar ?></h4>
                                    <p><?php echo sliceSentence($item->char_endereco_bar, 30) ?></p>
                                </a>
                            </div>
                            <div class="col-xs-4">
                                <?php if ($item->nota_bar) { ?>
                                    <div class="pull-right">
                                        <a href="<?php echo $url ?>">
                                            <div class="bar-rate"
                                                rel="tooltip"
                                                data-placement="top"
                                                title="<?php echo rateToText($item->nota_bar) ?>">

                                                <?php echo $html_nota ?>
                                                <span class="label label-warning label-lg">
                                                    <?php echo i18n($item->nota_bar) ?>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="cycle-carousel-button cycle-carousel-prev"></div>
        <div class="cycle-carousel-button cycle-carousel-next"></div>
    </div>

<?php } ?>
