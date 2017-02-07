<script src="https://maps.google.com/maps/api/js?key=AIzaSyDJNF02_xLETL0_H9t5W1jYSYLxhSp6OHs"></script>

<?php if (isset($js)) {
    foreach ($js as $file) { ?>
        <script src="<?php echo $file ?>"></script>
    <?php }
}

if (ENVIRONMENT === 'development') {
    $file = rtrim(base_url(), '/') . ':4040/';
    $file_headers = @get_headers($file);

    if ($file_headers) { ?>
        <script id="__bs_script__">
            document.write('<script async src="http://HOST:4040/browser-sync/browser-sync-client.js?v=2.8.16"><\/script>'.replace('HOST', location.hostname));
        </script>
    <?php }
} ?>
