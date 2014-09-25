<!-- Entre seus amigos -->
<h5 class="title">{{bars_more_active_users}}</h5>

<div id="container-friends-from-facebook" class="hidden">
    <h6 class="subtitle">
        {{users_among_your_friends}}
        <img src="/assets/images/icons/body-facebook.png"
            alt="{{users_among_your_friends}}"
            class="icon-facebook pull-right" />
    </h6>

    <!-- Friends -->
    <table id="friends-from-facebook" class="table no-border">
        <colgroup>
            <col class="width-50" />
            <col />
            <col class="width-80" />
        </colgroup>
    </table>
</div>

<!-- Ranking geral -->
<?php if (count($top_users) > 0) { ?>
    <h6 class="subtitle">{{users_general_ranking_bars}}</h6>

    <table class="table no-border">
        <?php

        foreach ($top_users as $key => $user) {
            $fbid         = $user->char_fbid_usuario;
            $name         = $user->char_nomecompleto_usuario;
            $local        = $user->char_local_usuario;
            $points       = $user->int_reward_User_Bar_Contribution;
            $points_label = ($points == 1) ? 'navbar_point': 'navbar_points';

            $is_user = (
                isset($session['ainc_id_usuario'])
                && $session['ainc_id_usuario'] == $user->ainc_id_usuario
            );

            ?>

            <tr <?php if ($is_user) { ?> class="user-row" <?php } ?>
                data-toggle="my-highlight"
                data-target="#pic-<?php echo $fbid; ?>">

                <td class="user-picture">
                    <img id="pic-<?php echo $fbid; ?>"
                        src="http://graph.facebook.com/<?php echo $fbid ?>/picture?width=32&height=32"
                        class="thumbnail thumbnail-user <?php echo $is_user ?>"
                        data-href="https://www.facebook.com/<?php echo $fbid ?>"
                        data-target="_blank"
                        width="32"
                        height="32" />
                </td>

                <td class="user-info">
                    <a href="https://www.facebook.com/<?php echo $fbid ?>" target="_blank">
                        <span class="name"><?php echo $name ?></span>
                        <span class="location"><?php echo $local ?></span>
                    </a>
                </td>

                <td class="user-points">
                    <a href="<?php echo $fb_profile ?>" target="_blank">
                        <?php echo $points ?> <small>{{<?php echo $points_label ?>}}</small>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
