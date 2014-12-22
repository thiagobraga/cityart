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
  files: [
    'assets/css/src/**/*.css'
    'assets/css/dist/**/*.css'
    '!assets/css/dist/**/*.min.css'
    'assets/js/dist/**/*.js'
    '!assets/js/dist/**/*.min.js'
    'assets/templates/**/*.hbs'
    'application/**/*.php'
    '!application/logs/**/*.php'
    'index.php'
  ]

  options:
    logPrefix: 'CityArt'
    proxy: 'cityart'
    host: 'cityart'
    port: 4040
    watchTask: true
    open: false
    notify: false
    ghostMode:
      scroll: true
      links: false
      forms: true
