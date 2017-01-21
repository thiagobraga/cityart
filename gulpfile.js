var gulp       = require('gulp'),
  sass         = require('gulp-sass'),
  autoprefixer = require('gulp-autoprefixer'),
  browserSync  = require('browser-sync'),
  plumber      = require('gulp-plumber'),
  uglify       = require('gulp-uglify'),
  concat       = require('gulp-concat'),
  rename       = require('gulp-rename'),
  reload       = browserSync.reload,

  sass_files = {
    src:   'assets/sass',
    files: 'assets/sass/*.scss',
    main:  'assets/sass/styles.scss',
    dest:  'assets/css/dist'
  },

  js_files = [
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'assets/js/src/**/*.js'
  ],

  bsFiles = [
    '!assets/css/dist/**/*.min.css',
    '!assets/js/dist/**/*.min.js',
    '!application/logs/**/*.php',
    'assets/css/dist/**/*.css',
    'assets/js/dist/**/*.js',
    'application/**/*.php',
    'index.php'
  ];

// BrowserSync
gulp.task('browser-sync', function () {
  browserSync.init({
    logPrefix:  'CityArt',
    host:       'cityart',
    files:      bsFiles,
    port:       4040,
    open:       false,
    notify:     false,
    logSnippet: false
  });
});

// Styles
gulp.task('styles', function () {
  return gulp.src(sass_files.main)
    .pipe(plumber())
    .pipe(sass({
      style: 'compressed',
      includePaths: ['assets/sass']
    }))
    .on('error', function (err) {
      console.log('\nError: ' + err.message);
      console.log('File: ' + err.fileName);
      console.log('Line: ' + err.lineNumber + '\n');
      this.emit('end');
    })
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest(sass_files.dest))
    .pipe(reload({ stream: true }));
});

// Scripts
gulp.task('scripts', function () {
  return gulp.src(js_files)
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest('assets/js/dist'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('assets/js/dist'));
});

// Default
gulp.task('default', ['styles', 'scripts', 'browser-sync'], function () {
  gulp.watch(sass_files.files, ['styles']);
  gulp.watch(js_files, ['scripts']);
});

// Production
gulp.task('production', function () {
  gulp.start('styles', 'scripts');
});
