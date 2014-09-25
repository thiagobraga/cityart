<!-- Pages manager template -->

<div class="container">

    <!-- Options menu -->
    <div class="margin-top-50">
        <!--<ul class="nav nav-pills visible-xxs" role="tablist">
            <li class="active">
                <a href="#register-info" role="tab" data-toggle="tab">
                    <span class="fa fa-info-circle"></span>
                    {{info_about_bar}}
                </a>
            </li>

            <li>
                <a href="#register-photos" role="tab" data-toggle="tab">
                    <span class="fa fa-picture-o"></span>
                    {{photos_of_the_bar}}
                </a>
            </li>
        </ul>-->

        <ul class="nav nav-pills nav-stacked nav-register hidden-xxs" role="tablist">
            <li class="active">
                <a href="#register-info" role="tab" data-toggle="tab">
                    <span class="new-bar-info"></span>
                    {{info_about_bar}}
                </a>
            </li>

            <li>
                <a href="#register-photos" role="tab" data-toggle="tab">
                    <span class="fa fa-picture-o"></span>
                    {{photos_of_the_bar}}
                </a>
            </li>

            <li>
                <a href="#register-events" role="tab" data-toggle="tab">
                    <span class="fa fa-calendar-o"></span>
                    {{events_of_the_bar}}
                </a>
            </li>

            <li>
                <a href="#register-deals" role="tab" data-toggle="tab">
                    <span class="fa fa-money"></span>
                    {{deals_of_the_bar}}
                </a>
            </li>
        </ul>

        <!-- Forms -->
        <div class="tab-register panel panel-default">
            <div class="panel-heading">
                Informações sobre
                <?php echo $bar->char_nome_bar; ?>
                <small>
                    Para acessar a página, clique
                    <a href="<?php echo $bar->link; ?>" class="text-success"> aqui </a>
                </small>
            </div>

            <div class="panel-body">
                <!-- Tab-1: Info -->
                <?php $this->load->view('pages/info') ?>

                <!-- Tab-2: Photos -->
                <?php $this->load->view('new_bar/photos') ?>

                <!-- Tab-3: Events -->
                <?php $this->load->view('new_bar/events') ?>

                <!-- Tab-4: Deals -->
                <?php $this->load->view('new_bar/deals') ?>
            </div>
        </div>
    </div>
</div>
