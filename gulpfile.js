const gulp = require('gulp');
const clean = require('gulp-clean');
const zip = require('gulp-vinyl-zip').zip;
const merge = require('merge-stream');

function clean_files() {
	const build = gulp.src('build', {read: false, allowEmpty: true})
		.pipe(clean());
	const dist = gulp.src('dist', {read: false, allowEmpty: true})
		.pipe(clean());

	return merge(build, dist);
}

function wp_build() {
	const src = gulp.src('../src/**')
		.pipe(gulp.dest('build/includes/src'));
	const wp = gulp.src([
		'**',
		'!**/node_modules/',
		'!**/node_modules/**/*'
	]).pipe(gulp.dest('build/'));

	return merge(src, wp);
}

function wp_zip() {
	return gulp.src('build/**/*')
		.pipe(zip('sso-flarum.zip'))
		.pipe(gulp.dest('dist'));
}

exports.default = gulp.series(clean_files, wp_build);
exports.clean = clean_files;
exports.zip = wp_zip;
