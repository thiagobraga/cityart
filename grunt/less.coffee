###*
 * less.coffee
 *
 * Grunt configurations for grunt-contrib-less module.
 * This module compiles LESS files into CSS files.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  styles:
    files:
      'assets/css/styles.min.css': 'assets/less/styles.less'
