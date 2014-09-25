<div class="alert alert-success-dark no-padding">
    <div class="alert-featured">
        <?php if (isset($session['ainc_id_usuario'])) { ?>
            <a href="<?php echo $location->url ?>/novo-bar">
        <?php } else { ?>
            <a data-toggle="modal" data-target="#modal-login-required" class="cursor-pointer">
        <?php } ?>
            <img src="/assets/images/icons/body-featured-marker.png"
                alt="{{featured_title}}"
                class="pull-left" />

            <h5>{{featured_title}}</h5>
            <p>
                {{featured_description}}
            </p>
        </a>
    </div>
</div>
