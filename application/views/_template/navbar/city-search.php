<ul class="nav navbar-nav navbar-search hidden-xxs">
    <?php if ($show_city_search) { ?>
        <li>
            <a id="cidade-atual"
                href="#"
                class="navbar-marker"
                data-isopen="0"
                data-trigger="manual"
                data-placement="bottom"
                title="{{footer_choose_your_city_here}}">

                <?php if ($location) { ?>
                    <span>
                        <?php echo ucwords($location->char_nomelocal_cidade) . ', '
                            . (strlen($location->char_estado) == 2
                                ? strtoupper($location->char_estado)
                                : ucwords($location->char_estado)) ?> <b class="caret"></b>
                    </span>
                <?php } else { ?>
                    <span>
                        <?php echo ucwords($city->char_nomelocal_cidade) . ', '
                            . (strlen($city->char_uf_estado) == 2
                                ? strtoupper($city->char_uf_estado)
                                : ucwords($city->char_uf_estado)) ?> <b class="caret"></b>
                    </span>
                <?php } ?>
            </a>
        </li>
    <?php }

    if ($controller == 'bars') {
        $this->load->view('_template/navbar/everything-search');
    } ?>
</ul>

<!-- Typeahead form -->
<div id="typeahead-form"
    class="form-inline hidden hidden-xxs"
    role="form"
    style="position:absolute; z-index:15px">

    <div class="form-group has-feedback">
        <input id="nova-cidade"
            type="text"
            class="form-control typeahead no-border no-box-shadow"
            data-provide="typeahead"
            placeholder="{{navbar_type_the_city}}" />

        <!-- Preloader -->
        <span id="nova-cidade-preloader" class="form-control-feedback hidden">
            <img src="/assets/images/icons/typeahead-preloader.gif">
        </span>
    </div>
</div>
