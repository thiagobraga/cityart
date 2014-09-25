 /**
 * @file   language.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Components
 *
 * @type {Object}
 */
Barpedia.Components = Barpedia.Components || {};

/**
 * Typeahead
 *
 * @type {Object}
 */
Barpedia.Components.Language = (function () {

    'use strict';
    var

        /**
         * [drop_down description]
         *
         * @type  {void}
         */
        drop_down = $('#change-lang-dropdown .dropdown-menu'),
        drop_down_footer = $('#change-lang-dropdown-footer .dropdown-menu'),

        /**
         * [current_lang description]
         *
         * @type  {void}
         */
        current_lang = $('#change-lang-current'),

        /**
         * [init description]
         *
         * @return  {void}
         */
        init = function () {
            var i18n = Barpedia.Helpers.I18n;

            drop_down.on('click', 'li', function () {
                var locale = $(this).data('value');
                i18n.set(locale);
            });

            drop_down_footer.on('click', 'li', function () {
                var locale = $(this).data('value');
                i18n.set(locale);
            });
        };

    return {
        init: init
    };
}());
