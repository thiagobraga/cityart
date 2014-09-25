<footer class="footer" role="contentinfo">
    <?php
    $this->load->view('_template/footer/about');
    if ($show_footer_bottom) {
        $this->load->view('_template/footer/bottom');
    }
    ?>
</footer>
