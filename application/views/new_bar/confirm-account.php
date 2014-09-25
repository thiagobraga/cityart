<div id="register-confirm" class="block-center text-center hidden">

    <!-- User info -->
    <div class="row margin-top-10">
        <div class="col-xs-12">
            <img src="//graph.facebook.com/<?php echo $session['char_fbid_usuario']?>/picture?width=128&amp;height=128"
                 width  ="128"
                 height ="128"
                 class  ="thumbnail block-center"> <br>

            <b><?php echo $session['char_nome_usuario'] . ' ' . $session['char_sobrenome_usuario'] ?></b>
        </div>
    </div>

    <!-- List -->
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <?php
            $count = count($is_admin_pages);
            if ($count > 0) { ?>
                <section class="panel panel-default panel-admin-pages margin-top-20">
                    <div class="panel-heading">
                        {{pages_that_you_manage}}
                        <small><?php echo $count . (($count > 1) ? ' {{pages}}' : ' {{page}}') ?></small>
                    </div>

                    <ul id="lista-bares" class="list-group">
                        <?php
                        foreach ($is_admin_pages as $page) {
                            $id         = $page['id'];
                            $name       = $page['name'];
                            $picture    = $page['picture'];
                            $category   = $page['category'];
                            $likes      = $page['likes'];
                            $is_allowed = $page['is_allowed'];
                            $is_registered = $page['is_registered'];
                            $barpedia_link = ($is_registered == true) ? $page['barpedia_link'] : '#';
                            $facebook_link = "https://www.facebook.com/$id";
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
                                        <!-- Otherwise, exhibit link to the Facebook page -->
                                        <?php } else { ?>
                                            <a href="<?php echo $facebook_link ?>" target="_blank" class="btn btn-default margin-top-10 margin-right-10 pull-right">
                                               <small>{{access}}</small>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- Alert -->
                                <?php if ($is_registered) { ?>
                                    <div class="row padding-bottom-5">
                                        <span class="col-xs-12 text-center">
                                            <span
                                                rel="tooltip"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Esta página já faz parte do Barpedia. Clique para acessá-la."
                                                class="label label-success">
                                                <a href="<?php echo $barpedia_link ?>"
                                                   class="color-white"
                                                   target="_blank">
                                                        {{already_exist}}
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
        </div>
    </div>

    <!-- Change or Confirm account -->
    <div class="row margin-top-10 margin-bottom-40">
        <p class="col-xs-12">
            <button class="btn btn-facebook btn-change-account">
                {{change_account}}
                <span class="fa fa-facebook"></span></button>

            <button class="btn btn-success btn-confirm-account">
                {{click_and_go}}</button>
        </p>
    </div>

</div>


