const gulp = require('gulp');
const del = require('del');
const zip = require('gulp-vinyl-zip').zip;
const merge = require('merge-stream');

/**
 * Clean (deletes) the build and dist directories
 *
 * @returns {*}
 */
function clean_files() {
	return del([
		'build/**/*',
		'/build/',
		'dist/**/*',
		'/dist/'
	]);
}

/**
 * Create the build directory with the required files for release
 *
 * @returns {*}
 */
function wp_build() {
	return gulp.src([
		'**',
		'index.php',
		'!wp-cli.phar',
		'!**/svn/',
		'!**/svn/**/*',
		'!**/node_modules/',
		'!**/node_modules/**/*',
		'!**/vendor/maicol07/flarum-api-client/docs',
		'!**/vendor/maicol07/flarum-api-client/docs/**/*',
		'!**/vendor/maicol07/flarum-sso-plugin/docs',
		'!**/vendor/maicol07/flarum-sso-plugin/docs/**/*',
		'!**/vendor/maicol07/flarum-sso-plugin/example',
		'!**/vendor/maicol07/flarum-sso-plugin/example/**/*',
		'!**/vendor/squizlabs',
		'!**/vendor/squizlabs/**/*',
		'!**/vendor/wp-coding-standards',
		'!**/vendor/wp-coding-standards/**/*'
	]).pipe(gulp.dest('build/'));
}

/**
 * Create the plugin zip
 *
 * @returns {*}
 */
function wp_zip() {
	return gulp.src('build/**/*')
		.pipe(zip('sso-flarum.zip'))
		.pipe(gulp.dest('dist'));
}

/**
 * Copy the build directory contents to svn (to push to SVN repo)
 *
 * @returns {*}
 */
function copy_svn() {
	del([
		'svn/**/*',
		'!svn/.svn/**/*'
	]);
	return gulp.src('build/**/*').pipe(gulp.dest('svn'));
}

exports.default = gulp.series(clean_files, wp_build, copy_svn);
exports.clean = clean_files;
exports.zip = wp_zip;
exports.copy_svn = copy_svn;
