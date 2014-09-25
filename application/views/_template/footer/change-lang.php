<div id="change-lang-dropdown-footer" class="change-lang dropup pull-right">
    <!-- Current lang -->
    <?php
    $cookie_locale = $locale;
    $locale        = $config_global['languages']['available'][$cookie_locale];
    ?>

    <a href="#"
        id="change-lang-current"
        data-toggle="dropdown"
        data-target="#"
        data-value="<?php echo $cookie_locale ?>">

        <span class="flag16 <?php echo strtolower($locale['iso_country']) ?>"></span>
        <span><?php echo $locale['name'] ?></span>
        <span class="caret"></span>
    </a>

    <!-- Available languages -->
    <ul class="dropdown-menu" role="menu" aria-labelledby="change-lang-current">
        <?php
        $available_lang = $config_global['languages']['available'];
        foreach ($available_lang as $index => $lang) {

            if ($index != $cookie_locale) {
                $flag  = strtolower($lang['iso_country']);
                $file  = $lang['file'];
                $name  = $lang['name'];
                ?>

                <li data-value="<?php echo $file ?>">
                    <a href="#">
                        <span class="flag16 <?php echo $flag ?>"></span>
                        <span><?php echo $name ?></span>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul>
</div>
