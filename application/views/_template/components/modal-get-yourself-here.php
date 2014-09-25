 <!-- Page shared contribution feedback modal -->
<div id="modal-get-yourself-here" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="get-yourself-here" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    {{do_your_rate_now}} <?php echo $bar->char_nome_bar; ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="block-center text-center">
                    {{get_yourself_here_description}}
                    <img src="/assets/images/icons/review-comment.png" />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"> {{not_now}} </button>
                <button class="btn btn-success btn-open-rating-modal" data-dismiss="modal"> {{i_want_contribute}} </button>
            </div>
        </div>
    </div>
</div>
