var gulp = require('gulp');
var exec = require('child_process').exec;
var del = require('del');
var sass = require('gulp-sass');
var mincss = require('gulp-clean-css');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var jpegtran = require('imagemin-jpegtran');
var svgo = require('imagemin-svgo');

gulp.task('task', function (cb) {
    exec('ping localhost', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
        cb(err);
    });
});

var paths = {
    sass:  ['app/Resources/assets/sass/**/*.scss'],
    js:    ['app/Resources/assets/js/**/*.js'],
    img:   ['app/Resources/assets/img/**/*'],
    fonts: ['app/Resources/assets/fonts/**/*.woff'],
    dist:  'web/assets'
};

gulp.task('clean', function (cb) {
    del.sync([paths.dist], cb);
});

gulp.task('css', function () {
    gulp.src(paths.sass)
        .pipe(sass({
            noCache: true,
            style: "compressed",
            includePaths: ['node_modules', 'web/vendor']
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
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({plugins: [{removeViewBox: true}]})
        ]))
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

gulp.task('heroku:production', ['default']);