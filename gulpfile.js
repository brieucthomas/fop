var gulp = require('gulp');
var sass = require('gulp-sass');
var mincss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var del = require('del');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var jpegtran = require('imagemin-jpegtran');
var svgo = require('imagemin-svgo');

var paths = {
    sass:  ['app/Resources/assets/sass/**/*.scss'],
    js:    ['app/Resources/assets/js/**/*.js'],
    img:   ['app/Resources/assets/img/**/*'],
    fonts: ['app/Resources/assets/fonts/**/*'],
    dist:  'web/assets'
};

gulp.task('clean', function (cb) {
    del([paths.dist], cb);
});

gulp.task('css', function () {
    gulp.src(paths.sass)
        .pipe(sass({
            noCache: true,
            style: "compressed"
        }))
        .pipe(mincss())
        .pipe(gulp.dest(paths.dist + '/css'));
});

gulp.task('js', function () {
    return gulp.src(paths.js)
        .pipe(uglify())
        .pipe(gulp.dest(paths.dist + '/js'));
});

gulp.task('img', function () {
    return gulp.src(paths.img)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant(), jpegtran(), svgo()]
        }))
        .pipe(gulp.dest(paths.dist + '/img'));
});

gulp.task('fonts', function () {
    return gulp.src(paths.fonts)
        .pipe(gulp.dest(paths.dist + '/fonts'));
});

gulp.task('watch', function () {
    gulp.watch(paths.sass, ['css'])
        .on('change', function (evt) {
            console.log(
                '[watcher] File ' + evt.path.replace(/.*(?=sass)/, '') + ' was ' + evt.type + ', compiling...'
            );
        });
});

gulp.task('default', ['clean', 'css', 'js', 'img', 'fonts']);

gulp.task('heroku:production', ['clean', 'css', 'js', 'img', 'fonts']);