var gulp         = require('gulp'),
    sass         = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync  = require('browser-sync'),
    reload       = browserSync.reload,
    paths        = {
        styles: {
            src:   'assets/sass',
            files: 'assets/sass/**/*.scss',
            main:  'assets/sass/styles.scss',
            dest:  'assets/css/dist'
        },

        browserSync: [
            '!assets/css/dist/**/*.min.css',
            '!assets/js/dist/**/*.min.js',
            '!app/logs/**/*.php',
            'assets/css/dist/**/*.css',
            'assets/js/dist/**/*.js',
            'app/**/*.php',
            'index.php'
        ]
    };

// BrowserSync
gulp.task('browser-sync', function () {
    browserSync({
        logPrefix: 'CityArt',
        proxy:     'cityart',
        host:      'cityart',
        files:     paths.browserSync,
        port:      4040,
        open:      false,
        notify:    false
    });
});

// Styles
gulp.task('styles', function () {
    return gulp.src(paths.styles.main)
        .pipe(sass({ style: 'compressed' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(reload({ stream: true }));
});

// Default
gulp.task('default', ['styles', 'browser-sync'], function () {
    gulp.watch(paths.styles.files, ['styles']);
});
