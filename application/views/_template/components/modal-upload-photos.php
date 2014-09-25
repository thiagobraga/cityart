<!-- MODAL UPLOAD PHOTOS -->
<section id="modal-upload-photos" class="modal upload-photos" role="dialog" aria-labelledby="{{your_photos_on_barpedia}}">
    <section class="modal-dialog">
        <!-- Header -->
        <header class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{{your_photos_on_barpedia}}</h4>
        </header>

        <!-- Body -->
        <section id="upload-photos-body" class="modal-body"></section>

        <!-- Footer -->
        <footer class="modal-footer">
            <button id="add-more" class="btn btn-default pull-left">+ {{add_more_photos}}</button>
            <button id="clear-all" class="btn btn-danger pull-left" title="{{clear_all}}" data-placement="right"><span class="fa fa-trash-o"></span></button>
            <button class="btn btn-default" data-dismiss="modal">{{cancel}}</button>
            <button id="send" class="btn btn-success">{{send_images}}</button>
        </footer>
    </section>
</section>
