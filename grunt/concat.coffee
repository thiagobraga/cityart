###*
 * concat.coffee
 *
 * Grunt configurations for grunt-contrib-concat module.
 * This module concat all specified files in one file.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  main:
    src: [
      'assets/bower/jquery/dist/jquery.js'
      'assets/bower/bootstrap/js/transition.js'
      'assets/bower/bootstrap/js/collapse.js'
      'assets/bower/bootstrap/js/dropdown.js'
      'assets/bower/bootstrap/js/modal.js'
      'assets/bower/bootstrap/js/tooltip.js'
      'assets/bower/bootstrap/js/popover.js'
      'assets/bower/handlebars/handlebars.js'
    ]
    dest: 'assets/js/dist/scripts.js'

  options:
    separator: ';\n'
