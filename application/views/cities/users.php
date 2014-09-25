<div class="panel panel-default panel-users">
    <div class="panel-heading">{{users_more_active_users}}</div>

    <!-- Entre seus amigos -->
    <?php if (isset($session['ainc_id_usuario'])) { ?>
        <div id="friends" class="hidden">
            <h6 class="panel-title">
                {{users_among_your_friends}}
                <img src="/assets/images/icons/body-facebook.png" alt="{{users_among_your_friends}}" class="users-facebook pull-right">
            </h6>

            <div class="panel-body">
                <table id="friend_list" class="table no-border">
                    <colgroup>
                        <col class="width-40" />
                        <col />
                        <col class="width-80" />
                    </colgroup>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php if ($usuarios) { ?>
        <!-- Ranking geral -->
        <h6 class="panel-title">{{users_general_ranking_cities}}</h6>

        <div class="panel-body">
            <table id="usuarios_cidade" class="table no-border">
                <colgroup>
                    <col class="width-40" />
                    <col />
                    <col class="width-80" />
                </colgroup>

                <?php
                $index_side_list = 4;
                $count = count($usuarios);
                $thereis_side_list = $count > $index_side_list;

                for ($i = 0; $i < $count; $i++) {
                    $usuario = $usuarios[$i];

                    $fb_id = $usuario->char_fbid_usuario;
                    $fb_profile = 'https://www.facebook.com/' . $fb_id;

                    $is_user = (
                        isset($session['ainc_id_usuario'])
                        && $session['ainc_id_usuario'] == $usuario->ainc_id_usuario
                    );

                    ?>
                    <tr <?php if ($is_user) { ?> class="user-row" <?php } ?>>
                        <td class="user-picture">
                            <img src="http://graph.facebook.com/<?php echo $fb_id ?>/picture?width=32&height=32"
                                class="thumbnail thumbnail-user"
                                width="32"
                                height="32"
                                data-href="<?php echo $fb_profile ?>"
                                data-target="_blank" />
                        </td>

                        <td class="user-info">
                            <a href="<?php echo $fb_profile ?>" target="_blank">
                                <span class="name"><?php echo $usuario->char_nomecompleto_usuario ?></span>
                                <?php if (strlen($usuario->char_local_usuario) > 18) { ?>
                                    <span class="location" title="<?php echo $usuario->char_local_usuario ?>">
                                        <?php echo sliceSentence($usuario->char_local_usuario, 18) ?>
                                    </span>
                                <?php } else { ?>
                                    <span class="location">
                                        <?php echo $usuario->char_local_usuario ?>
                                    </span>
                                <?php } ?>
                            </a>
                        </td>

                        <td class="user-points">
                            <a href="<?php echo $fb_profile ?>" target="_blank">
                                <?php echo $usuario->inte_pontos_cidade ?>
                                <?php if ($usuario->inte_pontos_cidade == 1) { ?>
                                    <small>{{navbar_point}}</small>
                                <?php } else { ?>
                                    <small>{{navbar_points}}</small>
                                <?php } ?>
                            </a>
                        </td>
                    </tr>

                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>
