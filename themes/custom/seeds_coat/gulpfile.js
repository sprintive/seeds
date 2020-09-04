let gulp = require('gulp'),
  sass = require('gulp-sass'),
  sourcemaps = require('gulp-sourcemaps'),
  cleanCss = require('gulp-clean-css'),
  rename = require('gulp-rename'),
  postcss = require('gulp-postcss'),
  autoprefixer = require('autoprefixer');

const paths = {
  scss: {
		src: './scss/style.scss',
		seedsSrc: './scss/seeds.scss',
    dest: './css',
    watch: './scss/**/*.scss',
    bootstrap: './node_modules/bootstrap/scss/bootstrap.scss'
  },
  js: {
    bootstrap: './node_modules/bootstrap/dist/js/bootstrap.min.js',
    popper: 'node_modules/popper.js/dist/umd/popper.min.js',
    dest: './js'
  }
}

// Compile sass into CSS & auto-inject into browsers
function styles () {
	return gulp.src([paths.scss.bootstrap, paths.scss.src, paths.scss.seedsSrc])
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer({
      browsers: [
        'Chrome >= 35',
        'Firefox >= 38',
        'Edge >= 12',
        'Explorer >= 10',
        'iOS >= 8',
        'Safari >= 8',
        'Android 2.3',
        'Android >= 4',
        'Opera >= 12']
    })]))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(paths.scss.dest))
    .pipe(cleanCss())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(paths.scss.dest))
}

// Move the javascript files into our js folder
function js () {
  return gulp.src([paths.js.bootstrap, paths.js.popper])
    .pipe(gulp.dest(paths.js.dest))
}

const build = gulp.series(styles, gulp.parallel(js))

exports.styles = styles
exports.js = js

exports.default = build