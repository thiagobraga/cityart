<?php if ($count_my_bars && $user_bars_to_show) { ?>
    <section class="pages">
        <header class="panel-heading">
            {{pages_that_i_administer}}
            <small>
                <?php
                echo $count_my_bars . (($count_my_bars == 1)
                    ? ' {{page_singular}}'
                    : ' {{page_plural}}');

                if ($count_my_bars > $user_bars_to_show) { ?>
                    ({{showing_only}}
                    <?php
                    echo $user_bars_to_show . (($user_bars_to_show == 1)
                        ? ' {{bar_singular}}'
                        : ' {{bar_plural}}');
                    ?>)
                <?php } ?>
            </small>
        </header>

        <!-- Listing all pages which belong to user -->
        <section>
            <?php foreach ($my_bars as $bar) {
                $ratings       = ($bar->has_ratings == true) ? i18n($bar->ratings) : '-,-';
                $is_premium    = ($bar->is_premium == true)  ? 'visible' : 'invisible';
                $has_ratings   = ($bar->has_ratings == true) ? 'visible' : 'invisible';
                ?>

                <a href="<?php echo base_url('pages/' . $bar->char_nomeamigavel_bar) ?>">
                    <section class="row">
                        <article class="col-xs-9">
                            <img src="/image/bares/<?php echo $bar->char_logo_bar ?>/36/36"
                                class="thumbnail pull-left"
                                width="36"
                                height="36" />

                            <p><?php echo $bar->char_nome_bar ?></p>

                            <small title="<?php echo $bar->address ?>" data-placement="bottom">
                                <?php echo substr($bar->address, 0, 30) . '...' ?>
                            </small>
                        </article>

                        <!-- Score -->
                        <article class="col-xs-3 no-padding-left text-right">
                            <span class="bar-rate" title="<?php echo rateToText($bar->ratings) ?>">
                                <?php if ($bar->is_premium) { ?>
                                    <span class="beer beer-5"></span>
                                <?php } ?>
                                <span class="label label-warning"><?php echo $ratings ?></span>
                            </span>
                        </article>
                    </section>
                </a>
            <?php } ?>
        </section>
    </section>
<?php } ?>
