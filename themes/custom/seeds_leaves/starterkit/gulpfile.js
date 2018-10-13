var gulp = require('gulp'),
	livereload = require('gulp-livereload'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	sourcemaps = require('gulp-sourcemaps'),
	del = require('del');


gulp.task('sass', function () {
  gulp.src('./assets/scss/style.scss')
    .pipe(sourcemaps.init())
        .pipe(sass({
					includePaths: [
						'node_modules/bootstrap-sass/assets/stylesheets/',
						'node_modules/bootstrap-sass-rtl/',
						'node_modules/font-awesome-sass/assets/stylesheets/'
					]
				}).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version'))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./assets/css'));
});

gulp.task('copy', function() {
	gulp.src(['node_modules/font-awesome-sass/assets/fonts/font-awesome/fontawesome-webfont.*']).pipe(gulp.dest('assets/fonts/font-awesome/'));
	gulp.src(['node_modules/bootstrap-sass/assets/javascripts/bootstrap/*.js']).pipe(gulp.dest('assets/js/bootstrap/'));
	gulp.src(['node_modules/bootstrap-sass/assets/fonts/bootstrap/glyphicons-halflings-regular.*']).pipe(gulp.dest('assets/fonts/bootstrap/'));
});

gulp.task('clean', function () {
    del(['assets/fonts/font-awesome', 'assets/fonts/bootstrap', 'assets/css', 'assets/js/bootstrap']);
});

gulp.task('build', ['clean'], function(){
		gulp.start(['sass', 'copy']);
});

gulp.task('watch', ['clean'], function(){
		gulp.start(['sass', 'copy']);
    livereload.listen();

    gulp.watch('./assets/scss/**/*.scss', ['sass']);
    gulp.watch(['./assets/css/style.css'], function (files){
        livereload.changed(files)
    });
});
