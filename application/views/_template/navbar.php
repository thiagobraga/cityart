<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Navbar header -->
            <a href="<?php echo base_url() ?>" class="navbar-brand"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($modules as $module) { ?>
                    <li class="navbar-<?php echo $module[1]; if (isset($module[3])) echo ' active' ?>">
                        <a href="<?php echo base_url($module[0]) ?>">
                            <?php echo $module[2] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav navbar-right navbar-icons">
                <li><a href="mailto:contato@cityart.com.br" target="_blank">
                    <i class="fa fa-envelope text-warning"></i>
                </a></li>
                <li><a href="tel:+14997774155" target="_blank">
                    <i class="ionicons ion-social-whatsapp text-warning"></i>
                </a></li>
                <li><a href="https://www.facebook.com/cityart.artes" target="_blank">
                    <i class="fa fa-facebook-official text-warning"></i>
                </a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>
