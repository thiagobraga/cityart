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
