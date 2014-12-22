 /**
 * @file   scripts.js
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
 * Scripts
 *
 * @type {Object}
 */
Barpedia.Helpers.Scripts = (function () {

    'use strict';
    var

        /**
         * Loads JavaScript files asynchronously.
         *
         * @param  {String}  url   The URL of the JavaScript file
         * @param  {String}  id    The ID of the <script> (optional)
         * @param  {Boolean} async If the request is asynchronous (default: true)
         * @return {void}
         */
        loadJs = function (url, id, async, callback) {
            var js,
                doc = window.document;

            if (doc.getElementById(id)) {
                return;
            }

            if (async === undefined) {
                async = true;
            }

            js = doc.createElement('script');
            js.src = url;
            js.async = async;

            if (id) {
                js.id = id;
            }

            doc.body.appendChild(js);
        },

        /**
         * Load a Handlebars file template.
         *
         * @param  {String}   file     The Handlebars template file.
         * @param  {Object}   data     The data to populate the HTML template.
         * @param  {Function} callback Pass a function as callback of the method.
         * @return {void}
         */
        loadTemplate = function (file, data, callback) {
            if (!loadTemplate.cache) {
                loadTemplate.cache = {};
            }

            // If doesn't exists the cache of the Handlebars file,
            // make an ajax request to the file and compile the template.
            if (!loadTemplate.cache[file]) {
                var path = '/assets/templates/' + file + '.hbs';

                $.ajax({
                    url: path,
                    dataType: 'html'
                }).done(function (html) {
                    loadTemplate.cache[file] = Handlebars.compile(html);

                    if (callback) {
                        callback(loadTemplate.cache[file](data));
                    }
                });

            // If already exists, run the callback function passing
            // as parameter the cache file with data.
            } else {
                if (callback) {
                    callback(loadTemplate.cache[file](data));
                }
            }
        };

    return {
        loadJS: loadJs,
        loadTemplate: loadTemplate
    };

}());
