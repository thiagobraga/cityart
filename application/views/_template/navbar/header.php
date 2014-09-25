<header class="navbar-header">
    <?php if ($controller != 'cities') { ?>
        <a href="<?php echo base_url() ?>"
            class="navbar-brand"
            title="{{back_to_home}} <?php echo $location->char_nomelocal_cidade ?>"
            data-placement="bottom">

            <img src="/assets/images/logo/logo-xs.png"
                alt="Barpedia"
                class="img-logo-xs pull-left hidden-lg hidden-md hidden-sm" />

            Barpedia
            <?php if ($config_global['stage'] != 'final') { ?>
                <span><?php echo $config_global['stage'] ?></span>
            <?php } ?>
        </a>
    <?php } else { ?>
        <a href="<?php echo base_url() ?>" class="navbar-brand">
            <img src="/assets/images/logo/logo-xs.png"
                alt="Barpedia"
                class="img-logo-xs pull-left hidden-lg hidden-md hidden-sm" />

            Barpedia
            <?php if ($config_global['stage'] != 'final') { ?>
                <span><?php echo $config_global['stage'] ?></span>
            <?php } ?>
        </a>
    <?php } ?>
</header>
