<?php if (count($menu) > 0) { ?>
<div class="panel panel-default panel-menu">
    <div class="panel-heading-menu">
        <h4>Itens mais sugeridos</h4>
    </div>

    <div class="panel-group panel-body" id="menuCollapse">
        <?php foreach ($menu as $key => $item) {

            $id   = $item->ainc_id_menuitem;
            $name = $item->char_name_menuitem;
            $indications_counter = $item->inte_total_indications;
            $indications_counter_label = ($indications_counter > 1)
                ? 'indications_counter_plural'
                : 'indications_counter_singular';

            $panel_id  = 'item-' . $id;
            $panel_reference = '#' . $panel_id;
        ?>
            <!--- Panel -->
            <div class="panel panel-default">

                <!-- Title: name of the item -->
                <div class="panel-heading no-padding">
                    <a data-toggle="collapse"
                       data-parent="#menuCollapse"
                       href="<?php echo $panel_reference ?>">
                            <div class="padding-top-10 padding-left-20 padding-right-20 padding-bottom-8">
                                <?php echo $name; ?>
                                <span class="pull-right">
                                    <?php echo $indications_counter ?>
                                    {{<?php echo $indications_counter_label ?>}}
                                    <span class="fa fa-caret-down"></span>
                                </span>
                            </div>
                    </a>
                </div>

                <!-- Comments -->
                <div id="<?php echo $panel_id ?>" class="panel-collapse collapse">
                    <div class="panel-body no-padding">

                        <!-- Listing chunk of comments -->
                        <?php foreach ($item->indications as $key => $indication) {
                            $picture = 'https://graph.facebook.com/'
                                . $indication->char_fbid_usuario
                                . '/picture?width=48&height=48';
                            $name    = $indication->char_nomecompleto_usuario;
                            $comment = $indication->char_comment;
                            ?>

                            <div class="row title-underlined padding-top-10 padding-bottom-10">
                                <div class="col-xs-2 no-padding-right">
                                    <div class="text-center block-center">
                                        <img class="thumbnail block-center" src="<?php echo $picture ?>" />
                                        <small class="text-success"><?php echo $name ?></small>
                                    </div>
                                </div>

                                <div class="col-xs-10 no-padding-left">
                                    <div class="padding-right-10"><?php echo $comment ?></div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!--<div class="panel-footer">
        Ver mais 1, 2, 3
    </div> -->
</div>
<?php } ?>
