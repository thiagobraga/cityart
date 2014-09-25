<section class="map-wrap map-xs map-transition">
    <div id="map_canvas" class="map" data-scroll="false"></div>

    <div id="markers">
        <span id="marker-1"
            data-lat="<?php echo $bar->deci_latitude_bar ?>"
            data-lng="<?php echo $bar->deci_longitude_bar ?>"
            data-title="<?php echo $bar->char_nome_bar ?>">
        </span>
    </div>

    <div class="container">
        <div class="row">
            <button id="show-map" type="button" class="btn btn-dark btn-show-map">
                <span id="show-map-text">{{show_map}}</span>
                <span id="hide-map-text" class="hidden">{{hide_map}}</span>
            </button>
        </div>
    </div>
</section>
