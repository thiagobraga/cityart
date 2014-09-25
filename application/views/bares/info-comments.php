<section>
    <?php foreach ($comments as $i => $comment) {
        $time = strtotime($comment->stam_inclusao_comentariobar) - $bar->gmt_offset;
        $date = date('c', $time); ?>

        <div class="row comment">
            <section class="col-xs-2 no-padding-right text-center">
                <?php if ($i == 0) { ?>

                    <img src="http://graph.facebook.com/<?php echo $comment->char_fbid_usuario ?>/picture?width=68&height=68"
                        class="thumbnail thumbnail-user block-center"
                        data-href="http://facebook.com/<?php echo $comment->char_fbid_usuario ?>"
                        data-target="_blank"
                        width="68"
                        height="68" />

                <?php } else { ?>

                    <img src="http://graph.facebook.com/<?php echo $comment->char_fbid_usuario ?>/picture?width=50&height=50"
                        class="thumbnail thumbnail-user block-center"
                        data-href="http://facebook.com/<?php echo $comment->char_fbid_usuario ?>"
                        data-target="_blank"
                        width="50"
                        height="50" />

                <?php } ?>

                <p class="review-user-name">
                    <?php echo $comment->char_nome_usuario ?>
                </p>
            </section>

            <section class="col-xs-10">
                <blockquote>
                    <time data-fulldate="<?php echo $date ?>"
                        title="<?php echo $date ?>">
                    </time>

                    <p class="cursor-default">
                        <?php echo $comment->char_titulocomentario_comentariobar ?>
                    </p>
                    <small class="cursor-default">
                        <?php echo $comment->char_textocomentario_comentariobar ?>
                    </small>
                </blockquote>

                <span class="like-dislike">
                    <i id="like<?php echo $i ?>" class="fa fa-thumbs-up pull-left text-success" data-count="<?php echo $comment->int_likes ?>"></i>
                    <div id="count-like<?php echo $i ?>" class="count pull-left text-success" data-count="<?php echo $comment->int_likes ?>"><?php echo $comment->int_likes ?></div>

                    <i id="dislike<?php echo $i ?>" class="fa fa-thumbs-down pull-left text-danger" data-count="<?php echo $comment->int_dislikes ?>"></i>
                    <div id="count-dislike<?php echo $i ?>" class="count pull-left text-danger" data-count="<?php echo $comment->int_likes ?>"><?php echo $comment->int_dislikes ?></div>
                </span>
            </section>
        </div>
    <?php } ?>
</section>
