<?php if (isset($js)) {
    foreach ($js as $file) { ?>
        <script src="/assets/<?php echo $file ?>.js"></script>
    <?php }
} ?>
