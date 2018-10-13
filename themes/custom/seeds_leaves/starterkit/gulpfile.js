var gulp = require('gulp'),
	livereload = require('gulp-livereload'),
	uglify = require('gulp-uglify'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	sourcemaps = require('gulp-sourcemaps'),
	del = require('del');


gulp.task('sass', function () {
  gulp.src('./src/scss/style.scss')
    .pipe(sourcemaps.init())
        .pipe(sass({
					outputStyle: 'compressed',
					includePaths: [
						'node_modules/bootstrap-sass/assets/stylesheets/',
						'node_modules/bootstrap-sass-rtl/',
						'node_modules/font-awesome-sass/assets/stylesheets/'
					]
				}).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./css'));
});

gulp.task('fonts', function() {
	gulp.src(['node_modules/font-awesome-sass/assets/fonts/font-awesome/fontawesome-webfont.*']).pipe(gulp.dest('fonts/font-awesome/'));
	return gulp.src(['node_modules/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.*']).pipe(gulp.dest('fonts/bootstrap/'));
});

gulp.task('clean', function () {
    return del(['fonts/', 'css/', 'js/']);
});

//Uglifies javascript
gulp.task('uglify', function() {
  return gulp.src('./src/js/*.js')
    .pipe(uglify())
    .pipe(gulp.dest('./js/'));
});

gulp.task('build', ['clean'],function(){
		gulp.start(['sass', 'uglify', 'fonts']);
});

gulp.task('watch', ['clean'],function(){
		gulp.start(['sass', 'uglify', 'fonts']);
    livereload.listen();

    gulp.watch('./src/scss/**/*.scss', ['sass']);
    gulp.watch('./src/js/**/*.js', ['eslint']);
    gulp.watch(['./css/style.css', './**/*.html.twig', './js/*.js'], function (files){
        livereload.changed(files)
    });
});
