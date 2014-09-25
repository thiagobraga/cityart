<?php if (count($similarPlaces) > 0) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{related_bars}}
        </div>

        <ul class="list-group list-group-unstyled">
            <?php
            foreach ($similarPlaces as $key => $place) {

                $logo          = $place['char_logo_bar'];
                $name          = $place['char_nome_bar'];
                $link          = $place['char_link_bar'];
                $address       = $place['char_endereco_bar'];
                $chunk_address = sliceSentence($address, 20);
                $relationship  = ROUND($place['similarity'] * 100);
                $tooltip       = '';

                foreach ($place['filters'] as $key => $filter) {
                    $pct         = $filter->pct * 100 . '%';
                    $filter_name = $filter->char_texto_filtrobar;
                    $alias       = $filter->char_titulo_filtrobarcategoria . '_alias';

                    $tooltip.= $pct . ' {{' . $alias . '}} {{' .$filter_name . '}}<br>';
                }
                ?>

                <li class="list-group-item row margin-10 min-height-60 no-padding">
                    <div class="col-xs-3 no-padding-right no-padding-left list-group-image">
                        <img src="/image/bares/<?php echo $logo ?>/48/48"
                            class="thumbnail thumbnail-bar"
                            data-href="<?php echo $link ?>"
                            width="50"
                            height="50" />
                    </div>

                    <div class="col-xs-6 no-padding-right no-padding-left">
                        <a href="<?php echo $link ?>">
                            <?php echo $name ?><br>

                            <small title="<?php echo $address ?>"
                                data-placement="bottom">
                                <?php echo $chunk_address ?>
                            </small>
                        </a>
                    </div>

                    <div class="col-xs-3 no-padding-left no-padding-right"
                        data-placement="top"
                        title="<?php echo $tooltip; ?>">

                        <a href="<?php echo $link ?>">
                            <h2 class="no-margin"><?php echo $relationship ?>%</h2>
                        </a>
                    </div>
                </li>

            <?php } ?>
        </ul>
    </div>

<?php } ?>
