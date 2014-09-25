<div id="register-info" class="register-form">

    <!-- row-1 Name, website-->
    <div class="fieldset">
        <div class="row">
            <!-- Name -->
            <div class="col-xs-6">
                <label for="info-name">{{bar_name}}</label>
                <input id="info-name" type="text" value="<?php echo $bar->char_nome_bar ?>" />
            </div>

            <!-- Website -->
            <div class="col-xs-6">
                <label for="info-website">{{bar_website}}</label>
                <input id="info-website" type="text" value="<?php echo $bar->char_website_bar ?>" />
            </div>

            <!-- Facebook URL -->
            <p id="info-facebook" class="hidden"></p>
        </div>
    </div>

    <!-- row-2 Description-->
    <div class="row fieldset">
        <div class="col-xs-12">
            <label for="info-description">{{bar_description}}</label>

            <!-- Description -->
            <textarea id="info-description"
                rows="5"
                class="register-textarea">
                    <?php echo $bar->char_descricao_bar ?>
            </textarea>

            <span>
                <span class="counter">
                    <?php echo (300 - strlen($bar->char_descricao_bar)) ?>
                </span> {{characters}}
            </span>
        </div>
    </div>

    <!-- row 3 Phone, logo photo-->
    <div class="row">
        <div class="col-xs-7">
            <label for="info-phone">{{bar_phone}}</label>
            <input id="info-phone" type="text" value="<?php echo $bar->char_telefone_bar ?>" />
        </div>

        <label id="info-photo" class="col-xs-5 cursor-pointer">
            <input type="file" class="hidden input-photo" />
            <img class="preview-photo thumbnail"
                height="160"
                width ="160"
                src="/image/bares/<?php echo $bar->char_logo_bar ?>/160/160" />
        </label>
    </div>

    <!-- row 4 Office hours-->
    <div class="fieldset">
        <div class="row">
            <div class="col-xs-12">
                <div class="title title-underlined">
                    {{office_hours}}
                    <a href="#" class="fa fa-caret-up pull-right"></a>
                </div>
            </div>
        </div>

        <div class="row margin-top-20">
            <div id="info-office-hours" class="col-xs-12"></div>
        </div>
    </div>

    <!-- row 5 Address-->
    <div class="fieldset">
        <div class="row">
            <div class="col-xs-12">
                <div class="title title-underlined">
                    {{bar_address}}
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Street/ Region -->
            <div class="col-xs-6">
                <label for="info-street">{{bar_address_street}}</label>
                <input disabled
                    id    = "info-street"
                    type  = "text"
                    value = "<?php echo $bar->char_endereco_bar ?>" />
            </div>

            <div class="col-xs-6">
                <label for="info-district">{{bar_address_district}}</label>
                <input id="info-district" type="text" placeholder="Bairro" />
            </div>
        </div>

        <!-- City/ State/ Country/ Zip -->
        <div class="row">
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-7">
                        <label for="info-city"></label>
                        <input disabled
                            id    = "info-city"
                            type  = "text"
                            value = "<?php echo $bar->char_nomelocal_cidade ?>" />
                    </div>

                    <div class="col-xs-5">
                        <label for="info-region">{{bar_address_district}}</label>
                        <input disabled
                            id    = "info-region"
                            type  = "text"
                            value = "<?php echo $bar->char_nomelocal_estado ?>"/>
                    </div>
                </div>
            </div>

            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-7">
                        <label for="info-country">{{bar_address_district}}</label>
                        <input disabled
                            id    = "info-country"
                            type  = "text"
                            value = "<?php echo $bar->char_nomelocal_pais ?>" />
                    </div>

                    <div class="col-xs-5">
                        <label for="info-zip">{{bar_address_district}}</label>
                        <input disabled
                            id    = "info-zip"
                            type  = "text"
                            value = "<?php echo $bar->char_zip_bar ?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Row 6 Map -->
    <div class="row">
        <div class="col-xs-12">
            <span id="info-lat"><?php echo $bar->deci_longitude_bar ?></span>
            <span id="info-lon"><?php echo $bar->deci_latitude_bar  ?></span>
            <div class="title title-underlined padding-bottom-20">
                <img src="http://placehold.it/568x150&text=Map" class="img-responsive">
            </div>
        </div>
    </div>

    <div class="row margin-top-20 margin-bottom-20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-success next-page" data-value="#register-photos"> Next </button>
        </div>
    </div>
</div>
