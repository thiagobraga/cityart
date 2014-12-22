###*
 * uglify.coffee
 *
 * Grunt configurations for grunt-contrib-uglify module.
 * This module minifies JavaScript files.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  dist:
    files:
      'assets/js/dist/scripts.min.js': 'assets/js/dist/scripts.js'
