const PATH_BUILD_CSS = './static/css/';
const PATH_SRC_CSS = './src/scss/app.scss';
const PATH_WATCH_CSS = './src/scss/**/*.scss';

const PATH_CLEAN = './static/*';

// Gulp
import gulp from 'gulp';
import sync from 'browser-sync';
import compilerSass from 'sass';
import gulpSass from 'gulp-sass';
import autoprefixer from 'gulp-autoprefixer';
import cleanCss from 'gulp-clean-css';
import cache from 'gulp-cache';
import rename from 'gulp-rename';
import notify from 'gulp-notify';
import clean from 'gulp-clean';

const browserSync = sync.create();
const sass = gulpSass(compilerSass);


// styles build
gulp.task('css:build', () => {
  return gulp.src(PATH_SRC_CSS)
    .pipe(sass({
      outputStyle: 'expanded'
    }).on('error', notify.onError()))
    .pipe(autoprefixer())
   .pipe(gulp.dest(PATH_BUILD_CSS))
    .pipe(rename({
      basename: 'app',
      suffix: '.min'
    }))
    .pipe(cleanCss())
    .pipe(gulp.dest(PATH_BUILD_CSS))
    .pipe(browserSync.stream())
});

// public assets clean
gulp.task('clean:build', function () {
  return gulp.src(
    [PATH_CLEAN],
    {read: false}
  )
    .pipe(clean({force: true})); // force option
});

// cache clear
gulp.task('cache:clear', () => {
  cache.clearAll();
});

// build
gulp.task('build',
  gulp.series( //'clean:build',
    gulp.parallel(
      'css:build',
    )
  )
);

// gulp watch
gulp.task('watch', () => {
  gulp.watch(PATH_WATCH_CSS, gulp.series('css:build'));
});

// gulp build
gulp.task('default', gulp.series(
  'build',
  gulp.parallel('watch')
));

