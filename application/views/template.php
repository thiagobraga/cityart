<!DOCTYPE html>
<html lang="pt-br">

    <!-- HEAD -->
    <?php $this->load->view('_template/head') ?>

    <body ng-app="ngMap" class="ng-scope">
        <!-- NAVBAR -->
        <?php $this->load->view('_template/navbar') ?>

        <!-- HEADER -->
        <?php $this->load->view('_template/header') ?>

        <!-- CONTENT -->
        <div class="container content <?php echo $controller ?>">
            <?php $this->load->view($content) ?>
        </div>

        <!-- FOOTER -->
        <?php $this->load->view('_template/footer') ?>

        <!-- SCRIPTS -->
        <?php $this->load->view('_template/scripts') ?>
    </body>
</html>
