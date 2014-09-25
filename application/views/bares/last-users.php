<div class="panel panel-default">
    <div class="panel-heading padding-15">
        {{last_users}}

        <?php if(!$session['has_rated']) { ?>
            <button class="btn btn-sm btn-border-blue btn-get-yourself-here text-uppercase pull-right">
                {{get_yourself_here}}
            </button>
        <?php } ?>
    </div>

    <div class="panel-body margin-10">
        <div class="row">
            <?php foreach ($last_users as $key => $user) {
                $fb_id = $user->char_fbid_usuario;
                $name  = $user->char_nomecompleto_usuario;

                $reviews    = $user->inte_user_total_bars_reviews;
                $added_bars = $user->inte_user_total_added_bars;
                $points     = $user->inte_pontos_usuario;

                $reviews_label    = ($reviews == 1)   ? 'review'      : 'reviews';
                $added_bars_label = ($added_bars == 1)? 'added_bar'   : 'added_bars';
                $points_label     = ($points == 1)    ? 'navbar_point': 'navbar_points';

                $is_user = (isset($session['ainc_id_usuario'])
                    && $session['ainc_id_usuario'] == $user->ainc_id_usuario)
                        ? 'thumbnail-is-user' : '';

                ?>
                <div class="col-xs-2">
                    <div class="list-group-image row">
                        <!-- Adding tooltip if user is in the list -->
                        <?php if ($is_user) { ?>
                            <div class="my-tooltip tooltip-warning fade in top">
                                <div class="my-tooltip-inner">{{you}}</div>
                                <div class="tooltip-arrow my-tooltip-arrow"></div>
                            </div>
                        <?php } ?>

                        <img id="<?php echo $fb_id ?>"
                            src="http://graph.facebook.com/<?php echo $fb_id ?>/picture?width=52&amp;height=52"
                            class="thumbnail thumbnail-user <?php echo $is_user ?>"
                            data-href="https://www.facebook.com/<?php echo $fb_id?>"
                            data-target="_blank" />

                    </div>

                    <div class="row">
                        <p class="text-success"><?php echo $name ?></p>

                        <!-- Info about user: n° of reviews, added bars and points/votes -->
                        <p> <!-- Reviews -->
                            <span class="fa fa-clipboard"></span>
                            <?php echo $reviews ?>
                            {{<?php echo $reviews_label ?>}}
                        </p>

                        <p> <!-- Added bars -->
                            <span class="fa fa-glass"></span>
                            <?php echo $added_bars ?>
                            {{<?php echo $added_bars_label ?>}}
                        </p>

                        <p> <!-- Votes -->
                            <span class="fa fa-minus"></span>
                            <?php echo $points ?>
                            {{<?php echo $points_label ?>}}
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
