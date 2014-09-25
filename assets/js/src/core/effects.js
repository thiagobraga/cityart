/**
 * @file   avaliacao.js
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @author Matheus Cesario <matheus@institutosoma.org.br>
 */

/**
 * Barpedia
 * @namespace
 */
var Barpedia = Barpedia || {};

/**
 * Core Class.
 *
 * Contains all core classes used in Barpedia.
 *
 * @type {Object}
 */
Barpedia.Core = Barpedia.Core || {};

/**
 * Effects Class.
 *
 * Contains methods to add effects and highlight
 * elements in images and other elements.
 *
 * @type {Object}
 */
Barpedia.Core.Effects = (function () {

    'use strict';
    var

        /**
         * Private variables
         */
        target, link,

        /**
         * Helper. Mask builder
         * @param  {void} self [description]
         * @return {void}      [description]
         */
        showMask = function (self) {
            var classes       =  self.attr('class'),
                position      =  self.offset(),
                title         =  self.data('title'),
                border_left   = +self.css('border-left-width').replace('px', ''),
                border_right  = +self.css('border-right-width').replace('px', ''),
                padding_left  = +self.css('padding-left').replace('px', ''),
                padding_right = +self.css('padding-right').replace('px', ''),
                sum           = 0,
                i             = 0,
                thumb         = '',
                style         = {};

            // Getting link
            target = self.data('target');
            link   = self.data('href');

            // Setting styles
            sum = border_left + border_right + padding_left + padding_right;

            style = {
                width:  self.width() + sum,
                height: self.height() + sum,
                top:    position.top,
                left:   position.left
            };

            // Applying effect
            classes = classes.split(' ');

            // Looking for properly thumbnail-*
            // (user, square or bar)
            do {
                thumb = (classes[i].indexOf('thumbnail-') === 0) ? classes[i] : '';
                i++;
            } while (thumb === '' && i < classes.length);

            // Applying configs
            if (thumb !== '') {
                // Write text, if exists
                $('.' + thumb + '-highlight').children('span').html(title);

                // Apply style
                $('.' + thumb + '-highlight').css(style);

                // Showing mask
                $('.' + thumb + '-highlight').removeClass('hidden');
            }
        },

        /**
         * Highlights the user or bar image.
         *
         * Creates an overlay image with icon and/or text
         * over the image of the user or bar. This method
         * calculates the border and padding of the image
         * to sum to the thumbnail highlight.
         *
         * @return {void}
         */
        highlight = function () {
            var main = $(document);

            /**
             * For linked elements. Activate the mask without hover the image
             * @param  {void} event [description]
             * @return {void}       [description]
             */
            main.on({
                mouseover : function () {
                    // Assuring that we will get just the inner image
                    var picture = $(this).find(this.dataset.target);

                    // highlighting image
                    showMask(picture);
                },
                mouseleave : function () {
                    $('.thumbnail-highlight').addClass('hidden');
                }
            }, '*[data-toggle="my-highlight"]');

            /**
             * For the images itself
             * @return {void} [description]
             */

            // On thumbnail enter
            main.on({
                mouseenter : function () {
                    var $this = $(this);

                    // Constructing mask
                    showMask($this);

                    // Adding mouseover class
                    $this.addClass('mouse-over');
                },
                mouseleave : function () {
                    $(this).removeClass('mouse-over');
                }
            }, '.thumbnail');

            // On mask enter
            main.on({
                mouseenter : function () {
                    $(this).addClass('mouse-over');
                }
            }, '.thumbnail-highlight');

            // Hiding mask
            main.on({
                mouseleave: function () {
                    var $this = $(this),
                        time  = setTimeout(function () {
                            $this.removeClass('mouse-over');

                            if ($('.mouse-over').length === 0) {
                                $('.thumbnail-highlight').addClass('hidden');
                            }
                        }, 1);
                }
            }, '.thumbnail, .thumbnail-highlight');

            /**
             * When click in the mask
             * Redirects to link (can be a Barpedia page or a facebook profile)
             */
            $(document).on('click', '.thumbnail-highlight', function () {
                if (target === false || target == '_blank') {
                    window.open(link, '_blank');
                } else {
                    window.location = link;
                }
            });
        };

    return {
        highlight: highlight
    };

}());
