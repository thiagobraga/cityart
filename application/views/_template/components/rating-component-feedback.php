<div id="rating-component-feedback" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">
                    {{rating_component_feedback_title}}
                </span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><br>
            </div>
            <div class="modal-body">

                <!-- Special message to whom answer all questions -->
                <div class="well-done-message block-center hidden">
                    {{well_done_message}}
                    <img src="/assets/images/icons/wel-done.jpg" width="256px" />
                </div>

                <!-- Normal message -->
                <div class="done-message block-center hidden">
                    {{done_message}}
                </div>

                <!-- User's score -->
                <div class="block-center">
                    {{user_score}}
                    <span class="user_score">0</span>
                    {{navbar_points}}
                </div>
            </div>
            <div class="modal-footer">
                <div class="block-center">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
