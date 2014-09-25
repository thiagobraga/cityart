<section id="register-deals" class="panel-body hidden">
    <form  class="form-horizontal" method="post" enctype="multipart/form-data">

        <!-- row-1 Deal-->
        <fieldset id="bar-deals">

            <!-- Warning -->
            <section class="well">
                {{register_events_warning}}
            </section>

            <!-- Form -->
            <section class="col-xs-12 well-light">

                <!-- Name -->
                <section class="col-xs-12">
                    <label for="deal-name">{{deal_title}}</label>
                    <input id="deal-name" type="text" class="form-control" required />
                </section>

                <!-- Date, short description and deal photo -->
                <section class="col-xs-12">

                    <!-- Date -->
                    <section class="col-xs-6">
                        <section class="col-xs-12 no-margin">

                            <!-- Date start -->
                            <section class="col-xs-5">
                                <label for="deal-date-start">{{valid_from}}</label>
                                <div id="deal-date-start" class="input-group date" rel="timepicker">
                                    <input type="text" class="form-control"/>
                                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                </div>
                            </section>

                            <!-- Date end -->
                            <section class="col-xs-5 col-xs-offset-1">
                                <label for="deal-date-end"> {{to_2}}  </label>
                                <div id="deal-date-end" class="input-group date" rel="timepicker">
                                    <input type="text" class="form-control"/>
                                    <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                                </div>
                            </section>
                        </section>

                        <!-- Short description -->
                        <section class="col-xs-11">
                            <label for="deal-other">
                                {{short_description}}
                                <span class="fa fa-info-circle cursor-pointer"
                                    title="{{deal_description_tooltip}}">
                                </span>
                            </label>
                            <input id="deal-other" type="text" class="form-control"/>
                        </section>
                    </section>

                    <!-- Event photo -->
                    <section class="col-xs-6">
                        <div class="text-center" style="width:165px">Foto</div>
                        <div>
                            <label class="cursor-pointer">
                                <picture id="deal-photo">
                                    <input type="file" class="hidden input-photo" />
                                    <img src="/assets/images/icons/add-logo-large.png"
                                        class="no-border-radius preview-photo"
                                        width="132"
                                        heigth="132"  />
                                </picture>
                            </label>
                        </div>
                    </section>
                </section> <!-- /End Date, event photo and price -->
            </section> <!-- /End well-light -->
        </fieldset>
    </form>

    <!-- Submit Page -->
    <fieldset class="row">
        <div class="col-xs-12 text-center">
            <button class="btn btn-primary">
                    <span class="fa fa-plus"></span>
                    {{include_deal}}</button>
        </div>
    </fieldset>

    <!-- Deal dashboard -->
    <div class="row no-margin">
        <div id="deals-dashboard" class="col-xs-12 dashboard block-center margin-top-30">
        </div>
    </div>
</section>
