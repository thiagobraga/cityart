<?php if (count($ofertas) > 0) { ?>
    <div class="panel panel-default panel-list">
        <div class="panel-heading">
            {{last_deals_title}}
        </div>

        <!-- List group -->
        <div class="list-group list-group-deals">
            <?php foreach ($ofertas as $oferta) {
                switch (date('m', strtotime($oferta->stamp_start))) {
                    case 1: $month_start = 'Janeiro'; break;
                    case 2: $month_start = 'Fevereiro'; break;
                    case 3: $month_start = 'Março'; break;
                    case 4: $month_start = 'Abril'; break;
                    case 5: $month_start = 'Maio'; break;
                    case 6: $month_start = 'Junho'; break;
                    case 7: $month_start = 'Julho'; break;
                    case 8: $month_start = 'Agosto'; break;
                    case 9: $month_start = 'Setembro'; break;
                    case 10: $month_start = 'Outubro'; break;
                    case 11: $month_start = 'Novembro'; break;
                    case 12: $month_start = 'Dezembro';
                }

                switch (date('m', strtotime($oferta->stamp_finish))) {
                    case 1: $month_finish = 'Janeiro'; break;
                    case 2: $month_finish = 'Fevereiro'; break;
                    case 3: $month_finish = 'Março'; break;
                    case 4: $month_finish = 'Abril'; break;
                    case 5: $month_finish = 'Maio'; break;
                    case 6: $month_finish = 'Junho'; break;
                    case 7: $month_finish = 'Julho'; break;
                    case 8: $month_finish = 'Agosto'; break;
                    case 9: $month_finish = 'Setembro'; break;
                    case 10: $month_finish = 'Outubro'; break;
                    case 11: $month_finish = 'Novembro'; break;
                    case 12: $month_finish = 'Dezembro';
                }

                $day_start = date('d', strtotime($oferta->stamp_start));
                $day_finish = date('d', strtotime($oferta->stamp_finish));
                $year_start = date('y', strtotime($oferta->stamp_start));
                $year_finish = date('y', strtotime($oferta->stamp_finish));

                if ($month_start == $month_finish) {
                    $text = '{{last_deals_from}} ' . $day_start .
                        ' {{last_deals_to}} ' . $day_finish .
                        ' {{last_deals_of}} ' . $month_start;
                } else {
                    $text = '{{last_deals_from}} ' . $day_start .
                        ' {{last_deals_of}} ' . $month_start .
                        ' {{last_deals_to}} ' . $day_finish .
                        ' {{last_deals_of}} ' . $month_finish;
                }

                $image_source = '/image/ofertas/' . $oferta->char_filename . '/318/100';
                $link = $location->url . '/' . $oferta->char_nomeamigavel_bar; ?>

                <div class="list-group-item">
                    <div class="content">
                        <a href="<?php echo $link ?>">
                            <h4><?php echo $oferta->title ?></h4>
                            <small><?php echo $oferta->char_nome_bar ?></small>
                            <small><?php echo $text ?></small>

                            <div class="deals-footer">
                                <span class="col-xs-6 no-padding">
                                    {{last_deals_more_info}} <img src="/assets/images/icons/body-beer.png" alt="{{last_deals_more_info}}" />
                                </span>
                                <span class="col-xs-6 no-padding">
                                    {{see_in_the_map}} <img src="/assets/images/icons/body-marker.png" alt="{{last_deals_more_info}}" />
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="photo">
                        <a href="<?php echo $link ?>">
                            <img src="<?php echo $image_source ?>" />
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <!-- Nenhuma oferta cadastrada para essa cidade -->
<?php } ?>
