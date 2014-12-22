###*
 * cssmin.coffee
 *
 * Grunt configurations for grunt-contrib-cssmin module.
 * This module minifies CSS files.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  development:
    files:
      'assets/css/dist/styles.min.css': 'assets/css/dist/styles.css'
