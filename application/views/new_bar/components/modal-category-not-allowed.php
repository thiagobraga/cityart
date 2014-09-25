<?php $regex = '/(\/)|[^\S\n]/'; ?>

<div id="modal-category-not-allowed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <header class="modal-header">
                <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{modal_category_not_allowed_title}}</h4>
            </header>

            <section class="modal-body">
                <p>{{inserted_link}} <b class="js-link"></b></p>

                <p>
                    {{modal_category_not_allowed_1}}
                    <b class="js-name"></b>
                    {{modal_category_not_allowed_2}}
                    <b class="js-category"></b>.<br/><br/>
                </p>

                {{modal_category_not_allowed_3}}<br/>

                <ul class="padding-left-5 two-columns">
                    <?php foreach ($config_global['facebook']['allowed_categories'] as $category) { ?>
                        <li>
                            <?php
                            echo '{{' . strtolower(
                                str_replace('&', 'and', preg_replace($regex, '_', $category))
                            ) . '}}' ?>
                        </li>
                    <?php } ?>
                </ul>
            </section>

            <footer class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">{{ok_got_it}}</button>
            </footer>
        </div>
    </div>
</div>
