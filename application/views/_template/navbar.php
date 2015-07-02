<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
                <li><a href="<?php echo base_url('empresa') ?>">A Empresa</a></li>
                <li><a href="<?php echo base_url('servicos') ?>">Serviços</a></li>
                <li><a href="<?php echo base_url('portfolio') ?>">Portfolio</a></li>
                <li><a href="<?php echo base_url('contato') ?>">Contato</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://facebook.com/cityart">
                    <span class="fa fa-facebook text-warning"></span>
                </a></li>
                <li><a href="http://pinterest.com/cityart">
                    <span class="fa fa-pinterest-p text-warning"></span>
                </a></li>
                <li><a href="http://behance.com/cityart">
                    <span class="fa fa-behance text-warning"></span>
                </a></li>
                <li><a href="mailto:contato@cityart.com.br">
                    <span class="fa fa-envelope-o text-warning"></span>
                </a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>
