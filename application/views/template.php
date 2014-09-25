<!DOCTYPE html>
<html lang="pt-br">

    <!-- HEAD -->
    <?php $this->load->view('_template/head') ?>

    <body>
        <!-- NAVBAR -->
        <?php $this->load->view('_template/navbar/navbar') ?>

        <!-- CONTENT -->
        <?php $this->load->view($content) ?>

        <!-- COMPONENTS -->
        <section class="components">
            <?php
            $this->load->view('_template/components/feedback');
            $this->load->view('_template/components/report');
            $this->load->view('_template/components/modal');
            $this->load->view('_template/components/modal-login-required');
            $this->load->view('_template/components/modal-add-your-facebook-page');
            $this->load->view('_template/components/redirect');
            $this->load->view('_template/components/thumbnail-highlight');
            $this->load->view('_template/components/tooltip-warning');
            ?>
        </section>

        <!-- FACEBOOK -->
        <div id="fb-root"></div>

        <!-- FOOTER -->
        <?php $this->load->view('_template/footer/footer') ?>

        <!-- SCRIPTS -->
        <?php $this->load->view('_template/scripts') ?>
    </body>
</html>
