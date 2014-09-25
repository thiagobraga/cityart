<section id="register-events" class="panel-body hidden">
    <form class="form-horizontal" method="post" enctype="multipart/form-data">

        <!-- URL -->
        <section class="col-xs-12">
            <label for="event-url">{{event_link_label}}</label>
            <input id="event-url"
                type="text"
                class="form-control"
                placeholder="{{event_link_placeholder}}"
                autofocus />

            <span class="help-block">{{event_link_help_block}}</span>
        </section>

        <!-- Fbid -->
        <input type="hidden" id="event-fbid" />

        <!-- Name -->
        <section class="col-xs-12">
            <label for="event-name">{{event_name}}</label>
            <input id="event-name"
                type="text"
                class="form-control"
                required />
        </section>

        <!-- Description -->
        <section class="col-xs-12">
            <label for="event-description">Descrição do evento</label>
            <textarea id="event-description"
                class="form-control"
                placeholder="Digite aqui a descrição do evento"
                rows="6"></textarea>

            <span class="help-block">
                <span class="counter">300</span> {{characters}}
            </span>
        </section>

        <!-- Date, event photo and price -->
        <section class="col-xs-12">

            <!-- Date and price -->
            <section class="col-xs-3">
                <label for="event-date"> {{event_date}} </label>

                <div id="event-date" class="input-group date" rel="timepicker">
                    <input type="text" class="form-control" data-inputmask="'mask': '99/99/9999'" />
                    <span class="input-group-addon">
                        <span class="fa fa-clock-o"></span>
                    </span>
                </div>

                <br>

                <!-- Price -->
                <label for="event-price"> {{event_price}} </label>
                <div class="input-group">
                    <span class="input-group-addon">{{currency}}</span>
                    <input id="event-price"
                        type="text"
                        class="form-control"
                        placeholder="10.00"
                        data-inputmask="'mask': '99.99'" />
                </div>
            </section>

            <!-- Hour -->
            <section class="col-xs-3 col-xs-offset-1">
                <label for="event-time">{{start_at}}</label>
                <section class="col-xs-12">
                    <div id="event-time-start" class="input-group date col-xs-7" rel="timepicker">
                        <input type="text" class="form-control"/>
                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                    </div>

                    <br>

                    <label for="event-price">{{finish_at}}</label>
                    <div id="event-time-end" class="input-group date col-xs-7" rel="timepicker">
                        <input type="text" class="form-control"/>
                        <span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
                    </div>
                </section>
            </section>

            <!-- Event photo -->
            <section class="col-xs-4 col-xs-offset-1">

                <div>
                    <label class="cursor-pointer">
                        <picture id="event-photo">
                            <input type="file" class="hidden input-photo" />
                            <img src="/assets/images/icons/add-logo-large.png"
                                class="preview-photo no-border-radius"
                                width="132"
                                heigth="132" />
                        </picture>
                    </label>
                </div>
            </section>
        </section>

        <button class="btn btn-primary show block-center">
            <span class="fa fa-plus"></span>
            {{include_event}}
        </button>
    </form>

    <!-- Event dashboard -->
    <div class="row no-margin">
        <div id="events-dashboard" class="col-xs-12 dashboard block-center margin-top-30"></div>
    </div>

</section>
