<?php if ($show_offers) { ?>
    <section class="row row-offers">
        <section class="col-xs-4 text-center no-padding-left no-padding-right">
            <span class="thumbnail offers64 offers64-food <?php if (!$food['show']) echo 'offers64-disabled' ?>"
                data-template="<?php echo $food['template'] ?>"
                title="<?php echo $food['tooltip'] ?>">
            </span>
            <br/>
            <span class="filter-title <?php if (!$food['show']) echo 'filter-title-gray' ?>">
                {{filter_food}}
            </span>
        </section>

        <section class="col-xs-4 text-center no-padding-left no-padding-right">
            <span class="thumbnail offers64 offers64-music <?php if (!$music['show']) echo 'offers64-disabled' ?>"
                data-template="<?php echo $music['template'] ?>"
                title="<?php echo $music['tooltip'] ?>">
            </span>
            <br/>
            <span class="filter-title <?php if (!$music['show']) echo 'filter-title-gray' ?>">
                {{filter_music}}
            </span>
        </section>

        <section class="col-xs-4 text-center no-padding-left no-padding-right">
            <span class="thumbnail offers64 offers64-dance <?php if (!$dance['show']) echo 'offers64-disabled' ?>"
                data-template="<?php echo $dance['template'] ?>"
                title="<?php echo $dance['tooltip'] ?>">
            </span>
            <br/>
            <span class="filter-title <?php if (!$dance['show']) echo 'filter-title-gray' ?>">
                {{filter_dance}}
            </span>
        </section>
    </section>
<?php }

if (isset($session['ainc_id_usuario'])) { ?>
    <section class="row row-opinion">
        <div class="col-sm-12 give-your-opinion">
            <?php if (!$session['has_rated']) {
                if (!$show_user_opinion_tooltip) { ?>
                    <button class="btn btn-success btn-open-rating-modal text-uppercase pull-right">
                        {{bar_give_your_opinion}}
                    </button>
                <?php } else { ?>
                    <button class="btn btn-success btn-open-rating-modal text-uppercase pull-right tooltip-always-show-delayed"
                        data-time="<?php echo $show_user_opinion_tooltip_delay ?>"
                        data-placement="left"
                        data-template="<?php echo $tooltip_warning ?>"
                        title="{{rating_component_how_about_share_your_opinion}}">
                        {{bar_give_your_opinion}}
                    </button>
                <?php } ?>

                <!-- If this bar was already evaluated, show tooltip -->
                <?php } else { ?>
                    <button class="btn btn-success text-uppercase disabled pull-right"
                        title="{{rating_component_already_rated}}">
                        {{bar_give_your_opinion}}
                    </button>
                <?php } ?>
        </div>
    </section>
<?php } ?>
