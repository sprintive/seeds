const gulp = require("gulp"),
  sass = require("gulp-sass"),
  sourcemaps = require("gulp-sourcemaps"),
  cleanFiles = require("gulp-clean"),
  postcss = require("gulp-postcss"),
  gulpIf = require("gulp-if"),
  autoprefixer = require("autoprefixer");

const paths = {
  scss: {
    src: "./scss/style.scss",
    seedsSrc: "./scss/seeds.scss",
    dest: "./css",
    watch: "./scss/**/*.scss",
    bootstrap: "./node_modules/bootstrap/scss/bootstrap.scss"
  },
  js: {
    bootstrap: "./node_modules/bootstrap/dist/js/bootstrap.min.js",
    popper: "node_modules/popper.js/dist/umd/popper.min.js",
    dest: "./js"
  }
};

let env = "development";

// Compile sass into CSS & auto-inject into browsers
function styles() {
  return gulp
    .src([paths.scss.bootstrap, paths.scss.src, paths.scss.seedsSrc])
    .pipe(gulpIf(env == "development", sourcemaps.init()))
    .pipe(sass().on("error", sass.logError))
    .pipe(
      postcss([
        autoprefixer({
          browsers: [
            "Chrome >= 35",
            "Firefox >= 38",
            "Edge >= 12",
            "Explorer >= 10",
            "iOS >= 8",
            "Safari >= 8",
            "Android 2.3",
            "Android >= 4",
            "Opera >= 12"
          ]
        })
      ])
    )
    .pipe(gulpIf(env == "development", sourcemaps.write("./")))
    .pipe(gulp.dest(paths.scss.dest));
}

// Move the javascript files into our js folder
function js() {
  return gulp
    .src([paths.js.bootstrap, paths.js.popper])
    .pipe(gulp.dest(paths.js.dest));
}

// Remove sourcemap files from css.
function clean() {
  return gulp.src("css/*.map").pipe(cleanFiles({ force: true }));
}

const build = gulp.series(
  (done) => {
    env = "production";
    done();
  },
  gulp.parallel(js, styles),
  clean
);

exports.styles = styles;
exports.js = js;
exports.clean = clean;
exports.build = build;
exports.default = build;
