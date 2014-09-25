<div id="rating-component" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog rating-component">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>
                    {{rating_component_title}} <?php echo $bar->char_nome_bar ?>

                    <small class="pull-right rating-component-points">
                        {{rating_component_user_points}}
                        <span id="assigned-points" class="text-success font-weight-semi-bold">0</span>
                    </small>
                </h4>
            </div>

            <div class="modal-body no-padding-bottom">
                <div class="row">
                    <!-- Rating blocks -->
                    <div id="rating-component-accordion" class="col-xs-7 no-padding-right panel-group">

                        <!-- 1st Panel - Bar's rating. User gives a rate for the bar -->
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <!-- Panel -->
                                <div id="panel-1" class="panel panel-default" data-next="#panel-2" data-value="1">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-1">
                                            {{rating_component_rate}}
                                            <span class="fa fa-chevron-circle-down pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-1" class="panel-collapse collapse in">
                                        <div class="panel-body beer-rate-container">
                                            <div class="beer-rate text-center">
                                                <span class="beer beer-empty" data-value="1" title="{{rate_vote_1}}" data-placement="left"></span>
                                                <span class="beer beer-empty" data-value="2" title="{{rate_vote_2}}" data-placement="top"></span>
                                                <span class="beer beer-empty" data-value="3" title="{{rate_vote_3}}" data-placement="bottom"></span>
                                                <span class="beer beer-empty" data-value="4" title="{{rate_vote_4}}" data-placement="top"></span>
                                                <span class="beer beer-empty" data-value="5" title="{{rate_vote_5}}" data-placement="right"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <!-- Check -->
                                <span id="panel-1-check-success" class="check-success hidden"></span>
                            </div>
                        </div>

                        <!-- 2nd Panel - Describing what things this bar has -->
                        <?php $serves_categories = $serves_categories[0]; ?>
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <div id="panel-2" data-next="#panel-3" class="panel panel-default" data-value="1">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-2">
                                            {{<?php echo $serves_categories->char_titulo_filtrobarcategoria ?>}}
                                            <span class="fa fa-chevron-circle-left pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-2" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="offers text-center cursor-pointer row">
                                                <?php
                                                $filters = explode(';', $serves_categories->filtros);
                                                foreach ($filters as $filter) {
                                                    $aux = explode(',', $filter);
                                                    $filter_id   = $aux[0];
                                                    $filter_name = $aux[1];?>

                                                    <div class="col-xs-4 no-padding-right">
                                                        <label class="cursor-pointer">
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <span class="thumbnail offers64 offers64-<?php echo $filter_id ?>"></span>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <small class="text-success">{{<?php echo $filter_name?>}}</small><br>
                                                                    <input type="checkbox"
                                                                        class="has-filter"
                                                                        value="<?php echo $filter_id ?>">
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <button class="btn btn-success margin-top-10 pull-right" data-parent="#panel-6">{{ready}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <span id="panel-2-check-success" class="check-success hidden"></span>
                            </div>
                        </div>

                        <!-- 3rd Panel - Unitary selections. Descriptions about the bar -->
                        <?php $total = count($unique_categories); ?>
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <div id="panel-3" data-next="#panel-4" class="panel panel-default" data-value="<?php echo $total ?>">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-3">
                                            {{rating_component_description}}
                                            <span class="fa fa-chevron-circle-left pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-3" class="panel-collapse collapse">
                                        <div class="panel-body" data-total="<?php echo $total ?>">
                                            <p> {{rating_component_choose}} </p>
                                            <?php
                                            foreach ($unique_categories as $key => $category) {
                                                $heading     = $category->char_titulo_filtrobarcategoria;
                                                $category_id = $category->ainc_id_filtrobarcategoria;
                                                $next_panel  = (($key+1) == $total) ? 'x' : ($key+1);
                                                $body = '';
                                                $first_panel = ($key==0) ? 'in' : '';

                                                // 'Estilo musical' and 'Tipo de comida' are
                                                // must be initially hidden due its dependency with
                                                // offers_filter (music, dance, food)
                                                $is_hidden = ($key==1 || $key == 4)
                                                    ? 'hidden'
                                                    : '';
                                                ?>

                                                <div class="row <?php echo $is_hidden ?>">
                                                    <div class="col-xs-6">
                                                        <!-- Title -->
                                                        <a href="#" class="pull-right">
                                                            <span id="bar-descriptition-title-<?php echo $key ?>">
                                                                {{<?php echo $heading ?>}}
                                                            </span>
                                                        </a>
                                                    </div>

                                                    <!-- Selection -->
                                                    <select class="col-xs-6" data-category="<?php echo $category_id ?>">
                                                        <option value="0">{{rating_component_select}}</option>
                                                        <?php
                                                        // Listing all options
                                                        $options = explode(';', $category->filtros);
                                                        foreach ($options as $key => $option) {
                                                            $aux = explode(',', $option);
                                                            $option_id   = $aux[0];
                                                            $option_name = $aux[1];
                                                            ?>
                                                            <option value="<?php echo $option_id ?>">
                                                                {{<?php echo $option_name ?>}}
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <button class="btn btn-success margin-top-10 pull-right">{{ready}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <span id="panel-3-check-success" class="check-success hidden"></span>
                            </div>
                        </div>

                        <!-- 4th Panel - Describing bar with multiselect questions -->
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <?php $total = count($multiple_categories); ?>
                                <div id="panel-4" class="panel panel-default" data-next="#panel-5" data-value="<?php echo $total ?>">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-4">
                                            {{rating_component_extras}}
                                            <span class="fa fa-chevron-circle-left pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-4" class="panel-collapse collapse">
                                        <div class="panel-body" data-total="<?php echo $total ?>">
                                            <?php
                                            foreach ($multiple_categories as $key => $category) {
                                                $heading     = $category->char_titulo_filtrobarcategoria;
                                                $category_id = $category->ainc_id_filtrobarcategoria;
                                                $next_panel  = (($key+1) == $total) ? 'x' : ($key+1);
                                                $body = '';
                                                $first_panel = ($key==0) ? 'in' : ''; ?>

                                                <div class="row">
                                                    <div class="col-xs-6 no-padding-right">
                                                        <a href="#" class="pull-right">
                                                            <span id="bar-descriptition-title-<?php echo $key ?>">
                                                                {{<?php echo $heading ?>}}
                                                            </span>
                                                        </a>
                                                    </div>

                                                    <select multiple class="col-xs-6" title='{{rating_component_select}}' data-category="<?php echo $category_id ?>">
                                                        <?php
                                                        // Listing all options
                                                        $options = explode(';', $category->filtros);
                                                        foreach ($options as $key => $option) {
                                                            $aux = explode(',', $option);
                                                            $option_id   = $aux[0];
                                                            $option_name = $aux[1];
                                                            $option_description = $aux[2];
                                                            ?>
                                                            <option data-filter-id="<?php echo $option_id?>">
                                                                {{<?php echo $option_name ?>}}
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>

                                            <button class="btn btn-success margin-top-10 pull-right">{{ready}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <span id="panel-4-check-success" class="check-success hidden"></span>
                            </div>
                        </div>

                        <!-- 5th Panel -->
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <div id="panel-5" data-next="#panel-6" class="panel panel-default" data-value="1">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-5">
                                            {{rating_component_suggestion}}
                                            <span class="fa fa-chevron-circle-left pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-5" class="panel-collapse collapse">
                                        <div class="panel-body">

                                            <!-- List of added suggestions -->
                                            <div class="row margin-bottom-10">
                                                <div class="col-xs-12">
                                                    {{rating_component_suggestion_description}}
                                                    <div id="rating-component-menu-list"
                                                        class="panel-featured margin-top-10"></div>
                                                </div>
                                            </div>

                                            <!-- Name of the suggestion -->
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <input id="rating-component-menu-suggestion"
                                                        type="text"
                                                        placeholder="{{item_name}}"
                                                        class="form-control typeahead">
                                                </div>
                                            </div>

                                            <!-- Comment textarea -->
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <textarea id="rating-component-menu-comment"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="{{type_your_comment}}"></textarea>
                                                </div>
                                            </div>

                                            <!-- Characters counter and add button -->
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <small><span class="counter">150</span> {{characters}}</small>
                                                </div>
                                                <div class="col-xs-4">
                                                    <button id="btn-add-suggestion" class="btn btn-default margin-top-10 pull-right">{{add}}</button>
                                                </div>
                                            </div>

                                            <!-- Submit -->
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <!-- Submit Button -->
                                                    <button class="btn btn-success margin-top-10 pull-right" data-parent="#panel-4">{{ready}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <span id="panel-5-check-success" class="check-success hidden"></span>
                            </div>
                        </div>

                        <!-- 6th Panel -->
                        <div class="row margin-bottom-10">
                            <div class="col-xs-10 no-padding-right">
                                <!-- Panel -->
                                <div id="panel-6" class="panel panel-default" data-value="1">
                                    <div class="panel-heading">
                                        <a data-toggle="collapse" href="#rating-component-6">
                                            {{rating_component_comment}}
                                            <span class="fa fa-chevron-circle-left pull-right"></span>
                                        </a>
                                    </div>

                                    <div id="rating-component-6" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <!-- Comment Textarea -->
                                            <textarea id="textarea-comment" class="form-control" rows="3"></textarea>
                                            <small><span id="textarea-comment-max-length">500</span> {{characters}}</small>

                                            <button class="btn btn-success margin-top-10 pull-right" data-parent="#panel-5">{{ready}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <!-- Check -->
                                <span id="panel-6-check-success" class="check-success hidden"></span>
                            </div>
                        </div>
                    </div> <!-- End -->

                    <!-- Completed Rating Blocks -->
                    <div class="col-xs-5 no-padding-left padding-right-25">
                        <div id="completed-rating-component-accordion" class="hidden well panel-group"></div>
                            {{rating_component_warning}}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <img src="/assets/images/icons/typeahead-preloader.gif" class="margin-right-10 hidden preloader" />
                <button class="btn btn-default" data-dismiss="modal">{{cancel}}</button>
                <button id="send-form" class="btn btn-success no-border-radius" disabled>{{send_your_review}}</button>
            </div>
        </div>
    </div>
</div>
