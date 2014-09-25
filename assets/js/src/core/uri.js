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
 * URI
 *
 * @type {Object}
 */
Barpedia.Core.URI = (function () {

    'use strict';
    var

        /**
         * Obtém as partes da URL
         *
         * Obtém sigla do país, estado, cidade e, caso esteja
         * numa página de bar, o nome amigável do bar pela URL.
         *
         * @return {Object}
         */
        urlParts = function () {
            var size,
                url  = window.location.href.split('/'),
                href = '',
                location = {
                    bar:    '',
                    cidade: '',
                    city:   '',
                    estado: '',
                    pais:   '',
                    href:   '',
                    domain: '',
                    prefix: ''
                };

            // Remove entradas vazias ou 'http:'
            url = url.filter(function (value) {
                return value !== '' && value !== 'http:';
            });

            // Important information
            location.prefix = (url[0] === 'dev.barpedia.org') ? 'dev' : 'local';
            location.domain = url[0];

            if (/contact|usuarios|pages/i.test(url[1])) {
                return location;
            }

            // Country/Region
            location.pais  = url[1];
            location.href  = url[1] + '/' + url[2];
            location.href += (url[3] !== undefined) ? '/' + url[3] : '';

            // Retrieving data from db to set the city
            setLocation(location.href, function (data) {
                location.pais   = data.char_id_pais;
                location.estado = data.char_estado.toLowerCase();
                location.cidade = data.char_nomeamigavel_cidade;
                location.city   = data.char_nomelocal_cidade;
            });

            return location;
        },

        /**
         * Get the local name of the city searching by the friendly url.
         *
         * @param   {String}  name
         * @return  {String}
         */
        setLocation = function (href, callback) {
            $.ajax({
                url: '/cities/ajax_verifyLocation',
                type: 'post',
                dataType: 'json',
                data: {
                    href: href
                }
            }).done(callback);
        },

        /**
         * The public variable location.
         *
         * @type {String}
         */
        location = urlParts(),

        /**
         * Set the current environment.
         *
         * Set the environment to development or production based in the URL of the
         * browser. Actually, the production URL is 'dev.barpedia.org'.
         *
         * @return {String}
         */
        setEnvironment = function () {
            return location.domain === 'dev.barpedia.org' ? 'production' : 'development';
        },

        /**
         * [checkEntry description]
         *
         * @return {void}
         */
        checkEntry = function () {
            var prefix = setEnvironment() === 'production' ? 'dev' : 'local',
                cookie = $.cookie(prefix + '_barpedia'),
                start = cookie.indexOf('session_id') + 18,
                session_id = cookie.substr(start, 32),
                first_login = $.cookie(prefix + '_' + session_id + '_f');

            return (first_login !== undefined) ? true : false;
        }

    ;return {
        checkEntry: checkEntry,
        location: location
    };

}());
