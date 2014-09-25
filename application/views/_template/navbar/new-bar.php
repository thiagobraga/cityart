<li>
    <?php
    // If user is logged, redirect to register page.
    // Otherwise, display pop-up to login.
    if ($is_logged) { ?>
        <a href="<?php echo $location->url ?>/novo-bar" class="add-bar">
            {{navbar_suggest_a_bar}}
        </a>
    <?php } else { ?>
        <a href="#"
            class="add-bar cursor-pointer"
            data-toggle="modal"
            data-target="#modal-login-required">
            {{navbar_suggest_a_bar}}
        </a>
    <?php } ?>
</li>
