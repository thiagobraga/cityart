<section id="is-client" class="col-xs-6 register-identification">
    <article class="text-center padding-top-20">
        <!--<img src="/assets/images/icons/new-bar-client.png"
            width="158"
            height="158"
            alt="{{bar_including}}"
            class="img-circle img-thumbnail cursor-pointer" />-->

        <!-- Client image -->
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="image-wrapper img-circle">
                    <img src="/assets/images/icons/new-bar-client.png"
                        width="158"
                        height="158"
                        alt="{{bar_including}}"
                        class="img-circle img-thumbnail cursor-pointer"/>
                </div>
            </div>
        </div>

        <!-- Block description -->
        <div class="row margin-top-20">
            <div class="col-xs-8 col-xs-offset-2">
                <p class="lead">{{im_client}}</p>
                <p>
                    {{client_that_includes}}
                    <a href="#" class="text-success js-display-popover" data-placement="top">
                        {{forever_remembered}}
                    </a>
                </p>
            </div>
        </div>
    </article>

    <section class="register-identification-content hidden">
        <main class="row margin-top-20">
            <section class="col-xs-12">
                <div class="add-with-facebook">
                    <span class="text-center">{{paste_the_fanpage_link_description}}</span>

                    <!-- Input -->
                    <form class="form-group form-horizontal has-feedback margin-top-20">
                        <div class="input-group">
                            <input id="facebook-href"
                                type="text"
                                class="form-control"
                                placeholder="{{paste_the_fanpage_link}}"
                                autocomplete="off" />

                            <span class="input-group-btn">
                                <button
                                    class="btn btn-success no-border-radius include-using-facebook"
                                    disabled>
                                        {{include}}</button>
                            </span>
                        </div>

                        <!-- Found fanpage by the user typing -->
                        <section id="found-fanpage" class="found-fanpage-item hidden">
                            <div class="col-xs-9 page-info no-padding">
                                <a id="fanpage-link" class="include-using-facebook" target="_blank" href="#">
                                    <img id="fanpage-image" width="48" height="48" class="pull-left thumbnail" />
                                    <p id="fanpage-name" class="name"></p>
                                    <p id="fanpage-location" class="location"></p>
                                </a>
                            </div>

                            <div class="col-xs-3 page-likes no-padding">
                                <a href="#"><span id="fanpage-likes" class="count"></span></a>
                            </div>
                        </section>

                        <!-- Here's where we added the custom `right` value in LESS -->
                        <span class="fa fa-check form-control-feedback hidden"
                            rel="tooltip"
                            title="{{page_valid}}"></span>

                        <span class="fa fa-times form-control-feedback hidden"
                            rel="tooltip"
                            title="{{page_not_valid}}"></span>

                        <img src="/assets/images/icons/feedback-preloader.gif"
                            class="preloader form-control-feedback hidden"
                            width="15"
                            height="12" />
                    </form>
                </div>
            </section>
        </main>

        <hr/>

        <footer>
            <p> {{add_bar_manually_as_client_description}} </p>

            <button id="manually-add-as-client" class="btn btn-success btn-lg">
                <small class="fa fa-circle-o-notch fa-spin hidden"></small>
                {{add_bar_manually_as_client}}</button>
            <br>
            <!--<button class="btn btn-facebook btn-sm">
                {{change_account_2}}
                <span class="fa fa-facebook"></button>-->
        </footer>

    </section>
</section>
