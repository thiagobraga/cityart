<!-- Toggle collapse button -->
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="fa fa-ellipsis-v option-icon"></span>
</button>

<!-- Navbar collapse contents -->
<div id="nav-collapse" class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
        <?php
        $this->load->view('_template/navbar/report-a-problem');
        $this->load->view('_template/navbar/new-bar');
        $this->load->view('_template/navbar/change-lang');

        $is_logged
            ? $this->load->view('_template/navbar/dropdown')
            : $this->load->view('_template/navbar/login');
        ?>
    </ul>
</div>
