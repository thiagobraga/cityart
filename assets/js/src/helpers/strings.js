/**
 * @file   strings.js
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
 * Strings
 *
 * @type {Object}
 */
Barpedia.Helpers.Strings = (function () {

    'use strict';
    var

        /**
         * Slice the sentence based on the desired size. If sentence's length
         * is higher than max, slice it to fit and add an '...'. Otherwise,
         * return the whole string.
         *
         * TODO: Make this function accept a new parameter to slice words or not.
         *
         * @param  {String} sentence  The text to be sliced.
         * @param  {Int}    max       Amount of characters allowed.
         * @return {String}           The sliced text.
         */
        slice = function (sentence, max) {
            if (sentence.length <= max || max > sentence.length) {
                return sentence;
            }

            return sentence.substring(0, max) + '...';
        },

        /**
         * Method that count the characters typed in a textarea
         * and avoid user type new characters when limit is reached.
         *
         * @return {String}
         */
        limitChars = function (element) {
            var count = element.siblings('.help-block').find('.counter'),
                limit = count.html();

            element.on('input propertychange', function () {
                if (element.val().length > limit) {
                    element.val(element.val().substr(0, limit));
                }

                count.html(limit - element.val().length);
            });
        };

    return {
        slice      : slice,
        limitChars : limitChars
    };

}());
