 /**
 * @file   moment.js
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
Barpedia.Components.Moment = (function () {

    'use strict';
    var

        /**
         * Cache of method currentLang.
         *
         * @type {Object}
         */
        current_lang = Barpedia.Helpers.I18n.currentLang(),

        /**
         * [today description]
         *
         * @return {[type]}
         */
        today = function () {
            moment.locale(current_lang.lang);
            return moment().format('DD/MM/YYYY');
        },

        /**
         * Initializes the moment component.
         *
         * @return {void}
         */
        init = function () {
            // Getting all elements with 'moment-timeago' or time elements class
            var timestamp = $('time'),
                time = 0;

            // Choosing language
            moment.locale(current_lang.lang);

            // For each element, convert its fulldate (that is in the format (Y-m-d h:m:s))
            $.each(timestamp, function (index, element) {
                time = element.dataset.fulldate;
                $(element).livestamp(time);
            });
        };

    return {
        init: init,
        today: today
    };
}());
