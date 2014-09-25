/**
 * @file   i18n.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Helpers
 *
 * @type {Object}
 */
Barpedia.Helpers = Barpedia.Helpers || {};

/**
 * I18n
 *
 * @type {Object}
 */
Barpedia.Helpers.I18n = (function () {

    'use strict';
    var

        /**
         * NOTE: Duplicated method. (See in Barpedia.Core.URI)
         * Set the current environment.
         *
         * Set the environment to development or production based in the URL of the
         * browser. Actually, the production URL is 'dev.barpedia.org'.
         *
         * @return {String}
         */
        setEnvironment = function () {
            return Barpedia.Core.URI.location.domain === 'dev.barpedia.org' ?
                'dev' :
                'local';
        },

        /**
         * Get information about current language
         * @return {Object} Returns info about locale as an object with attributes
         *                  like locale, language acronymous and iso_country
         */
        currentLang = function () {
            // Checking enviroment
            var prefix  = setEnvironment(),

                // Get locale from cookies
                locale  = $.cookie(prefix + '_locale'),

                // Splitting data
                aux     = locale.split('_'),

                //Constructing object
                current = {
                    locale:      locale,
                    lang:        aux[0],
                    iso_country: aux[1]
                };

            return current;
        },

        /**
         * [set description]
         *
         * @param {void} locale [description]
         */
        set = function (locale) {
            $.ajax({
                url: '/i18n/ajax_set',
                type: 'post',
                dataType: 'json',
                data: {
                    locale: locale
                }
            }).always(function() {
                // Reload
                location.reload();
            });
        },

        /**
         * Cache of the translated messages
         *
         * @type {Array}
         */
        lang = [],

        /**
         * Require translated sentence based on the current language.
         *
         * @id     {String} Code of the sentence or some numeric value.
         * @return {String} Translated sentence
         */
        get = function (id) {
            if (id == 0.0) {
                return 0;
            }

            if (!isNaN(parseFloat(id))) {
                return i18nNumber(id);
            }

            if (lang[id] !== undefined) {
                return lang[id];
            }

            var translation = '';

            $.ajax({
                url: '/i18n/get',
                type: 'post',
                async: false,
                dataType: 'json',
                data: {
                    id: id
                }
            }).done(function (data) {
                lang[id] = data;
                translation = data;
            });

            return translation;
        },

        /**
         * NOTE: Accept just positive values
         *
         * @param  {real} number Positive real number
         * @return {string}      Formatted number
         */
        i18nNumber = function (number) {
            var j,
                decimal_separator  = get('decimal_separator'),
                thousand_separator = get('thousand_separator'),
                number_to_string   = number.toString(),
                signal = '',
                formatted_number_1 = '',
                formatted_number_2 = '';

            // Decimal separator
            number_to_string = number_to_string.split('.');

            // Thousand separator
            j = (j = number_to_string[0].length) > 3 ? j % 3 : 0; // Grouping number 3 by 3

            // Removing first part of the number
            formatted_number_1 = (j > 0) ?
                number_to_string[0].substr(0, j) + thousand_separator :
                '';

            // Adding @thousand_separator for every group of 3 digits
            formatted_number_2 = number_to_string[0]
                .substr(j)
                .replace(/(\d{3})(?=\d)/g, '$1' + thousand_separator);

            // Concatenating both strings
            number_to_string[0] = formatted_number_1 + formatted_number_2;

            // Signal
            if (number < 0) {
                signal = '-';
            }

            // Retrieving value
            return signal + number_to_string.join(decimal_separator);
        };

    return {
        get: get,
        set: set,
        currentLang: currentLang
    };
}());
