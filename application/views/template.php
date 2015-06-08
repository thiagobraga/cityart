<!DOCTYPE html>
<html lang="pt-br">

    <!-- HEAD -->
    <?php $this->load->view('_template/head') ?>

    <body>
        <!-- NAVBAR -->
        <?php $this->load->view('_template/navbar') ?>

        <!-- HEADER -->
        <?php $this->load->view('_template/header') ?>

        <!-- CONTENT -->
        <?php $this->load->view($content) ?>

        <!-- SCRIPTS -->
        <?php $this->load->view('_template/scripts') ?>
    </body>
</html>
