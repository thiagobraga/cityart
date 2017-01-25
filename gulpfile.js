const gulp     = require('gulp'),
  changed      = require('gulp-changed'),
  sass         = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  uglify       = require('gulp-uglify'),
  concat       = require('gulp-concat'),
  rename       = require('gulp-rename'),
  imagemin     = require('gulp-imagemin'),
  pngquant     = require('imagemin-pngquant'),
  browserSync  = require('browser-sync'),

  images = {
    src:  './assets/images/src/**/*',
    dest: './assets/images/dist'
  },

  styles = {
    base:    './assets/scss',
    src:     './assets/scss/**/*.scss',
    dest:    './assets/css/dist',
    options: { outputStyle: 'compressed' }
  },

  scripts = {
    src: [
      './node_modules/angular/angular.min.js',
      './node_modules/ngmap/build/scripts/ng-map.min.js',
      './node_modules/jquery/dist/jquery.min.js',
      './node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
      './node_modules/noty/js/noty/packaged/jquery.noty.packaged.min.js',
      './assets/js/src/**/*.js'
    ],
    base: './assets/js/src',
    dest: './assets/js/dist'
  },

  bsFiles = [
    '!./assets/css/dist/**/*.min.css',
    '!./assets/js/dist/**/*.min.js',
    '!./application/logs/**/*.php',
    './assets/css/dist/**/*.css',
    './assets/js/dist/**/*.js',
    './assets/images/dist/**/*.{png,jpg,jpeg,gif,svg,ico}',
    './**/*.php'
  ];

// Images
gulp.task('images', function () {
  return gulp.src(images.src)
    .pipe(changed(images.dest))
    .pipe(imagemin())
    .pipe(gulp.dest(images.dest))
    .pipe(browserSync.reload({ stream: true }));
});

// Styles
gulp.task('styles', function () {
  return gulp.src(styles.src, { base: styles.base })
    .pipe(sass(styles.options).on('error', sass.logError))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest(styles.dest))
    .pipe(browserSync.reload({ stream: true }));
});

// Scripts
gulp.task('scripts', function () {
  return gulp.src(scripts.src)
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest(scripts.dest))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest(scripts.dest));
});

// BrowserSync
gulp.task('browser-sync', function () {
  browserSync.init({
    logPrefix:  'CityArt',
    host:       'cityart',
    files:      bsFiles,
    port:       4040,
    open:       false,
    notify:     false,
    ui:         false,
    logSnippet: false
  });
});

// Default
gulp.task('default', ['images', 'styles', 'scripts'], function () {
  gulp.start('browser-sync');

  gulp.watch(images.src, ['images']);
  gulp.watch(styles.src, ['styles']);
  gulp.watch(scripts.src, ['scripts']);
});

// Production
gulp.task('production', function () {
  gulp.start('images', 'styles', 'scripts');
});
