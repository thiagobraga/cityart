<?php $this->load->view('cities/header') ?>
<?php $this->load->view('cities/carousel') ?>
<?php $this->load->view('cities/alert') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <?php $this->load->view('cities/filters') ?>
            <?php $this->load->view('cities/events') ?>
        </div>

        <div class="col-sm-6">
            <?php $this->load->view('cities/more-bars') ?>
            <?php $this->load->view('cities/featured-bar') ?>
            <?php $this->load->view('cities/last-deals') ?>
            <?php $this->load->view('cities/last-images') ?>
        </div>

        <div class="col-sm-3">
            <?php $this->load->view('cities/users') ?>
            <?php $this->load->view('cities/most-rated-bars') ?>
        </div>
    </div>
</div>
