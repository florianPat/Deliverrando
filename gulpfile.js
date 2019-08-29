const gulp  = require('gulp');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const vueModule = require('gulp-vue-single-file-component');

function vue()
{
    return gulp.src('./Resources/Private/JavaScript/**/*.vue')
        .pipe(vueModule({
            debug: true
        }))
        .pipe(rename({extname: '.js'}))
        .pipe(gulp.dest('./Resources/Public/JavaScript'));
}

function build()
{
    return gulp.src('./Resources/Private/JavaScript/**/*.js')
        .pipe(concat('main.js'))
        .pipe(gulp.dest('./Resources/Public/JavaScript/'));
}

exports.default = gulp.series(vue, build);