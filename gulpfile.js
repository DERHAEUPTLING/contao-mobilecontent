'use strict';

const gulp = require('gulp');
var cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');

// Compile scripts
gulp.task('scripts', function () {
    return gulp.src('assets/scripts.js')
        .pipe(uglify())
        .pipe(rename('scripts.min.js'))
        .pipe(gulp.dest('./assets'));
});

// Compile styles
gulp.task('styles', function () {
    return gulp.src('assets/styles.css')
        .pipe(cleanCSS())
        .pipe(rename('styles.min.css'))
        .pipe(gulp.dest('./assets'));
});

// Default task
gulp.task('default', ['scripts', 'styles']);
