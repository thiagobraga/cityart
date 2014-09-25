<?php if (count($most_rated_bars)) { ?>
    <section class="panel panel-default panel-most-rated-bars">
        <header class="panel-heading">
            {{most_rated_bars_title}}
            <small>{{most_rated_bars_subtitle}}</small>
        </header>

        <ul id="most-rated-bars" class="list-group">
            <?php foreach ($most_rated_bars as $bar) { ?>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-9 more-bars-info">
                            <a href="<?php echo $location->url ?>/<?php echo $bar->char_nomeamigavel_bar ?>">
                                <img src="/image/bares/<?php echo $bar->char_logo_bar ?>/32/32"
                                    width="32"
                                    height="32"
                                    class="pull-left thumbnail thumbnail-bar"
                                    data-href="<?php echo $location->url ?>/<?php echo $bar->char_nomeamigavel_bar ?>" />

                                <p title="<?php echo $bar->char_nome_bar ?>"><?php echo sliceSentence($bar->char_nome_bar, 18) ?></p>
                                <small title="<?php echo $bar->char_endereco_bar ?>"><?php echo sliceSentence($bar->char_endereco_bar, 22) ?></small>
                            </a>
                        </div>

                        <div class="col-xs-3 more-bars-badge">
                            <?php if ($bar->inte_nota_bar) { ?>
                                <a href="<?php echo $location->url ?>/<?php echo $bar->char_nomeamigavel_bar ?>">
                                    <span class="bar-rate <?php if ((float)$bar->inte_nota_bar < 4.5) { ?>not-has-badge<?php } ?>" title="<?php echo rateToText($bar->inte_nota_bar) ?>">
                                        <?php if ((float) $bar->inte_nota_bar >= 4.5) { ?>
                                            <span class="beer beer-5"></span>
                                        <?php } ?>
                                        <span class="label label-warning"><?php echo i18n($bar->inte_nota_bar) ?></span>
                                    </span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <footer class="more-bars-footer">
            <a href="<?php echo $location->url ?>/melhores-bares" class="btn btn-see-more btn-sm">{{see_more}}</a>
        </footer>
    </section>
<?php } ?>
