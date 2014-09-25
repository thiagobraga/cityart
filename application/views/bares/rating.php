<div class="panel panel-default">
    <!-- List group -->
    <ul class="list-group list-group-index">

        <!-- Pontuação -->
        <li class="list-group-item rating-points">
            <?php $this->load->view('bares/rating-points') ?>
        </li>

        <!-- O que este bar oferece? -->
        <?php if ($show_offers || isset($session['ainc_id_usuario'])) { ?>
            <li class="list-group-item rating-offers">
                <?php $this->load->view('bares/rating-offers') ?>
            </li>
        <?php } ?>

        <!-- Filtros -->
        <?php if ($unique_filtered) { ?>
            <li class="list-group-item list-group-filters">
                <?php $this->load->view('bares/rating-filters') ?>
            </li>
        <?php } ?>

        <!-- Usuários mais ativos -->
        <!-- If there is no users, hide title -->
        <?php $is_hidden = (count($top_users) > 0) ? '' : 'hidden'; ?>
        <li class="most-active-users list-group-item <?php echo $is_hidden ?>">
            <?php $this->load->view('bares/rating-most-active-users') ?>
        </li>

        <!-- Like/Share -->
        <?php if ($bar->char_facebook_bar != '') { ?>
            <li class="list-group-item list-group-facebook">
                <?php $this->load->view('bares/rating-facebook') ?>
            </li>
        <?php } ?>
    </ul>
</div>
