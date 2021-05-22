<?php

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * Composer dependencies auto installer
 *
 * @package sso-flarum
 */

/**
 * Install composer dependencies automatically
 *
 * @param string|null $composer_dir The path of the folder of this file.
 * @source https://stackoverflow.com/a/25208897
 *
 * @throws Exception
 */
function install_dependencies( ?string $composer_dir = null ) {
	if ( is_callable( 'shell_exec' ) && false === stripos( ini_get( 'disable_functions' ), 'shell_exec' ) ) {
		$result = shell_exec( 'composer install --no-dev' );
		if ( ! empty( $result ) ) {
			return $result;
		}
	}

	if ( empty( $composer_dir ) ) {
		$composer_dir = defined( 'FLARUM_SSO_PATH' ) ? FLARUM_SSO_PATH . '/composer' : __DIR__;
	}

	require "$composer_dir/vendor/autoload.php";

	// Composer\Factory::getHomeDir() method
	// needs COMPOSER_HOME environment variable set.
	putenv( "COMPOSER_HOME=$composer_dir/vendor/bin/composer" );

	// call `composer install` command programmatically.
	$input       = new ArrayInput( array( 'command' => 'install' ) );
	$application = new Application();
	$application->setAutoExit( false ); // prevent `$application->run` method from exiting the script.
	$result = $application->run( $input );

	return 0 === $result ? true : $result;
}
