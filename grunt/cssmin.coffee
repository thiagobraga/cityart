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
      'assets/css/styles.min.css': 'assets/css/styles.css'

    options:
      keepSpecialComments: 0
      report: 'gzip'
