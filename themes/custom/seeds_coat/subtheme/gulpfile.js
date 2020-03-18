const gulp = require("gulp"),
  sass = require("gulp-sass"),
  autoprefixer = require("gulp-autoprefixer"),
  sourcemaps = require("gulp-sourcemaps"),
  livereload = require("gulp-livereload"),
  rtlcss = require("gulp-rtlcss"),
  rename = require("gulp-rename"),
  config = require("./theme.json"),
  cleanCss = require("gulp-clean-css"),
  net = require("net"),
  gulpPipeIf = require("gulp-if"),
  colors = require("colors"),
  stylelint = require("gulp-stylelint"),
  del = require("del");

// Set this to false if you don't want rtl styling.
let rtlEnabled = config.rtlEnabled;
// Live reload port.
let livereloadPort = config.livereloadPort;
// #########

let isDevelopment = true;

function prefix() {
  return autoprefixer({
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
  });
}

function compileSass() {
  return sass({
    includePaths: ["node_modules/font-awesome-sass/assets/stylesheets/"]
  }).on("error", sass.logError);
}

function lint(done) {
  return gulp.src("scss/**/*.scss").pipe(
    stylelint({
      reporters: [{ formatter: "string", console: true }]
    }).on("error", () => {
      throw new Error();
    })
  );
}

function styles() {
  return gulp
    .src(["./scss/style.scss"])
    .pipe(gulpPipeIf(isDevelopment, sourcemaps.init()))
    .pipe(compileSass())
    .pipe(prefix())
    .pipe(gulpPipeIf(isDevelopment, sourcemaps.write("./")))
    .pipe(gulp.dest("./css"))
    .pipe(gulpPipeIf(isDevelopment, livereload()));
}

function stylesRtl() {
  return (
    gulp
      .src(["./scss/style.scss"])
      .pipe(gulpPipeIf(isDevelopment, sourcemaps.init()))
      .pipe(gulpPipeIf(rtlEnabled, compileSass()))
      .pipe(prefix())
      // Convert to rtl using rtlCss
      .pipe(rtlcss())
      // Append "-rtl" to the filename.
      .pipe(rename({ suffix: "-rtl" }))
      .pipe(gulpPipeIf(isDevelopment, sourcemaps.write("./")))
      .pipe(gulpPipeIf(rtlEnabled, gulp.dest("./css")))
      .pipe(gulpPipeIf(isDevelopment, livereload()))
  );
}

function portInUse(port, callback) {
  var server = net.createServer(function(socket) {
    socket.write("Echo server\r\n");
    socket.pipe(socket);
  });

  server.listen(port, "127.0.0.1");
  server.on("error", function(e) {
    callback(true);
  });
  server.on("listening", function(e) {
    server.close();
    callback(false);
  });
}

function minifyCss() {
  return gulp
    .src("./css/*")
    .pipe(cleanCss())
    .pipe(gulp.dest("./css"));
}

function copy() {
  return gulp
    .src([
      "node_modules/font-awesome-sass/assets/fonts/font-awesome/fontawesome-webfont.*"
    ])
    .pipe(gulp.dest("fonts/font-awesome/"));
}

function clean() {
  // Clean old folders.
  del(["fonts/font-awesome/*", "fonts/bootstrap", "css", "js/bootstrap"]);
  // Clean sourcemap files.
  del("css/*.map");
}

function gulpIf(condition, callback) {
  if (condition) {
    return callback;
  }

  return done => done();
}

gulp.task(
  "build",
  gulp.series(done => {
    isDevelopment = false;
    clean();
    copy();
    gulp.series(styles, gulpIf(rtlEnabled, stylesRtl), minifyCss)();
    done();
  })
);

gulp.task(
  "watch",
  gulp.series(done => {
    clean();
    copy();
    gulp.parallel(styles, gulpIf(rtlEnabled, stylesRtl))();
    portInUse(livereloadPort, inUse => {
      if (inUse) {
        console.log(`##############################`.bgRed);
        console.log(
          `Port "${livereloadPort}" is currently in use. Use "npm run kill" to kill the port.`
            .bgRed.white
        );
        console.log(`##############################`.bgRed);
      } else {
        livereload.listen({ port: livereloadPort });
      }
    });

    gulp.watch("./scss/**/*.scss", done => {
      gulp.series(lint, styles, gulpIf(rtlEnabled, stylesRtl))();
      done();
    });
    done();
  })
);
