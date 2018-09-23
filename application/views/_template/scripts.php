<script src="https://maps.google.com/maps/api/js?key=AIzaSyDJNF02_xLETL0_H9t5W1jYSYLxhSp6OHs"></script>

<?php if (isset($js)) {
    foreach ($js as $file) { ?>
        <script src="<?php echo $file ?>"></script>
    <?php }
}

if (ENVIRONMENT === 'development' && @get_headers("http://{$_SERVER['REMOTE_ADDR']}:3000")) { ?>
  <script async src="http://<?php echo $_SERVER['REMOTE_ADDR'] ?>:3000/browser-sync/browser-sync-client.js?v=2.24.7"></script>
<?php } ?>
