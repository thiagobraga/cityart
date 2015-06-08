/**
 * @file   behavior.js
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
 * Behavior
 *
 * @type {Object}
 */
Barpedia.Core.Behavior = (function () {

    'use strict';
    var

        /**
         * jQuery preventDefault
         *
         * Remove a ação padrão ao clicar em links e botões,
         * como por exemplo, recarregar o navegador ou
         * adicionar "#" na barra de endereço.
         * TODO: Traduzir
         *
         * @return {void}
         */
        preventDefaultAction = (function () {
            var selectors = [
                'a[href="#"]',
                'button[type="submit"]',
                'input[type="button"]'
            ].join(', ');

            $(selectors).on('click', function (event) {
                event.preventDefault();
            });
        }());

    return {
        ajaxDefaultBehavior: ajaxDefaultBehavior,
        preventDefaultAction: preventDefaultAction
    };

}());
