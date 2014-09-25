<section class="panel panel-default panel-more-bars">
    <!-- Default panel contents -->
    <header class="panel-heading">
        <div class="row">
            <section class="col-xs-12">
                <span id="more-bars-title">
                    {{more_bars_in_title}} <?php echo $location->char_nomelocal_cidade ?>
                </span>

                <small id="total-bares">
                    <span id="count-bars">
                        <?php echo ($total_bares > 10) ? $total_bares : '0' . $total_bares ?>
                    </span>
                    <?php if ($total_bares > 1) { ?>
                        {{found_plural}}
                    <?php } else { ?>
                        {{found_singular}}
                    <?php } ?>
                </small>
            </section>

            <section id="selected-filters" class="col-xs-6 no-padding-left has-filter text-right hidden"></section>
        </div>
    </header>

    <ul id="lista-bares" class="list-group">
        <?php foreach ($bares as $bar) { ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-xs-10 more-bars-info">
                        <a href="<?php echo $location->url ?>/<?php echo $bar->char_nomeamigavel_bar ?>">
                            <img src="/image/bares/<?php echo $bar->char_logo_bar ?>/48/48"
                                width="48"
                                height="48"
                                class="pull-left thumbnail thumbnail-bar"
                                data-href="<?php echo $location->url ?>/<?php echo $bar->char_nomeamigavel_bar ?>" />

                            <p><?php echo $bar->char_nome_bar ?></p>
                            <small><?php echo $bar->char_endereco_bar ?></small>
                        </a>
                    </div>

                    <div class="col-xs-2 more-bars-badge">
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

    <footer id="paginas-bares" class="more-bars-footer text-center"></footer>
</section>
