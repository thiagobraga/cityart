<!-- User dropdown -->
<li class="dropdown user active">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <?php
        $this->load->view('_template/navbar/dropdown/score');
        $this->load->view('_template/navbar/dropdown/user');
        ?>
    </a>

    <section class="dropdown-menu dropdown-menu-user" role="menu">
        <?php
        $this->load->view('_template/navbar/dropdown/pages');
        $this->load->view('_template/navbar/dropdown/interations');
        $this->load->view('_template/navbar/dropdown/options');
        ?>
    </section>
</li>
