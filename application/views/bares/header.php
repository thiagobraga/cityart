<header class="header-bares">
    <div class="container no-padding">

        <div class="col-xs-12 col-sm-12 col-md-7 bar-info no-padding-right no-padding-left">
            <?php if ($bar->char_logo_bar != '' || $bar->char_logo_bar=='none') { ?>
                <img src="/image/bares/<?php echo $bar->char_logo_bar ?>/95/95"
                    class="bar-logo"
                    width="95"
                    height="95" />
            <?php } ?>

            <?php
            // Selecting font size that will fit in our layout
            $len = strlen($bar->char_nome_bar);
            if ($len < 26) {
                $class = 'title-xl';
            } else if ($len < 45) {
                $class = 'title-lg';
            } else {
                $class = 'title-sm';
            } ?>

            <p class="title <?php echo $class ?>"><?php echo $bar->char_nome_bar ?></p>
            <h3><?php echo $bar->char_endereco_bar ?></h3>
            <h6>
                <a href="<?php echo 'https://www.facebook.com/' . $bar->char_fbid_usuario; ?>" target="_blank">
                    {{bar_added_by}}
                    <?php
                    echo ($this->session->userdata('ainc_id_usuario') != $bar->ainc_id_usuario)
                        ? $bar->char_nome_usuario . ' ' . $bar->char_sobrenome_usuario
                        : '{{you}}';
                    ?>
                </a>
            </h6>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 bar-web no-padding-right no-padding-left">
            <?php if (!empty($bar->char_facebook_bar)) { ?>
                <a href="<?php echo $bar->facebook_url ?>" class="bar-web-facebook" target="_blank">
                    <img src="/assets/images/icons/bars-facebook.png"
                        class="pull-left"
                        alt="<?php echo $bar->char_facebook_bar ?>"
                        width="24"
                        height="24" />

                    <p><?php echo $bar->char_facebook_bar ?></p>
                </a>
            <?php } ?>

            <?php if (!empty($bar->char_website_bar)) { ?>
                <a href="<?php echo $bar->char_website_bar ?>" class="bar-web-website" target="_blank">
                    <img src="/assets/images/icons/bars-website.png"
                        class="pull-left"
                        alt="<?php echo $bar->char_website_bar ?>"
                        width="24"
                        height="24" />

                    <p><?php echo $bar->website_alias ?></p>
                </a>
            <?php } ?>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-2 bar-contact no-padding-right no-padding-left">
            <img src="/assets/images/icons/bars-contact.png"
                class="pull-left"
                alt="<?php echo $bar->char_telefone_bar ?>"
                width="37"
                height="33" />

            <p class="phone-number"><?php echo $bar->char_telefone_bar ?></p>

            <!-- Showing the office hour -->
            <!-- If there is some opened office hours -->
            <!-- Preparing schedule -->
            <p class="office-hours cursor-default"
                <?php if (count($office_hours_bar['opened']) > 0) { ?>
                    data-html="true" data-placement="bottom" title="

                        <?php
                        foreach ($office_hours_bar['opened'] as $hour) {
                            if (isset($hour['is_open_today'])) {
                                $today = $hour; // Setting up info about today
                            }

                            $count = count($hour['days']);
                            $first = $hour['days'][0];
                            if ($count > 1) {
                                $last = $hour['days'][$count - 1];
                            } ?>

                            <!-- Printing days -->
                            {{<?php echo $first ?>}}-{{<?php echo $last ?>}}

                            <!-- Printing hours -->
                                   <?php echo date('G\hi ', strtotime($hour['start'])) ?>
                            {{to}} <?php echo date('G\hi ', strtotime($hour['end']))   ?> <br>

                        <?php } ?>"
                <?php } ?>>

                <!-- Set info about today -->
                <?php if (count($office_hours_bar['opened']) > 0) { ?>

                    <!-- If $today was found, set the office hour and print the status -->
                    <?php if (isset($today)) { ?>

                        <?php if ($config_bar['header']['display_office_hour']) { ?>
                            <?php if ($today['is_open_today']) {?>
                                <span class="label label-success label-sm">{{open}}</span>
                            <?php } else { ?>
                                <span class="label label-danger label-sm">{{closed}}</span>
                            <?php } ?>
                        <?php } ?>

                        ({{today}} <?php echo date('G:i', strtotime($today['start'])) ?>
                        {{to}}     <?php echo date('G:i', strtotime($today['end']))   ?>)

                    <!-- Else, the day was not defined, so it is closed -->
                    <?php } else { ?>

                        <span class="label label-danger label-sm">{{closed}}</span>
                        ({{no_hours}})

                    <?php } ?>
                <?php } else if (isset($session['ainc_id_usuario'])) { ?>

                    <a href="#" class="header-link">{{edit_office_hours}}</a>

                <?php } ?>
            </p>
        </div>
    </div>
</header>
