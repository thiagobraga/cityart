<head>
    <meta charset="utf-8" />
    <meta name="author" content="Thiago Braga" />
    <meta name="robots" content="index, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="google-site-verification" content="yztVWnFLPo4PYGdbvfjgn7TfZgRETzwCG4j8p7ICODI" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />

    <!-- SEO -->
    <title><?php echo $title ?></title>
    <meta name="description" content="<?php echo $description ?>" />
    <meta name="keywords" content="<?php echo $keywords ?>" />

    <!-- ICONS -->
    <link href="/assets/images/dist/favicons/favicon.ico" rel="shortcut icon" />
    <link href="/assets/images/dist/favicons/apple-touch-icon.png" rel="apple-touch-icon" sizes="57x57" />
    <link href="/assets/images/dist/favicons/apple-touch-icon-76x76.png" rel="apple-touch-icon" sizes="76x76" />
    <link href="/assets/images/dist/favicons/apple-touch-icon-120x120.png" rel="apple-touch-icon" sizes="120x120" />
    <link href="/assets/images/dist/favicons/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
    <link href="/assets/images/dist/favicons/apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="/assets/images/dist/favicons/icon-hires.png" rel="icon" sizes="192x192" />
    <link href="/assets/images/dist/favicons/icon-normal.png" rel="icon" sizes="128x128" />

    <!-- CSS -->
    <?php if (isset($css)) {
        foreach ($css as $file) { ?>
            <link href="<?php echo $file ?>" rel="stylesheet" />
        <?php }
    } ?>
</head>
