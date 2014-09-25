<?php if ($controller == 'cities') { ?>
    <!-- Terms of use -->
    <section id="register-starting" class="panel-body">

        <div class="row">
            <div class="col-xs-12 register-starting-description">
                <img src="/assets/images/logo/logo.png"
                    class="pull-left margin-right-15 margin-bottom-20"
                    width="200"
                    height="140" />

                <p class="register-starting-headline"><?php echo $location->char_nome_cidade ?> {{no_bar_headline}}</p>
                {{no_bar_description}}
                <a href="#" class="text-success js-display-popover" data-placement="top">
                    {{no_bar_description_your_name}}
                </a>
                {{no_bar_description_start_adding_a_bar}}
                <a href="/contact">{{no_bar_description_contact}}</a>
                {{no_bar_description_end}}

                <a href="<?php echo base_url($location->url . '/novo-bar') ?>" class="btn btn-success pull-right">
                    {{no_bar_ok_i_know_a_good_bar}}
                    <span class="fa fa-check"></span>
                </a>
            </div>
        </div>
    </section>
<?php } else { ?>
    <!-- Terms of use -->
    <section id="register-starting" class="panel-body">

        <div class="row">
            <div class="col-xs-12 register-starting-description">
                <img src="/assets/images/logo/logo.png"
                    class="pull-left margin-right-15 margin-bottom-20"
                    width="200"
                    height="140" />

                <p class="register-starting-headline">{{register_start_headline}}</p>
                {{register_starting_description}}<br/>

                <button class="btn btn-success js-agree pull-right">
                    {{ok_lets_go_2}}
                    <span class="fa fa-check"></span>
                </button>
            </div>
        </div>
    </section>
<?php } ?>
