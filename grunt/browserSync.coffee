###*
 * browserSync.coffee
 *
 * Grunt configurations for grunt-browser-sync module.
 * This module uses socket.io to inject changes made
 * in CSS without reloading the browser.
 *
 * @author Thiago Braga <thiago@institutosoma.org.br>
 * @see    https://github.com/shakyShane/browser-sync
 * @url    http://barpedia.org
 * @type   {Object}
###
module.exports =
  bsFiles:
    src: [
      'assets/css/dist/**/*.css'
      'assets/js/dist/**/*.js'
      'assets/templates/**/*.hbs'
      'application/**/*.php'
    ]

  options:
    proxy: 'bptadvogados'
    host: 'bptadvogados'
    port: 3020
    watchTask: true
    open: false
    notify: false
    ghostMode:
      scroll: true
      links: false
      forms: true
