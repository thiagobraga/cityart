<head>
    <meta charset="utf-8" />
    <meta name="author" content="Instituto Soma" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

    <!-- SEO -->
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>" />
    <meta name="keywords" content="<?php echo $keywords ?>" />

    <!-- ICONS -->
    <link href="<?php echo base_url('assets/images/icons/favicon.ico') ?>" rel="shortcut icon" />

    <!-- FACEBOOK -->
    <?php
    $url = base_url(uri_string());

    if ($controller == 'bares') { ?>

        <meta property="og:title" content="{{the}} <?php echo $bar->char_nome_bar ?> {{is_also_in}} {{barpedia_encyclopedia}}" />
        <meta property="og:description" content="{{the}} <?php echo $bar->char_nome_bar ?> {{facebook_description}}" />

        <?php if ($bar->char_logo_bar != '') { ?>
            <meta property="og:image" content="<?php echo base_url('/image/bares/' . $bar->char_logo_bar . '/200/200') ?>" />
        <?php } else { ?>
            <meta property="og:image" content="<?php echo base_url('assets/images/logo/facebook.png') ?>" />
        <?php } ?>

    <?php } else { ?>

        <meta property="og:title" content="{{barpedia_encyclopedia}}" />
        <meta property="og:description" content="{{home_description}}" />
        <meta property="og:image" content="<?php echo base_url('assets/images/logo/facebook.png') ?>" />

    <?php }?>

    <meta property="og:site_name" content="<?php echo $url ?>" />
    <meta property="og:url" content="<?php echo $url ?>" />
    <meta property="og:type" content="website" />

    <?php if (get_cookie('local_locale')) { ?>
        <meta property="og:locale" content="<?php echo get_cookie('local_locale') ?>" />
    <?php } else { ?>
        <meta property="og:locale" content="<?php echo $config_global['languages']['default']['file'] ?>" />
    <?php } ?>

    <meta property="fb:admins" content="100007378261765" />
    <meta property="fb:app_id" content="237267543113267" />

    <!-- HTML5 SUPPORT FOR IE6-8 -->
    <!--[if lt IE 9]>
    <script src="assets/bower/html5shiv/dist/html5shiv.min.js"></script>
    <script src="assets/bower/respond/dest/respond.min.js"></script>
    <![endif]-->

    <!-- CSS -->
    <?php if (isset($css)) {
        foreach ($css as $file) { ?>
            <link href="/assets/<?php echo $file ?>.css" rel="stylesheet" />
        <?php }
    } ?>
</head>
