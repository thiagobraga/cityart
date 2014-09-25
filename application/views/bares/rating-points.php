<div class="row">

    <!-- Rank position -->
    <div class="col-xs-7 no-padding-right">
        <p class="index-bar cursor-default">

            <!-- If bar wasn't reviewed yet, do not show its position -->
            <?php
            if (!$config_bar['review']['below_minimum_hidden_all']) { ?>
                <span <?php if ($index_bar[0]->rank == '?') { ?> rel="tooltip" title="{{in_review}}" <?php } ?>>#<?php echo $index_bar[0]->rank ?></span>
                / <?php echo $total_bares ?> {{bars}}<br/>
                <b class="font-weight-semi-bold">{{in}} <?php echo $location->char_nome_cidade ?></b>
            <?php } ?>
        </p>
    </div>

    <!-- Bar rate -->
    <div class="col-xs-5">
        <div class="beer-icon-wrapper text-right">
            <span class="bar-rate" title="<?php echo rateToText($index_bar[0]->inte_nota_bar) ?>">

                <!-- Premium (bars with score higher than 4.5)-->
                <?php if ($index_bar[0]->inte_nota_bar >= 4.5) { ?>
                    <span class="beer beer-<?php echo rateClass($index_bar[0]->inte_nota_bar, 1) ?>"></span>
                <?php } ?>

                <!-- Rate -->
                <span class="rating-points-label"><?php echo $inte_nota_bar ?></span>
            </span>
        </div>
    </div>
</div>
