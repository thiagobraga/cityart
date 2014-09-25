<section id="is-owner" class="col-xs-6 register-identification">
    <article class="text-center padding-top-20">
        <!--<img src="/assets/images/icons/new-bar-client.png"
            width="158"
            height="158"
            alt="{{bar_including}}"
            class="img-circle img-thumbnail cursor-pointer" />-->

        <!-- Owner image -->
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2">
                <div class="image-wrapper img-circle">
                    <img src="/assets/images/icons/new-bar-owner.png"
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
                <p class="lead">{{im_owner}}</p>
                <p>{{owner_that_includes}}</p>
            </div>
        </div>
    </article>

    <section class="add-with-facebook register-identification-content hidden">
        <?php
        $count = count($is_admin_pages);
        if ($count > 0) { ?>

            <p>{{include_using_facebook}}</p>
            <small>{{include_using_facebook_description}}</small>

            <section class="panel panel-default panel-admin-pages margin-top-20">
                <div class="panel-heading">
                    {{pages_that_you_manage}}
                    <small><?php echo $count . (($count > 1) ? ' {{pages}}' : ' {{page}}') ?></small>
                </div>

                <ul id="lista-bares" class="list-group">
                    <?php
                    foreach ($is_admin_pages as $page) {
                        $id            = $page['id'];
                        $name          = $page['name'];
                        $picture       = $page['picture'];
                        $category      = $page['category'];
                        $likes         = $page['likes'];

                        // TODO: Get from Barpedia config.
                        $is_allowed    = $page['is_allowed'];

                        $is_registered = $page['is_registered'];
                        $barpedia_link = ($is_registered == true) ? $page['barpedia_link'] : '#';
                        ?>

                        <li class="list-group-item cursor-default" <?php if (!$is_allowed) { ?> rel="tooltip" title="{{categories_not_allowed}}" <?php } ?>>

                            <!-- Bar -->
                            <div class="row">

                                <!-- Information about place -->
                                <div class="col-xs-7 page-info padding-top-5">
                                    <img src="<?php echo $picture ?>" width="48" height="48" class="pull-left thumbnail" />
                                    <p class="name"><?php echo $name ?></p>
                                    <p class="category">
                                        <?php echo $category ?>
                                    </p>
                                </div>

                                <!-- Total likes -->
                                <div class="col-xs-2 page-likes no-padding">
                                    <span class="count">
                                        <span class="fa fa-thumbs-up"></span>
                                        <?php echo $likes ?>
                                    </span>
                                </div>

                                <!-- Access or Include actions -->
                                <div class="col-xs-3 page-likes no-padding">
                                    <!-- If is registered, show Barpedia's bar link -->
                                    <?php if ($is_registered) { ?>
                                        <a href="<?php echo $barpedia_link ?>" class="btn btn-default margin-top-10 margin-right-10 pull-right">
                                           <small>{{access}}</small>
                                        </a>
                                    <!-- Otherwise, exhibit button to register this place -->
                                    <?php } else { ?>
                                        <button data-facebook-page="<?php echo $id ?>"
                                            class="owner-page btn btn-success margin-top-10 margin-right-10 pull-right"
                                            type="button">
                                                <small class="fa fa-circle-o-notch fa-spin hidden"></small>
                                                <small>{{include}}</small>
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Alert -->
                            <?php if ($is_registered) { ?>
                                <div class="row padding-bottom-5">
                                    <span class="col-xs-12 text-center">
                                        <span class="label label-success"
                                            title="Esta página já faz parte do Barpedia. Clique para acessá-la."
                                            data-placement="top">
                                            <a href="<?php echo $barpedia_link ?>"
                                                class="color-white"
                                                target="_blank">

                                                Já faz parte do Barpedia!
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            <?php } ?>
                        </li>

                    <?php } ?>
                </ul>
            </section>

        <?php } else { ?>

            <p><small>{{no_facebook_page_found}}</small></p>
            <small>{{your_account_does_not_administer_any_fanpage}}</small>

        <?php } ?>

        <hr/>
    </section>
</section>
