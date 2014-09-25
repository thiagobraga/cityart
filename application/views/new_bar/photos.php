<div id="register-photos" class="panel-body no-padding hidden drop-zone">

    <!-- Wrapper -->
    <div class="register-photos-wrapper drop-zone">

        <!-- Wrapper label -->
        <span class="dragging-photo-label hidden">{{drag_photos_here}}</span>

        <!-- Wrapper preloader -->
        <span class="preloader hidden">
            <i class="fa fa-circle-o-notch fa-spin"></i> {{loading_images}}
        </span>

        <!-- Input:file -->
        <input id="register-photos-input" type="file" class="hidden drop-zone-input" multiple>

        <!-- Well -->
        <div class="row">
            <div class="col-xs-12">
                <div id="register-photos-warning" class="well">
                    <p>{{register_photos_warning}}</p>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="row text-center drop-zone margin-top-10">

            <!-- Load more photos from Facebook -->
            <button class="btn btn-facebook btn-add-photos block-center ">

                <!-- Icon -->
                <!--<i class="preloader fa fa-circle-o-notch fa-spin fa-2x hidden"></i>-->
                <div class="fa fa-facebook fa-2x"></div>

                <!-- Text -->
                <div>
                    <p class="font-size-12">
                        {{btn_add_photos_load_more}}
                        <span id="label-number-photos">10</span>
                        {{btn_add_photos_photos_from}}
                    </p>
                    <p class="font-size-18">
                        {{btn_add_photos_fb_album}}
                    </p>
                </div>
            </button>

            <!-- Divider -->
            <span class="margin-right-30"></span>

            <!-- Load from pc or dragg here button -->
            <label for="register-photos-input" class="btn btn-default btn-from-pc block-center">

                <!-- Icon -->
                <div>
                    <span class="fa fa-plus fa-2x"></span>
                </div>

                <!-- Text -->
                <div>
                    <p class="font-size-12">{{drag_or_click}} </p>
                    <p class="font-size-18">{{do_upload}}</p>
                </div>
            </label>
        </div>
    </div>

    <!-- Container -->
    <div class="row">
        <div class="photos-container"></div>
    </div>

</div>
