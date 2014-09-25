<section class="panel panel-default panel-filters">
    <header class="panel-heading">
        {{filters_title}}
        <small>{{filters_subtitle}}</small>
    </header>

    <?php if (count($available_filters)) { ?>
        <section class="panel-body">
            <section id="available-filters" class="panel-group">

                <?php
                foreach ($available_filters as $key => $category) {
                    $id_category   = $category->ainc_id_filtrobarcategoria;
                    $name_category = $category->char_titulo_filtrobarcategoria;
                    $filters       = explode(';', $category->filtros);

                    $class = ($key == 0)
                        ? 'fa-angle-up'
                        : 'fa-angle-down'; ?>

                    <section class="panel panel-default">
                        <header class="panel-heading">
                            <a href="#<?php echo $name_category ?>" data-toggle="collapse" data-parent="#available-filters">
                                <span class="name-category">{{<?php echo $name_category ?>}}</span>
                                <span class="pull-right fa <?php echo $class ?>"></span>
                                <small class="count-selected"></small>
                            </a>
                        </header>

                        <section id="<?php echo $name_category ?>" class="panel-collapse collapse <?php if ($key == 0) echo 'in' ?>">
                            <section class="panel-body">
                                <?php

                                foreach ($filters as $filter) {
                                    $aux = explode(',', $filter);

                                    $id_filter   = $aux[0];
                                    $name_filter = $aux[1]; ?>

                                    <label class="checkbox" for="filter-<?php echo $id_filter ?>">
                                        <input id="filter-<?php echo $id_filter ?>" type="checkbox" value="<?php echo $id_filter ?>" />
                                        {{<?php echo $name_filter ?>}}
                                    </label>

                                <?php } ?>
                            </section>
                        </section>

                    </section>
                <?php } ?>

            </section>
        </section>
    <?php } ?>

</section>
