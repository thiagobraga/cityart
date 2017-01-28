<div class="col-xs-12 col-md-5">
    <h2>Contato</h2>

    <form id="contact-form" class="form-horizontal" role="form">
        <!-- Nome -->
        <input id="name"
            type="text"
            class="form-control input-lg form-name"
            placeholder="Informe seu nome"
            required />

        <!-- E-mail -->
        <input id="email"
            type="email"
            class="form-control input-lg form-email"
            placeholder="E-mail para entrarmos em contato"
            required />

        <!-- Message -->
        <textarea id="message"
            class="form-control input-lg form-message"
            rows="6"
            placeholder="Envie sua mensagem"
            required></textarea>

        <!-- Actions -->
        <div class="text-right">
            <button id="send" class="btn btn-warning btn-lg">
                <i class="fa fa-envelope-o email-icon"></i>
                <i class="fa fa-spin fa-spinner loading-icon hidden"></i>

                Enviar
            </button>
        </div>
    </form>
</div>

<div class="col-xs-12 col-md-7">
    <h2>
        <i class="fa fa-phone icon"></i> 14 3208-5654
        <i class="fa fa-whatsapp icon"></i> 14 99777-4155
    </h2>

    <map class="map-md"
        center="-22.3319145, -49.0296082"
        zoom="17"
        disable-double-click-zoom="true"
        disable-default-u-i="true"
        draggable="true"
        scrollwheel="true"
        keyboard-shortcuts="true"
        styles="[{featureType:'all',elementType:'labels',stylers:[{visibility:'on'}]},{featureType:'all',elementType:'labels.text.fill',stylers:[{saturation:36},{color:'#000000'},{lightness:40}]},{featureType:'all',elementType:'labels.text.stroke',stylers:[{visibility:'on'},{color:'#000000'},{lightness:16}]},{featureType:'all',elementType:'labels.icon',stylers:[{visibility:'off'}]},{featureType:'administrative',elementType:'geometry.fill',stylers:[{color:'#000000'},{lightness:20}]},{featureType:'administrative',elementType:'geometry.stroke',stylers:[{color:'#000000'},{lightness:17},{weight:1.2}]},{featureType:'administrative.country',elementType:'labels.text.fill',stylers:[{color:'#e5c163'}]},{featureType:'administrative.locality',elementType:'labels.text.fill',stylers:[{color:'#c4c4c4'}]},{featureType:'administrative.neighborhood',elementType:'labels.text.fill',stylers:[{color:'#e5c163'}]},{featureType:'landscape',elementType:'geometry',stylers:[{color:'#000000'},{lightness:20}]},{featureType:'poi',elementType:'geometry',stylers:[{color:'#000000'},{lightness:21},{visibility:'on'}]},{featureType:'poi.business',elementType:'geometry',stylers:[{visibility:'on'}]},{featureType:'road.highway',elementType:'geometry.fill',stylers:[{color:'#e5c163'},{lightness:'0'}]},{featureType:'road.highway',elementType:'geometry.stroke',stylers:[{visibility:'off'}]},{featureType:'road.highway',elementType:'labels.text.fill',stylers:[{color:'#ffffff'}]},{featureType:'road.highway',elementType:'labels.text.stroke',stylers:[{color:'#e5c163'}]},{featureType:'road.arterial',elementType:'geometry',stylers:[{color:'#000000'},{lightness:18}]},{featureType:'road.arterial',elementType:'geometry.fill',stylers:[{color:'#575757'}]},{featureType:'road.arterial',elementType:'labels.text.fill',stylers:[{color:'#ffffff'}]},{featureType:'road.arterial',elementType:'labels.text.stroke',stylers:[{color:'#2c2c2c'}]},{featureType:'road.local',elementType:'geometry',stylers:[{color:'#000000'},{lightness:16}]},{featureType:'road.local',elementType:'labels.text.fill',stylers:[{color:'#999999'}]},{featureType:'transit',elementType:'geometry',stylers:[{color:'#000000'},{lightness:19}]},{featureType:'water',elementType:'geometry',stylers:[{color:'#000000'},{lightness:17}]}]">

        <marker position="-22.331878, -49.029618"
            animation="Animation.DROP"
            on-click="map.showInfoWindow(event, 'map-info')" />

        <info-window id="map-info" hidden>
            <div ng-non-bindable>
                <div class="info-window-content">
                    <h2 class="info-window-title">CityArt Artes Gráficas</h2>

                    <address class="info-window-address">
                        Rua Anthero Donnini, 1-80<br/>
                        CEP: 17033-660 - Bauru/SP<br/>
                        <i class="fa fa-phone"></i> 14 3208-5654 | 99777-4155
                    </address>
                </div>
            </div>
        </info-window>
    </map>

</div>
