<div class="footer-about">
    <div class="container">
        <div class="row">
            <article class="col-xs-12 col-sm-3">
                <h5>{{footer_about_title}}</h5>
                <p>
                    {{footer_about_description}}
                    <a href="<?php echo $location->url ?>/novo-bar"><b>{{footer_about_description_link}}</b></a>
                    {{footer_about_description_thanks}}
                </p>
            </article>

            <article class="col-xs-12 col-sm-3 most-active-cities">
                <h5>{{footer_more_active_cities}}</h5>
                <p>
                    <?php
                    $count = count($most_active_cities);
                    if ($count) {
                        foreach ($most_active_cities as $i => $city) { ?>
                            <a href="<?php echo base_url($city->char_uri_cidade) ?>" class="city">
                                <?php
                                echo $city->char_nome_cidade;

                                if ($city->char_uf_estado) {
                                    echo ' - ' . $city->char_uf_estado;
                                } else {
                                    echo ' - ' . $city->char_nome_pais;
                                } ?> (<?php echo $city->count . (($city->count == 1) ? ' {{bar_lowercase}}' : ' {{bars}}') ?>)
                            </a><?php if ($i != ($count - 1)) echo ', ' ?>
                        <?php }
                    } else { ?>
                        {{footer_no_bars_added_to_current_country}}<br/><br/>

                        <a href="<?php echo $location->url ?>/novo-bar" class="btn btn-primary">
                            {{include_bar}}
                        </a>
                    <?php } ?>
                </p>
            </article>

            <article class="col-xs-12 col-sm-3">
                <a href="<?php echo $location->url ?>/novo-bar">
                    <h5>{{footer_own_a_bar_title}}</h5>
                    <p>{{footer_own_a_bar_description}}</p>
                </a>
            </article>

            <article class="col-xs-12 col-sm-3">
                <a href="/contact">
                    <h5>{{footer_contact_title}}</h5>
                    <p>{{footer_contact_description}}</p>
                </a>
            </article>
        </div>
    </div>
</div>
