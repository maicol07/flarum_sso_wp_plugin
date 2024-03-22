const gulp = require('gulp');
const del = require('del');
const {zip} = require('gulp-vinyl-zip');

const files = [
	'**/*',
	'*',
	'!composer.phar',
	'!sso-flarum.zip',
	'!wp-cli.phar',
	'!yarn-error.log',
	'!**/svn',
	'!**/svn/**/*',
	'!**/node_modules/',
	'!**/node_modules/**/*',
	'!**/vendor/bin',
	'!**/vendor/bin/**/*',
	'!**/vendor/maicol07/flarum-api-client/docs',
	'!**/vendor/maicol07/flarum-api-client/docs/**/*',
	'!**/vendor/maicol07/flarum-sso-plugin/docs',
	'!**/vendor/maicol07/flarum-sso-plugin/docs/**/*',
	'!**/vendor/maicol07/flarum-sso-plugin/documentation',
	'!**/vendor/maicol07/flarum-sso-plugin/documentation/**/*',
	'!**/vendor/maicol07/flarum-sso-plugin/example',
	'!**/vendor/maicol07/flarum-sso-plugin/example/**/*',
	'!**/vendor/squizlabs',
	'!**/vendor/squizlabs/**/*',
	'!**/vendor/wp-coding-standards',
	'!**/vendor/wp-coding-standards/**/*'
];

/**
 * Clean (deletes) the build and dist directories
 *
 * @returns {*}
 */
function clean() {
	return del('sso-flarum.zip');
}

/**
 * Create the build directory with the required files for release
 *
 * @returns {*}
 */
function pack() {
	return gulp.src(files).pipe(zip('sso-flarum.zip'))
		.pipe(gulp.dest('./'));
}

/**
 * Copy the build directory contents to svn (to push to SVN repo)
 *
 * @returns {*}
 */
function copy_svn() {
	return gulp.src(files.concat(['!**/vendor/symfony/polyfill-mbstring/bootstrap80.php'])).pipe(gulp.dest('svn'));
}

exports.default = gulp.series(clean, pack, copy_svn);
exports.clean = clean;
exports.zip = pack;
exports.copy_svn = copy_svn;
