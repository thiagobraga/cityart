<?php if (isset($js)) {
    foreach ($js as $file) { ?>
        <script src="/assets/<?php echo $file ?>.js"></script>
    <?php }
}

if (ENVIRONMENT === 'development') {
    $file = rtrim(base_url(), '/') . ':4040/';
    $file_headers = @get_headers($file);

    if ($file_headers) { ?>
        <script id="__bs_script__">
            document.write('<script async src="//HOST:4040/browser-sync/browser-sync-client.1.9.1.js"><\/script>'.replace(/HOST/g, location.hostname).replace(/PORT/g, location.port));
        </script>
    <?php }
} ?>
