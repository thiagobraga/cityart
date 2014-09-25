<div class="panel panel-default top-3-bars">
    <div class="panel-heading">
        {{bar_top_3}} <?php echo $location->char_nomelocal_cidade ?>
    </div>
    <ul class="list-group">
        <?php
        foreach ($top3 as $key => $top_bar) {
            $logo = $top_bar->char_logo_bar;
            $name = $top_bar->char_nome_bar;
            $href = $top_bar->char_nomeamigavel_bar;
            $address = sliceSentence($top_bar->char_endereco_bar, 22);
            $rate = $top_bar->inte_nota_bar;
            ?>

            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-9 more-bars-info">
                        <a href="<?php echo $href ?>">
                            <img src="/image/bares/<?php echo $logo ?>/48/48"
                                width="48"
                                height="48"
                                class="pull-left thumbnail thumbnail-bar"
                                data-href="<?php echo $href ?>" />

                            <p><?php echo $name ?></p>
                            <small rel="tooltip"
                                title="<?php echo $top_bar->char_endereco_bar ?>"
                                data-placement="bottom">
                                <?php echo $address ?>
                            </small>
                        </a>
                    </div>

                    <div class="col-xs-3 more-bars-rate">
                        <a href="<?php echo $href ?>">
                            <span class="bar-rate" data-toggle="tooltip" data-placement="left" rel="tooltip" title="<?php echo rateToText($rate) ?>">
                                <?php if ((float)$rate >= 4.5) { ?>
                                    <span class="beer beer-5"></span>
                                <?php } ?>
                                <span class="label label-warning"><?php echo i18n($rate) ?></span>
                            </span>
                        </a>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>

