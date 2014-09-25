<?php $this->load->view('contact/header') ?>
<?php $this->load->view('contact/map') ?>

<div class="container">
    <div class="row">
        <div class="col-xs-9">
            <?php $this->load->view('contact/send-message') ?>
            <?php $this->load->view('contact/faq') ?>
        </div>

        <div class="col-xs-3">
            <?php $this->load->view('contact/about-us') ?>
        </div>
    </div>
</div>

<?php $this->load->view('contact/modal-feedback-sent') ?>
