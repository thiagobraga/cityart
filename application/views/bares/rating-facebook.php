<div class="text-center rating-facebook">
    <div class="fb-like"
        data-action="like"
        data-href="<?php echo base_url(uri_string())?>"
        data-layout="button_count"
        data-show-faces="false"
        data-share="true">
    </div>

    <!--
    {{AQUI}} Deprecated
    <span class="total_rates" data-value="<?php //echo $total_rates; ?>">
        <?php
            /*$total_rates_label = ($total_rates == 1)
                ? 'liked_this_bar_1'
                : 'liked_this_bar';

            $enable_like_button    = ($has_rated)? 'hidden': '';
            $enable_dislike_button = (!$has_rated)? 'hidden': '';

            $total_rates;*/ ?>

        {{<?php echo $total_rates_label ?>}}
    </span><br>

    <button class="page-rate btn btn-default">
        <span class="page-rate-like    <?php //$enable_like_button ?>">{{like}}</span>
        <span class="page-rate-dislike <?php //$enable_dislike_button ?>">{{dislike}}</span>
    </button>-->
</div>
