<?php if (!empty($reviews)) { ?>
    <section id="panel-comments-container" class="panel panel-default panel-reviews">
        <div class="panel-heading">
            <b class="font-weight-medium"><?php echo $total_reviews ?></b>
            <?php if ($total_reviews > 1) { ?>
                {{people_have_reviewed_this_bar_plural}}
            <?php } else { ?>
                {{people_have_reviewed_this_bar_singular}}
            <?php } ?>

            <!-- Rate button -->
            <?php if (isset($session['ainc_id_usuario'])) { ?>
                <!-- If user wasn't rated this bar yet. -->
                <?php if (!$session['has_rated']) { ?>
                    <button class="btn btn-success btn-open-rating-modal text-uppercase pull-right"
                        data-placement="left"
                        data-template="<?php echo $tooltip_warning ?>"
                        title="{{rating_component_how_about_share_your_opinion}}">
                        {{bar_give_your_opinion}}
                    </button>

                <!-- If this bar was already evaluated, show tooltip -->
                <?php } else { ?>
                    <button class="btn btn-success text-uppercase disabled pull-right"
                        title="{{rating_component_already_rated}}">
                        {{bar_give_your_opinion}}
                    </button>
                <?php } ?>
            <?php } ?>
        </div>

        <div id="panel-comments" class="panel-body">
            <?php foreach ($reviews as $key => $review) {

                $id   = $review->ainc_id_comentariobar;

                // Defining orientation of the bubble
                $side   = ($key % 2 == 0) ? 'left' : 'right';
                $bubble = ' bubble bubble-' . $side;
                $bubble .= ($side == 'right') ? ' margin-left-20' : ''; // Margin fix

                // Getting friendly name
                $aux              = explode(' ', $review->char_nome_usuario);
                $first_name       = $aux[0];
                $last_name        = $aux[count($aux) - 1];
                $complete_name    = $review->char_nome_usuario;
                $facebook_link    = 'http://facebook.com/' . $review->char_fbid_usuario;
                $facebook_picture = 'http://graph.facebook.com/' . $review->char_fbid_usuario .'/picture?width=68&height=68';

                // If last name has more than 10 characters, return only first letter
                // Concatenating first and last name
                $last_name = (strlen($last_name) > 10)
                    ? substr($last_name, 0, 1) . '.'
                    : $last_name;
                $name = $first_name . ' ' . $last_name;

                // {{AQUI}} Move it to a controller's method
                // load just fragment of the text. If users want to see the full text
                // an ajax request must be made
                // Comments
                $maxcount = 330;
                $has_more_text = strlen($review->char_textocomentario_comentariobar) > $maxcount;

                $fragment  = substr($review->char_textocomentario_comentariobar, 0, $maxcount);
                $is_hidden = (!$has_more_text) ? 'hidden' : '';
                $full_text = substr($review->char_textocomentario_comentariobar,    $maxcount);

                $time = strtotime($review->stam_inclusao_comentariobar) - $bar->gmt_offset;
                $date = date('c', $time);
                ?>

                <!-- Review template -->
                <div id="review-<?php echo $id ?>" class="review row margin-bottom-20">

                    <!-- Left side image -->
                    <?php if ($side == 'left') { ?>
                        <div class="col-xs-2 no-padding-right review-user">
                            <img src="<?php echo $facebook_picture ?>"
                                class="thumbnail thumbnail-user"
                                data-href="<?php echo $facebook_link ?>"
                                data-target="_blank"
                                width="68"
                                height="68" />

                            <p class="review-user-name text-center"><?php echo $name ?></p>
                        </div>
                    <?php } ?>

                    <!-- COMMENT -->
                    <div class="col-xs-8 review-comment <?php echo $bubble ?>">

                        <div class="row margin-bottom-5">
                            <div class="col-xs-12">
                                <span class="lead">
                                    <?php echo $review->char_titulocomentario_comentariobar ?>
                                </span>

                                <time class="moment-timeago pull-right" data-fulldate="<?php echo $date ?>"
                                    title="<?php echo $date ?>">
                                </time>
                            </div>
                        </div>

                        <!-- Comment block -->
                        <div class="row">
                            <div class="review-comment-display col-xs-12">
                                <!-- Fragment -->
                                <span class="review-comment-fragment">
                                    <?php echo $fragment ?>
                                </span>

                                <!-- Suspension points-->
                                <span class="suspension-points <?php echo $is_hidden ?>">...</span>

                                <!-- Full text -->
                                <span class="review-comment-full hidden">
                                    <?php echo $full_text ?>
                                </span>

                                <?php if ($has_more_text) { ?>
                                    <div class="review-comment-display pull-right">
                                        <!-- See more -->
                                        <a href="#" class="review-comment-more"
                                             data-id="<?php echo $id ?>"> {{see_more}} </a>

                                        <a href="#" class="text-success review-comment-less hidden"
                                             data-id="<?php echo $id ?>"> {{hide_text}} </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div> <!--/End comment text block -->
                    </div> <!-- /End Comment (bubble) -->

                    <!-- Right side image -->
                    <?php if ($side == 'right') { ?>
                        <div class="col-xs-2 no-padding-right review-user padding-left-20">
                            <img src="<?php echo $facebook_picture ?>"
                                class="thumbnail thumbnail-user"
                                data-href="<?php echo $facebook_link ?>"
                                data-target="_blank"
                                width="68"
                                height="68" />

                            <p class="review-user-name text-center"><?php echo $name ?></p>
                        </div>
                    <?php } ?>

                </div> <!-- /End Review block -->
            <?php } ?>
        </div>

        <div class="panel-footer text-center">
            <!-- Pagination -->
            <?php if ($pages > 1) { ?>
                <img src="/assets/images/icons/typeahead-preloader.gif" class="preloader invisible" />

                <button id="more-comments" class="btn btn-primary" data-value="5">
                    {{more_comments}}
                </button>
            <?php } ?>
        </div>
    </section>
<?php } ?>
