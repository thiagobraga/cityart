<?php $this->load->view('new_bar/header') ?>

<section class="container new-bar">
    <section class="new-bar-form">
        <!-- Nav: Left nav bar -->
        <?php
        // Show the nav-register only for
        // new bar form.
        if ($controller != 'cities') {
            $this->load->view('new_bar/nav-register');
        } ?>

        <!-- Panel -->
        <section class="tab-register panel panel-default no-padding <?php if ($controller == 'cities') echo 'col-xs-offset-1' ?> col-xs-10">
            <header id="form-header" class="panel-heading <?php if ($controller == 'cities') echo 'hidden' ?>">
                <span id="panel-title">
                    {{register_start_title}}
                </span>

                <!-- Account reminder -->
                <?php $this->load->view('new_bar/account-info') ?>

                <small id="panel-subtitle"></small>
            </header>

            <!-- Tab-0: Start (terms of use) -->
            <?php $this->load->view('new_bar/starting')?>

            <!-- Tab-1: Confirming account -->
            <?php $this->load->view('new_bar/confirm-account') ?>

            <!-- Tab-2: Identification -->
            <?php $this->load->view('new_bar/identification') ?>

            <!-- Tab-3: Info -->
            <?php $this->load->view('new_bar/info') ?>

            <!-- Tab-4: Photos -->
            <?php $this->load->view('new_bar/photos') ?>

            <!-- Tab-5: Events -->
            <?php $this->load->view('new_bar/events') ?>

            <!-- Tab-6: Deals -->
            <?php $this->load->view('new_bar/deals') ?>

            <footer class="panel-footer hidden">
                <div class="row">
                    <section class="col-xs-3">
                        <button id="previous" class="btn btn-success pull-left hidden">
                            <span class="fa fa-angle-double-left"></span>
                            {{previous}}
                        </button>
                    </section>

                    <!-- Preloader -->
                    <section class="col-xs-6">
                        <div id="loader-submit" class="text-center block-center hidden">
                            <small id="loader-submit-status">{{creating_bar}}</small>
                            <div class="progress progress-striped active" style="height:8px; margin-bottom:0">
                                <div id="loader-submit-progress"
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Buttons -->
                    <section class="col-xs-3 text-right">
                        <!-- Submit page -->
                        <button id="btn-submit" class="btn btn-success hidden">{{submit_inclusion}}</button>

                        <!-- Next form -->
                        <button id="next"
                            class="btn btn-success next-page hidden"
                            data-current="register-info"
                            data-next="register-photos">

                            {{next}} <span class="fa fa-angle-double-right"></span>
                        </button>
                    </section>
                </div>
            </footer>
        </section>
    </section>
</section>

<!-- Alert modals -->
<?php
$this->load->view('new_bar/components/modal-alert-form-event');
$this->load->view('new_bar/components/modal-bar-added');
$this->load->view('new_bar/components/modal-category-not-allowed');
$this->load->view('new_bar/components/modal-is-profile');
$this->load->view('new_bar/components/modal-is-invalid-link');
$this->load->view('new_bar/components/modal-is-invalid-website');
$this->load->view('new_bar/components/modal-overwrite-address');
?>
