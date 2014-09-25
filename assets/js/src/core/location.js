/**
 * @file   location.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Core
 *
 * @type {Object}
 */
Barpedia.Core = Barpedia.Core || {};

/**
 * Location
 *
 * @type {Object}
 */
Barpedia.Core.Location = (function () {

    'use strict';
    var

        /*getPositionByCoordinates = function (lat, lon, callback) {

            $.ajax({
                url: '/path/to/file',
                type: 'POST',
                dataType: 'json',
                data: {
                    lat: lat,
                    lon: lon
                }
            })
            .done(function(data) {
                callback(data);
            })
            .fail(function(err) {
                console.log("error", err);
            });

            return;
        },*/

        /**
         * Verifica a localidade do usuário
         *
         * Ao fazer o login, compara a localidade do usuário com a
         * cidade da página que está sendo exibida, mostrando um modal
         * que pergunta se deseja redirecionar para a cidade ou não.
         * TODO: traduzir
         *
         * @return {void}
         */
        verify = function (callback) {
            $.ajax({
                url: '/usuarios/ajax_verifyLocation'
            }).done(function (response) {

                // If is not equal, show redirect modal
                if (!response.is_equal) {
                    var modal    = $('#facebookRedirect'),
                        cidade   = $('#facebook-cidade'),
                        redirect = $('#redirect'),
                        dont_redirect = $('#dont-redirect');

                    cidade.html([
                        response.char_nomelocal_cidade,
                        response.char_estado
                    ].join(', '));

                    redirect.on('click', function () {
                        window.location = response.url;
                    });

                    // If close and user is admin of some page, show popup
                    dont_redirect.on('click', function () {
                        Barpedia.Core.Facebook.checkAdminPages();
                    });

                    modal.modal();

                // If is equal, show admin pages popup instead
                } else {
                    Barpedia.Core.Facebook.checkAdminPages();
                }
            });
        },

        /**
         * Atualiza a localidade do usuário
         * TODO: traduzir
         *
         * @return {void}
         */
        update = function () {
            $.ajax({
                url: '/usuarios/ajax_updateLocation',
                type: 'post',
                dataType: 'json',
                data: {
                    data: Barpedia.Core.URI.location
                }
            });
        },

        /**
         * [positioningByGeoLocation description]
         *
         * @return {void} [description]
         */
        positioningByGeoLocation = function () {
            // Check for mobile devices
            var prefix       = Barpedia.Core.URI.location.prefix,
                is_mobile    = $.cookie( prefix + '_is_mobile')    !== undefined,
                geoip_failed = $.cookie( prefix + '_geoip_failed') !== undefined;

            // Removing cookies
            $.removeCookie(prefix + '_is_mobile'   , {path: '/', domain: prefix + '.barpedia.org' });
            $.removeCookie(prefix + '_geoip_failed', {path: '/', domain: prefix + '.barpedia.org' });

            // If geoip positioning not failed and the user agent is not a mobile,
            // we already have a position and we know the agent.
            // Do nothing.
            if (!geoip_failed && !is_mobile) {
                return;
            }

            // If browser does not support prototype.navigator, do nothing.
            if (!navigator.geolocation) {
                return;
            }

            // Get position
            navigator.geolocation.getCurrentPosition(function (data) {
                $.ajax({
                    url: '/usuarios/ajax_positioningByGeoLocation',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        lat: data.coords.latitude,
                        lon: data.coords.longitude,
                        is_mobile: is_mobile
                    }
                }).done(function(response) {
                    if (is_mobile) {
                        window.location = response.url;
                    } else if (!is_mobile && response.location_found) {
                        window.location = response.location;
                    }
                });
            });
        },

        /**
         * Initializes the module.
         *
         * @return {void}
         */
        init = (function () {
            // Positioning using browser'geolocation s
            positioningByGeoLocation();

            // Update position
            update();
        }());

    return {
        update: update,
        verify: verify
    };

}());
