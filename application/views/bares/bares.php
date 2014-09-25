<?php
$this->load->view('bares/header');
$this->load->view('bares/map');
?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-lg-9">
            <?php
            $this->load->view('bares/info');
            $this->load->view('bares/events');
            $this->load->view('bares/menu');
            $this->load->view('bares/reviews');
            if (count($last_users) > 0) {
                $this->load->view('bares/last-users');
            } ?>
        </div>

        <div class="col-xs-12 col-lg-3">
            <?php
            $this->load->view('bares/rating');
            if ($has_deals) {
                $this->load->view('bares/deals');
            }
            $this->load->view('bares/related-bars');
            $this->load->view('bares/top-3-bars');
            $this->load->view('bares/user-photos');
            ?>
        </div>
    </div>
</div>

<?php

// If user already reviewed this bar, do not load the component
if (!($session['has_rated'])) {
    $this->load->view('_template/components/rating-component');
}

$this->load->view('_template/components/rating-component-feedback');
$this->load->view('_template/components/modal-get-yourself-here');
$this->load->view('_template/components/modal-upload-photos');
?>
