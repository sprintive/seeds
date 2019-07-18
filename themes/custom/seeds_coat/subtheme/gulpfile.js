var gulp = require("gulp"),
  sass = require("gulp-sass"),
  cleanCss = require("gulp-clean-css"),
  autoprefixer = require("gulp-autoprefixer"),
  sourcemaps = require("gulp-sourcemaps"),
  livereload = require("gulp-livereload"),
  rtlcss = require('gulp-rtlcss'),
  rename = require('gulp-rename'),
  del = require("del");

gulp.task(
  "sass",
  gulp.series(function(done) {
    gulp
      .src(["./scss/style.scss"])
      .pipe(sourcemaps.init())
      .pipe(
        sass({
          includePaths: [
            "node_modules/font-awesome-sass/assets/stylesheets/"
          ]
        }).on("error", sass.logError)
      )
      .pipe(
        autoprefixer({
          Browserslist: [
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
      )
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest("./css"))
      .pipe(livereload());

      gulp
      .src(["./scss/style.scss"])
      .pipe(sourcemaps.init())
      .pipe(
        sass({
          includePaths: [
            "node_modules/font-awesome-sass/assets/stylesheets/"
          ]
        }).on("error", sass.logError)
      )
      .pipe(rtlcss()) // Convert to RTL.
      .pipe(rename({ suffix: '-rtl' })) // Append "-rtl" to the filename.
			.pipe(sourcemaps.write('./')) // Output source maps.
			.pipe(cleanCss())
			.pipe(gulp.dest('./css')) // Output RTL stylesheets.
      .pipe(livereload());
    done();
  })
);
gulp.task(
  "copy",
  gulp.series(function(done) {
    gulp
      .src([
        "node_modules/font-awesome-sass/assets/fonts/font-awesome/fontawesome-webfont.*"
      ])
			.pipe(gulp.dest("fonts/font-awesome/"));
		done();
  })
);

gulp.task(
  "clean",
  gulp.series(function(done) {
    del(["fonts/font-awesome/*","css"]);
    done();
  })
);

gulp.task(
  "build",
  gulp.series("clean","copy","sass", function(done) {
    done();
  })
);

gulp.task(
  "watch",
  gulp.series("copy", "sass", function(done) {
    livereload.listen();
    gulp.watch("./scss/**/*.scss", gulp.series("sass"));
    done();
  })
);
