<?php if ($user_interations->events) { ?>
    <section class="interations">
        <header class="panel-heading">
            {{last_interations}}
        </header>

        <section class="interations-body">
            <?php foreach ($user_interations->events as $log) { ?>
                <a href="<?php echo $log['href'] ?>">
                    <section class="row">
                        <article class="col-xs-10 no-padding-right">
                            <?php echo $log['action'] ?>
                            <?php echo $log['object'] ?>
                            <time data-fulldate="<?php echo $log['stamp'] ?>"
                                title="<?php echo $log['stamp'] ?>">
                            </time>
                        </article>

                        <!-- Score -->
                        <article class="col-xs-2 no-padding-left text-right">
                            <span class="comment-rate">
                                <span class="label label-warning-inverted label-xlg">
                                    <?php echo $log['ponto'] ?>
                                </span>
                            </span>
                        </article>
                    </section>
                </a>
            <?php } ?>
        </section>

        <a href="/usuarios/pontuacao" class="btn btn-see-more btn-sm">{{see_more}}</a>
    </section>
<?php } ?>
