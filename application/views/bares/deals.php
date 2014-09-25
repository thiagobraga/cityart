<section class="panel panel-default list-group panel-deals">
    <header class="panel-heading">
        {{deals_of_the_bar}}
    </header>

    <?php foreach ($deals as $deal) {

        $title       = $deal->title;
        $description = $deal->description;
        $src         = base_url('/image/ofertas/' . $deal->char_filename . '/280/100/c');

        // Show 'see more' button just if we have something to display
        $has_description = strlen($deal->description) > 0;

        // Date
        $start = $deal->stamp_day_start . '/' . '{{' . $deal->stamp_month_start . '}}';
        $end   = $deal->stamp_day_finish . '/' . '{{' . $deal->stamp_month_finish . '}}';
        $range = $start . ' à ' . $end;
        ?>

        <div class="deal-container margin-bottom-20"
             style="background-image:url(<?php echo $src ?>);">

                <div class="deal-header">
                    <b><?php echo $title ?></b> <br>
                    <small><?php echo $range ?></small>
                </div>

                <?php if ($has_description) { ?>

                    <div class="deal-footer">
                        {{last_deals_more_info}} &nbsp;
                        <img src="/assets/images/icons/body-beer.png"
                             data-placement="top"
                             title="{{last_deals_more_info}}" />
                    </div>

                    <div class="hidden deal-description">
                        <?php echo $description ?>
                        <div class="deal-description-slide-up">
                            <span style="margin-left:50%;" class="fa fa-caret-up"></span>
                        </div>
                    </div>

                <?php } ?>
        </div>
    <?php } ?>
</section>
