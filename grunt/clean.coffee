###*
 * clean.coffee
 *
 * Grunt configurations for grunt-contrib-clean module.
 * This module erases the specified array of files
 * or a single file for each task.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @see    https://github.com/gruntjs/grunt-contrib-clean
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  js: 'assets/js/dist/**/*.js'
  css: 'assets/css/dist/**/*.css'
