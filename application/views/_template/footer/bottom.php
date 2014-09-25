<div class="footer-bar">
    <div class="footer-url pull-right text-right">
        <a href="/" title="{{footer_our_mission}}">
            Barpedia.org
        </a>
    </div>

    <?php $this->load->view('_template/footer/change-lang') ?>

    <div class="container">
        <?php if ($show_city_search) { ?>
            <a id="cidade-atual-footer"
                href="#"
                class="footer-marker"
                data-isopen="0">

                <?php if ($location) { ?>
                    <span>
                        <?php echo ucwords($location->char_nomelocal_cidade) . ', '
                            . (strlen($location->char_estado) == 2
                                ? strtoupper($location->char_estado)
                                : ucwords($location->char_estado)) ?>
                    </span>
                <?php } else { ?>
                    <span>
                        <?php echo ucwords($city->char_nomelocal_cidade) . ', '
                            . (strlen($city->char_uf_estado) == 2
                                ? strtoupper($city->char_uf_estado)
                                : ucwords($city->char_uf_estado)) ?>
                    </span>
                <?php } ?>
            </a>
        <?php } ?>
    </div>
</div>

<!-- Typeahead form -->
<div id="typeahead-form-footer" class="form-inline hidden hidden-xxs" role="form" style="position:absolute; z-index:15px">
    <div class="form-group has-feedback">
        <!-- Input -->
        <input id="nova-cidade"
            type="text"
            data-provide="typeahead"
            class="form-control typeahead no-border no-box-shadow"
            placeholder="{{navbar_type_the_city}}" />

        <!-- Preloader -->
        <span id="nova-cidade-preloader" class="form-control-feedback hidden">
            <img src="/assets/images/icons/typeahead-preloader.gif">
        </span>
    </div>
</div>
