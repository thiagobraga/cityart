<?php
if (
    $bar->char_descricao_bar != ''
    && $bar->char_logo_bar != ''
) { ?>

    <section class="row description">
        <section class="col-xs-10">
            <p class="bar-description bubble bubble-right">
                <?php echo $bar->char_descricao_bar ?>
            </p>
        </section>

        <section class="col-xs-2 no-padding-left">
            <img src="/image/bares/<?php echo $bar->char_logo_bar ?>/68/68"
                class="thumbnail pull-right"
                width="68"
                height="68" />
        </section>
    </section>

    <?php if (count($comments)) { ?>
        <hr class="clearfix" />
    <?php }
} ?>
