###*
 * watch.coffee
 *
 * Grunt configurations for grunt-contrib-watch module.
 * This module watches modification in specified files
 * and reload the browser for each save.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  dist:
    files: [
      'assets/js/src/**/*.js'
    ]
    tasks: [
      'concat'
      'uglify'
    ]

  less:
    files: 'assets/less/**/*.less'
    tasks: [
      'less'
      'cssmin'
    ]

  configFiles:
    files: [
      'Gruntfile.coffee'
      'grunt/**/*.coffee'
      'grunt/**/*.yaml'
    ]
    options:
      reload: true
