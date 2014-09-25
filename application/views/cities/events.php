<?php if (count($eventos) > 0) { ?>
    <div class="panel panel-default panel-events">
        <div class="panel-heading">
            {{next_events_title}}<br/>
            <small><?php echo $occurring ?></small>
        </div>

        <div class="list-group list-group-event">

            <?php foreach ($eventos as $evento) {
                $link = $location->url . '/' . $evento->char_nomeamigavel_bar; ?>

                <div class="list-group-item">
                    <div class="row no-margin">
                        <div class="col-sm-9 no-padding">
                            <div class="content">
                                <a href="#" data-id="<?php echo $evento->ainc_id_eventobar ?>" data-toggle="modal" data-target="#myModal">
                                    <h4><?php echo $evento->char_titulo_eventobar ?></h4>
                                    <p><?php echo $evento->char_nome_bar ?></p>
                                    <small><?php echo $evento->char_endereco_bar ?></small>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-3 no-padding">
                            <div class="money text-right">
                                <a href="#" data-id="<?php echo $evento->ainc_id_eventobar ?>" data-toggle="modal" data-target="#myModal" data-placement="right" rel="tooltip" title="<?php echo 'R$ ' . number_format($evento->inte_faixapreco_eventobar, 2, ',', '.') ?>">
                                    <?php if ($evento->inte_faixapreco_eventobar <= 15.00) { ?>
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                    <?php } else if (
                                        $evento->inte_faixapreco_eventobar > 15.00
                                        && $evento->inte_faixapreco_eventobar < 50.00
                                    ) { ?>
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                    <?php } else { ?>
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                        <img src="/assets/images/icons/body-money.png" class="money-icon" />
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="date text-right">
                                <a href="#" data-id="<?php echo $evento->ainc_id_eventobar ?>" data-toggle="modal" data-target="#myModal">
                                    <?php echo date('d/m', strtotime($evento->stam_inicio_evento)) ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($evento->char_fbid_eventobar)) { ?>
                        <footer class="event-footer">
                            <a href="#" class="hidden">
                                <span>{{next_events_map}}</span>
                                <img src="/assets/images/icons/body-marker.png" alt="{{next_events_map}}" />
                            </a>
                            <a href="//facebook.com/events/<?php echo $evento->char_fbid_eventobar ?>" target="_blank">
                                <span>{{next_events_view_in_facebook}}</span>
                                <img src="/assets/images/icons/body-facebook-events.png" alt="{{next_events_view_in_facebook}}" />
                            </a>
                        </footer>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>
