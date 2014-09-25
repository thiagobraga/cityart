<?php if ($places) {
    foreach ($places as $place) {
        $link = $location->url . '/' . $place->char_nomeamigavel_bar; ?>

        <section class="panel panel-default panel-places">
            <header class="panel-heading row">
                <div class="col-xs-10">
                    <?php echo $place->char_nome_bar ?><br/>
                    <small><?php echo $place->char_endereco_bar ?></small>
                </div>

                <div class="col-xs-2">
                    <span class="bar-rate pull-right text-right <?php if ($place->inte_nota_bar < 4.5) echo 'no-badge' ?>" title="Avaliação deste bar">
                        <?php if ($place->inte_nota_bar != 0 && $place->inte_nota_bar !== null) {
                            if ($place->inte_nota_bar >= 4.5) { ?>
                                <span class="beer beer-<?php echo round($place->inte_nota_bar)?>"></span>
                            <?php } ?>
                            <span class="label label-warning label-lg">
                                <?php echo $place->formatted_nota_bar ?>
                            </span>
                        <?php } ?>
                    </span>
                </div>
            </header>

            <section class="panel-body">
                <div class="row">
                    <div class="photo col-xs-2">
                        <a href="<?php echo $link ?>">
                            <img src="/image/bares/<?php echo $place->char_logo_bar ?>/105/105/c"
                                class="img-shadow thumbnail thumbnail-bar"
                                width="105"
                                height="105" />
                        </a>
                    </div>

                    <!-- Informações -->
                    <div class="content col-xs-10">
                        <!-- Descrição -->
                        <div class="description">
                            <p><?php echo $place->char_descricao_bar ?></p>
                        </div>

                        <div class="featured-bar-tags">
                            <?php if ($place->show_tags) {
                                if (count($place->tags['serves'])) {
                                    foreach ($place->tags['serves'] as $category) {
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

                                if (count($place->tags['unique'])) {
                                    foreach ($place->tags['unique'] as $category) {
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

                                <?php if (count($place->tags['multiple'])) {
                                    foreach ($place->tags['multiple'] as $category) {
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
                            } ?>
                        </div>

                        <a href="<?php echo $link ?>" class="btn btn-success pull-right">
                            {{see_more}}
                        </a>
                    </div>
                </div>
            </section>
        </section>
    <?php }
} ?>
