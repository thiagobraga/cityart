<!-- Entre seus amigos -->
<h5 class="title">{{users_opinion}}</h5>

<section id="visible-filters">
    <?php
    foreach ($unique_filtered as $category) {
        // Cache
        $first_filter = $category['filtros'][0]['char_texto_filtrobar'];
        $title = $category['char_titulo_filtrobarcategoria'];

        // Percents of votes for first filter
        $calc = round(($category['filtros'][0]['total_usuarios'] * 100) / $category['total'], 0); ?>

        <p class="category-title cursor-default">
            <b class="font-weight-semi-bold">{{<?php echo $title ?>}}:</b>
            {{<?php echo $first_filter ?>}} (<?php echo $calc ?>%)
        </p>

        <section class="progress">
            <?php foreach ($category['filtros'] as $i => $filtro) {
                $calc  = ($filtro['total_usuarios'] * 100) / $category['total'];
                $round = round($calc, 0); ?>

                <div class="progress-bar progress-bar-color-<?php echo $i ?>"
                    role="progressbar"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    data-transitiongoal="<?php echo $calc ?>"
                    data-template="<?php echo $tooltip_success ?>"
                    title="<?php echo htmlentities('<span class="text-uppercase">{{' . $filtro['char_texto_filtrobar'] . '}}</span> (' . $round . '{{percent_of_votes}})') ?>">

                    <?php if ($round >= $minimum_percentage) { ?>
                        <span><?php echo $round ?>%</span>
                    <?php } ?>
                </div>
            <?php } ?>
        </section>
    <?php } ?>
</section>

<?php if ($multiple_filtered) { ?>
    <div class="more-filters-wrapper text-center">
        <a href="#"
            id="view-more-filters"
            class="btn btn-link btn-link-more <?php echo $hide_show_all_filters ?>">
            {{bar_show_additional_filters}}
            <span class="fa fa-angle-double-down"></span>
        </a>
    </div>

    <section id="hidden-filters" class="hidden-filters hidden">
        <?php
        foreach ($multiple_filtered as $category) {
            // Cache
            $title = $category['char_titulo_filtrobarcategoria']; ?>

            <section>
                <p class="category-title cursor-default">
                    <b class="font-weight-semi-bold">{{<?php echo $title ?>}}</b>
                </p>

                <?php foreach ($category['filtros'] as $i => $filtro) {
                    $calc  = ($filtro['total_usuarios'] * 100) / $category['total_category'];
                    $round = round($calc, 0);

                    if ($round <= 20) {
                        $percent = 20;
                    } else if ($round <= 40) {
                        $percent = 40;
                    } else if ($round <= 60) {
                        $percent = 60;
                    } else if ($round <= 80) {
                        $percent = 80;
                    } else {
                        $percent = 100;
                    } ?>

                    <p class="category-title cursor-default">
                        {{<?php echo $filtro['char_texto_filtrobar'] ?>}} (<?php echo $round ?>%)
                    </p>

                    <section class="progress">
                        <div class="progress-bar progress-bar-color-<?php echo $percent ?>"
                            role="progressbar"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            data-transitiongoal="<?php echo $calc ?>"
                            data-template="<?php echo $tooltip_success ?>"
                            title="<?php echo htmlentities('<span class="text-uppercase">{{' . $filtro['char_texto_filtrobar'] . '}}</span> (' . $round . '{{percent_of_votes}})') ?>">

                            <?php if ($round >= $minimum_percentage) { ?>
                                <span><?php echo $round ?>%</span>
                            <?php } ?>
                        </div>
                    </section>
                <?php } ?>
            </section>

        <?php } ?>
    </section>

<?php } ?>
