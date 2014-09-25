<?php if ($featuredBar) {
    $link = $location->url . '/' . $featuredBar->char_nomeamigavel_bar; ?>

    <section id="featured-bar" class="panel panel-default panel-featured">
        <header class="panel-heading">
            {{featured_bar_title}}

            <span class="bar-rate pull-right text-right" title="Avaliação deste bar">
                <?php if ($featuredBar->inte_nota_bar !== null) {
                    if ($featuredBar->inte_nota_bar > 4.5) { ?>
                        <span class="beer beer-<?php echo round($featuredBar->inte_nota_bar)?>"></span>
                    <?php } ?>
                    <span class="label label-warning label-lg">
                        <?php echo $featuredBar->formatted_nota_bar ?>
                    </span>
                <?php } ?>
            </span>
        </header>

        <section class="panel-body">
            <div class="row">
                <div class="photo col-xs-3">
                    <a href="<?php echo $link ?>">
                        <img src="/image/bares/<?php echo $featuredBar->char_logo_bar ?>/105/105/c"
                            class="img-shadow thumbnail thumbnail-bar"
                            width="105"
                            height="105" />
                    </a>
                </div>

                <!-- Informações -->
                <div class="content col-xs-9 no-padding-left">
                    <a href="<?php echo $link ?>">
                        <h5><?php echo $featuredBar->char_nome_bar ?></h5>
                        <h6><?php echo $featuredBar->char_endereco_bar ?></h6>
                    </a>

                    <div class="featured-bar-tags">
                        <?php if ($featuredBar->show_tags) {
                            if (count($featuredBar->tags['serves'])) {
                                foreach ($featuredBar->tags['serves'] as $category) {
                                    $tags = explode(';', $category->filtros);

                                    foreach ($tags as $key => $tag) {
                                        $aux = explode(',', $tag);

                                        $nome_filtro = $aux[0];
                                        $num_filtro  = $aux[1]; ?>

                                        <span id="<?php echo $key ?>" class="label label-default">
                                            <b><?php echo '{{' . $nome_filtro . '}}' ?></b>
                                        </span>
                                    <?php }
                                }
                            }

                            if (count($featuredBar->tags['unique'])) {
                                foreach ($featuredBar->tags['unique'] as $category) {
                                    $tags = explode(';', $category->filtros);
                                    $max_tag = 0;

                                    foreach ($tags as $key => $tag) {
                                        $aux = explode(',', $tag);
                                        $num_filtro  = (int) $aux[1];

                                        if ($num_filtro > $max_tag) {
                                            $max_tag = $num_filtro;
                                            $nome_filtro = $aux[0];
                                        }
                                    } ?>

                                    <span id="<?php echo $key ?>" class="label label-default">
                                        <b><?php echo '{{' . $category->char_titulo_filtrobarcategoria . '}}:' ?></b> <?php echo '{{' . $nome_filtro . '}}' ?>
                                    </span>
                                <?php }
                            } ?>

                            <br/>

                            <?php if (count($featuredBar->tags['multiple'])) {
                                foreach ($featuredBar->tags['multiple'] as $category) {
                                    $tags = explode(';', $category->filtros);

                                    foreach ($tags as $key => $tag) {
                                        $aux = explode(',', $tag);

                                        $nome_filtro = $aux[0];
                                        $num_filtro  = $aux[1]; ?>

                                        <span id="<?php echo $key ?>" class="label label-default">
                                            <?php echo '{{' . $nome_filtro . '}}' ?>
                                        </span>
                                    <?php }
                                }
                            }
                        } else { ?>
                            <article class="well">
                                <a href="<?php echo $link ?>">{{featured_bar_this_bar_does_not_have_reviews}}</a>
                            </article>
                        <?php } ?>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="description">
                    <p><?php echo $featuredBar->char_descricao_bar ?></p>

                    <a href="<?php echo $link ?>" class="btn btn-success pull-right">
                        {{see_more}}
                    </a>
                </div>
            </div>
        </section>
    </section>
<?php } ?>
