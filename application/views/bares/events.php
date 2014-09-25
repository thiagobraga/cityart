<?php if (count($events) > 0) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">Eventos <?php echo $bar->char_nome_bar ?></div>

        <div class="panel-body">
                <?php foreach ($events as $key=>$event) {

                    // Events info
                    $id    = $event->ainc_id_eventobar;
                    $title = $event->char_titulo_eventobar;
                    $description = sliceSentence($event->char_descricao_eventobar, 200);
                    $charge = ($event->inte_faixapreco_eventobar == 0)
                        ? '{{no_charge}}'
                        : '<b>{{currency}}</b>' . i18n($event->inte_faixapreco_eventobar);

                    $aux = explode(' ', $event->stam_inicio_evento);
                    $start['date'] = strtotime($aux[0]);
                    $start['hour'] = strtotime($aux[1]);

                    /*$aux = explode(' ', $event->stam_fim_evento);
                    $end['date'] = $aux[0];
                    $end['hour'] = strtotime($aux[1]);*/

                    // Setting start and end hours
                    $hour = date('G\h', $start['hour']);
                    $date = array(
                        'day'   => array (
                                'number' => date('j', $start['date']),
                                'text'   => strtolower(date('D', $start['date']))
                            ),
                        'month' => strtolower(date('M', $start['date']))
                    );

                    // Creator of this event
                    $owner = $event->char_nome_usuario . ' ' . $event->char_sobrenome_usuario;

                    // Facebook info
                    $owner_facebook_link = 'https://www.facebook.com/' . $event->char_fbid_usuario;
                    $event_facebook_id   = $event->char_fbid_eventobar;
                    $event_facebook_link = 'https://www.facebook.com/' .$event->char_fbid_eventobar;
                    $image_facebook_link = 'https://graph.facebook.com/' . $event->char_fbid_eventobar . '/picture?width=170&height=100';
                    ?>

                    <div id="event-<?php echo $id ?>" class="box-event">
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="row">
                                    <div class="col-xs-12 margin-bottom-20">
                                        <h4 class="no-margin-bottom"><b> <?php echo $title ?> </b></h4>
                                        <small><?php echo $hour ?> | <?php echo $charge ?></small> <br>
                                        <small>
                                            {{bar_added_by}}
                                            <a href="<?php echo $owner_facebook_link ?>" target="_blank">
                                                <?php echo $owner; ?>
                                            </a>
                                        </small>
                                    </div>

                                    <div class="col-xs-12">
                                        <div class="row">

                                            <?php if ($event_facebook_id) { ?>
                                                <div class="col-xs-3 no-padding-right">
                                                    <img src="<?php echo $image_facebook_link ?>" class="img-responsive" width="170" height="75" />
                                                </div>
                                            <?php } ?>

                                            <div class="col-xs-9">
                                                <?php echo $description ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <?php if ($event_facebook_id) { ?>
                                    <a href="<?php echo $event_facebook_link ?>"
                                        target="_blank"
                                        class="btn btn-sm btn-border-blue text-uppercase pull-right cursor-pointer">
                                            {{check_on_fb}} <span class="fa fa-facebook-square"></span>
                                    </a>
                                <?php } ?>

                                <div class="box-event-calendar text-center pull-right">
                                    {{<?php echo $date['day']['text']?>}} <br>
                                    <?php echo $date['day']['number'] . '/'?>
                                    {{<?php echo $date['month'] ?>}}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <span class="pull-right btn-helpful cursor-pointer">
                                <span class="fa fa-caret-down"></span>
                                <span class="fa fa-flag"></span>
                            </span>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
<?php } ?>
