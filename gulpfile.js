const gulp     = require('gulp'),
  autoprefixer = require('gulp-autoprefixer'),
  browserSync  = require('browser-sync'),
  concat       = require('gulp-concat'),
  rename       = require('gulp-rename'),
  sass         = require('gulp-sass'),
  uglify       = require('gulp-uglify'),

  styles = {
    base: 'assets/scss',
    src: 'assets/scss/**/*.scss',
    dest: 'assets/css/dist'
  },

  scripts = {
    src: [
      'node_modules/angular/angular.min.js',
      'node_modules/ngmap/build/scripts/ng-map.min.js',
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
      'node_modules/noty/js/noty/packaged/jquery.noty.packaged.min.js',
      'assets/js/src/**/*.js'
    ],
    base: 'assets/js/src',
    dest: 'assets/js/dist'
  },

  bsFiles = [
    '!assets/css/dist/**/*.min.css',
    '!assets/js/dist/**/*.min.js',
    'assets/css/dist/**/*.css',
    'assets/js/dist/**/*.js',
    '**/*.php'
  ];

// Styles
gulp.task('styles', function () {
  return gulp.src(styles.src, { base: styles.base })
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer('last 2 version'))
    .pipe(gulp.dest(styles.dest))
    .pipe(browserSync.reload({ stream: true }));
});

gulp.task('styles:prod', function () {
  return gulp.src(styles.src, { base: styles.base })
    .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
    .pipe(autoprefixer('last 2 version'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(styles.dest));
});

// Scripts
gulp.task('scripts', function () {
  return gulp.src(scripts.src)
    .pipe(concat('scripts.js'))
    .pipe(gulp.dest(scripts.dest));
});

gulp.task('scripts:prod', function () {
  return gulp.src(scripts.src)
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(scripts.dest));
});


// Default
gulp.task('default', gulp.series('styles', 'scripts', function () {
  browserSync.init({
    files: bsFiles,
    logSnippet: false,
    ghostMode: false,
    notify: false,
    open: false,
    ui: false,
  });

  gulp.watch(styles.src, gulp.series('styles'));
  gulp.watch(scripts.src, gulp.series('scripts'));
}));

// Production
gulp.task('production', gulp.series('styles:prod', 'scripts:prod'));
