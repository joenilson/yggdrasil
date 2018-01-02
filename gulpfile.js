var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var minify = require('gulp-minify');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var merge = require('merge-stream');
var useref = require('gulp-useref');
var gulpIf = require('gulp-if');

gulp.task('styles', function() {
    gulp.src('assets/css/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('public/build/css/'));
});

gulp.task('minify-css', function() {
    gulp.src('public/build/css/*.css')
        .pipe(cleanCSS({ compatibility: 'ie8', discardUnused: false }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('compress_js', function() {
    var bulmajs = gulp.src('node_modules/bulmajs/dist/bulma.js')
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['.combo.js', '.min.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

//    var bulma_accordion = gulp.src('node_modules/bulma-extensions/bulma-accordion/accordion.js')
//        .pipe(minify({
//            ext: {
//                src: '-debug.js',
//                min: '.min.js'
//            },
//            ignoreFiles: ['.combo.js', '-min.js']
//        }))
//        .pipe(gulp.dest('public/build/js/'));

    var bulma_calendar = gulp.src('node_modules/bulma-extensions/bulma-calendar/datepicker.js')
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

    var flatpickr = gulp.src('node_modules/flatpickr/dist/flatpickr.js')
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

    var flatpickr_l10n_index = gulp.src('node_modules/flatpickr/dist/l10n/index.js')
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

    var flatpickr_l10n = gulp.src('node_modules/flatpickr/dist/l10n/es.js')
        .pipe(concat('flatpickr.l10n.js'))
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['index.js', 'default.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

    var asgardjs = gulp.src('public/build/js/app.js')
        .pipe(minify({
            ext: {
                src: '-debug.js',
                min: '.min.js'
            },
            ignoreFiles: ['.combo.js', '-min.js']
        }))
        .pipe(gulp.dest('public/build/js/'));

    return merge(bulmajs, bulma_calendar, flatpickr, flatpickr_l10n_index, flatpickr_l10n, asgardjs);
});

var merge_js = gulp.task('merge_js', function() {
    return gulp.src('public/build/js/*.min.js')
        .pipe(concat('app.min.js'))
        .pipe(gulp.dest('public/js/'));
});

gulp.task('default', ['styles', 'minify-css', 'compress_js', 'merge_js'], function() {
    gulp.watch('assets/css/*.scss', ['styles']);
    gulp.watch('public/build/css/*.css', ['minify-css']);
    gulp.watch('public/build/js/*.js', ['compress_js']);
    gulp.watch('public/build/js/*.min.js', ['merge_js']);
});