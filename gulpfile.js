var gulp = require('gulp');
var sass = require('gulp-sass');
var mincss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var del = require('del');

var paths = {
    sass: ['app/Resources/public/sass/**/*.scss'],
    js: ['app/Resources/public/js/**/*.js'],
    images: ['app/Resources/public/img/**/*'],
    dist: 'web/assets'
};

gulp.task('clean', function (cb) {
    del([paths.dist], cb);
});

gulp.task('css', ['clean'], function () {
    gulp.src(paths.sass)
        .pipe(sass({
            noCache: true,
            style: "compressed"
        }))
        .pipe(mincss())
        .pipe(gulp.dest(paths.dist + '/css'));
});

gulp.task('js', ['clean'], function () {
    return gulp.src(paths.js)
        .pipe(uglify())
        .pipe(gulp.dest(paths.dist + '/js'));
});

gulp.task('img', ['clean'], function () {
    return gulp.src(paths.images)
        .pipe(gulp.dest(paths.dist + '/img'));
});

gulp.task('watch', function () {
    gulp.watch(paths.sass, ['css'])
        .on('change', function (evt) {
            console.log(
                '[watcher] File ' + evt.path.replace(/.*(?=sass)/, '') + ' was ' + evt.type + ', compiling...'
            );
        });
});

gulp.task('default', ['css', 'js', 'img']);