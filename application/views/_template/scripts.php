<script src="https://maps.google.com/maps/api/js?key=AIzaSyDJNF02_xLETL0_H9t5W1jYSYLxhSp6OHs"></script>

<?php if (isset($js)) {
    foreach ($js as $file) { ?>
        <script src="<?php echo $file ?>"></script>
    <?php }
}

if (ENVIRONMENT === 'development') {
    $bsHost     = rtrim(base_url(), '/') . ':3000/';
    $getHeaders = @get_headers($bsHost);

    if ($getHeaders) { ?>
        <script id="__bs_script__">
            document.write('<script async src="http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6"><\/script>'.replace('HOST', location.hostname));
        </script>
    <?php }
} ?>
