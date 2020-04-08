const gulp = require('gulp');
var clean = require('gulp-clean');
var zip = require('gulp-zip');
var merge = require('merge-stream');

function clean_files() {
	var build = gulp.src('build', {read: false, allowEmpty: true})
		.pipe(clean());
	var dist = gulp.src('dist', {read: false, allowEmpty: true})
		.pipe(clean());

	return merge(build, dist);
}

function wp_build() {
	var src = gulp.src('../src/**')
		.pipe(gulp.dest('build/includes/src'));
	var wp = gulp.src('**')
		.pipe(gulp.dest('build/'));

	return merge(src, wp);
}

function wp_zip() {
	return gulp.src('build/*')
		.pipe(zip('flarum_sso_wp_plugin.zip'))
		.pipe(gulp.dest('dist'));
}

exports.default = gulp.series(clean_files, wp_build)
exports.zip = gulp.series(clean_files, wp_build, wp_zip);
