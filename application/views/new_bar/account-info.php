<?php
    $title = '';
    $pages = '';

    if($has_pages) {
        $title = 'pages_that_you_manage_point';
        foreach ($is_admin_pages as $page) {
            $pages .= '<br>' . $page['name'] . ' (' . $page['category'] . ')';
        }
    } else {
        $title = 'no_page';
    }
?>

<!-- Info -->
<span class="account-info cursor-default pull-right">
    <img src="//graph.facebook.com/<?php echo $session['char_fbid_usuario']?>/picture?width=32&amp;height=32"
         class ="thumbnail display-inline"
         width ="32"
         height="32">

    <b class="account-info-title" title="{{<?php echo $title ?>}} <?php echo $pages ?>">
        <?php echo $session['char_nome_usuario'] . ' ' . $session['char_sobrenome_usuario'] ?>
        (<?php echo count($is_admin_pages) ?>)
    </b>

    <!-- Change account -->
    <button class="btn btn-facebook btn-change-account">
        {{change_account_2}}
        <span class="fa fa-facebook"></span>
    </button>

    <!-- Dismiss reminder -->
    <!--<button class="btn btn-danger btn-close">
        <small>{{close}}</small>
    </button>-->
</span>

