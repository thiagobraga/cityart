<span class="navbar-label-score">
    <span><?php echo $userpoints ?></span>
    <small>
        <?php echo ($userpoints == 1)
            ? '{{navbar_point_abbreviated}}'
            : '{{navbar_points_abbreviated}}';
        ?>
    </small>
</span>
