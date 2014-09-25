<?php if ($controller == 'cities') { ?>
    <header class="header-new-bar">
        <div class="container no-padding">
            <div class="row">
                <div class="col-xs-offset-1 col-xs-10">
                    <h1 id="title">{{you_are_the_first_to_arrive}}</h1>
                    <h3 id="subtitle">
                        {{this_is_a_unique_moment}} <?php echo $location->char_nome_cidade ?>.<br/>
                        {{enter_and_feel_free}}
                    </h3>
                </div>
            </div>
        </div>
    </header>
<?php } else { ?>
    <header class="header-new-bar">
        <div class="container no-padding">
            <h1 id="title">{{you_re_owner_or_client_of_a_bar}}</h1>
            <h3 id="subtitle">
                {{you_re_about_to_make_history_including_a_bar}}
                <a href="#" class="text-warning js-display-popover" data-placement="bottom">
                    {{you_re_about_to_make_history_including_a_bar_2}}
                </a>

                {{you_re_about_to_make_history_including_a_bar_3}}
            </h3>
        </div>
    </header>
<?php } ?>
