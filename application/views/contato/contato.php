<div class="col-xs-12 col-md-6 contact-page">
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
            placeholder="Envie-nos sua dúvida, opinião ou sugestão"
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

<div class="col-xs-12 col-md-6">
    <map zoom="16"
        class="map-md"
        center="-22.3320145, -49.0302082"
        disable-double-click-zoom="true"
        disable-default-u-i="true"
        draggable="true"
        scrollwheel="true"
        keyboard-shortcuts="true"
        styles="[{featureType:'landscape',elementType:'labels',stylers:[{visibility:'off'}]},{featureType:'transit',elementType:'labels',stylers:[{visibility:'off'}]},{featureType:'poi',elementType:'labels',stylers:[{visibility:'off'}]},{featureType:'water',elementType:'labels',stylers:[{visibility:'off'}]},{featureType:'road',elementType:'labels.icon',stylers:[{visibility:'off'}]},{stylers:[{hue:'#00aaff'},{saturation:-100},{gamma:2.15},{lightness:12}]},{featureType:'road',elementType:'labels.text.fill',stylers:[{visibility:'on'},{lightness:24}]},{featureType:'road',elementType:'geometry',stylers:[{lightness:57}]}]">

        <marker position="-22.331878, -49.029618"
            animation="Animation.DROP"
            on-click="map.showInfoWindow(event, 'map-info')" />

        <info-window id="map-info">
            <div ng-non-bindable>
                <div class="info-window-content">
                    <h2 class="info-window-title">CityArt Artes Gráficas</h2>

                    <address class="info-window-address">
                        Rua Anthero Donini, 1-52 - Geisel<br/>
                        CEP: 17015-030 - Bauru/SP<br/>
                        <i class="fa fa-phone"></i> 14 3208-5654 | 99777-4155
                    </address>
                </div>
            </div>
        </info-window>
    </map>

</div>
