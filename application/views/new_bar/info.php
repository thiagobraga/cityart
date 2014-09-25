<section id="register-info" class="panel-body hidden">
    <form class="form-horizontal">

        <!-- Bar info -->
        <fieldset id="bar-info">

            <!-- Facebook URL -->
            <p id="info-facebook" hidden></p>

            <!-- crazy Well -->
            <section class="row">
                <div class="well col-xs-12 margin-left-30 margin-right-30">
                    {{register_info_warning}}
                </div>
            </section>

            <!-- Name, website, telephone and logo -->
            <section class="row col-xs-12">

                <!-- Name, website, telephone -->
                <section class="col-xs-6">
                    <!-- Name -->
                    <section class="col-xs-12">
                        <label for="info-name">{{bar_name}}</label>
                        <input id="info-name" type="text" class="form-control" />
                    </section>

                    <!-- Website -->
                    <section class="col-xs-12">
                        <label for="info-website">{{bar_website}}</label>
                        <input id="info-website" type="text" class="form-control" />
                    </section>

                    <!-- Telephone -->
                    <section class="col-xs-12">
                        <label for="info-phone">{{bar_phone}}</label>
                        <input id="info-phone"
                            type="text"
                            class="form-control"
                            title="{{please_format_telnumber}}"
                             />
                    </section>
                </section>

                <!-- Logo -->
                <section class="col-xs-offset-2 col-xs-3 margin-top-30">
                    <label class="cursor-pointer">
                        <picture id="info-photo">
                            <span class="edit-image">

                                <span class="edit-image-action fa fa-pencil-square-o fa-4 hidden"
                                    title="{{change}}"></span>

                                <input type="file" class="hidden input-photo" />
                                <img src="/assets/images/icons/add-logo-large.png"
                                    class="preview-photo"
                                    width="216"
                                    height="216" />
                            </span>
                        </picture>
                    </label>
                </section>
            </section>

            <!-- Block 2: Description and Office hours -->
            <section class="row col-xs-12">

                <!-- Description -->
                <section class="col-xs-6 no-margin">
                    <label for="info-description">{{bar_description}}</label>
                    <textarea id="info-description"
                        class="form-control textarea-lg js-required"
                        placeholder="{{bar_description_placeholder}}"></textarea>

                    <span class="help-block">
                        <span class="counter">300</span> {{characters}}
                    </span>

                    <p class="info-description-example">
                        {{info_description_example}}
                    </p>
                </section>

                <!-- Office Hours -->
                <section id="bar-office-hours" class="col-xs-6 margin-bottom-0">
                    <label class="cursor-default">{{office_hours}}</label>
                    <?php $this->load->view('new_bar/components/info-office-hours') ?>
                </section>
            </section>
        </fieldset>

        <!-- Address -->
        <fieldset id="bar-address">
            <legend>{{bar_address}}</legend>

            <!-- Alert for empty (or wrong) coordinates -->
            <div id="info-position-alert" class="col-xs-12 hidden">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    {{info_position_alert}}
                </div>
            </div>

            <!-- Map -->
            <section class="col-xs-12 no-padding">

                <!-- Wrapper -->
                <div class="edit-position edit-position-disable">

                    <!-- Action button -->
                    <button class="btn btn-edit edit-position-action">
                        {{edit_position}}</button>

                    <!-- Canvas -->
                    <div id="map_canvas"
                         class="map map-md"
                         data-scroll="true"
                         data-draggable="true"
                         data-zoom="13">
                    </div>

                    <!-- Multi Markers -->
                    <div id="markers">
                        <span id="marker-1"
                            data-lat="<?php echo $this->data->location->deci_latitude_cidade ?>"
                            data-lng="<?php echo $this->data->location->deci_longitude_cidade ?>"
                            data-title="Place">
                        </span>
                    </div>
                </div>
            </section>

            <!-- Humam readable address -->
            <p id="info-formatted-address" hidden></p>

            <!-- Street -->
            <section class="col-xs-6">
                <label for="info-street">{{bar_address_street}}</label>
                <input id="info-street" type="text" class="form-control" />
            </section>

            <!-- District -->
            <section class="col-xs-6">
                <label for="info-district">{{bar_address_district}}</label>
                <input id="info-district" type="text" class="form-control" />
            </section>

            <!-- City -->
            <section class="col-xs-4">
                <label for="info-city">{{bar_address_city}}</label>
                <input id="info-city" type="text" class="form-control" />
            </section>

            <!-- Region -->
            <section class="col-xs-2">
                <label for="info-region">{{bar_address_region}}</label>
                <input id="info-region" type="text" class="form-control" />
            </section>

            <!-- Country -->
            <section class="col-xs-4">
                <label for="info-country">{{bar_address_country}}</label>
                <input id="info-country" type="text" class="form-control" />
            </section>

            <!-- Zip -->
            <section class="col-xs-2">
                <label for="info-zip">{{bar_address_zip}}</label>
                <input id="info-zip" type="text" class="form-control" />
            </section>
        </fieldset>
    </form>
</section>
