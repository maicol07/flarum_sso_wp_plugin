<?php
/**
 * Activation hook
 *
 * @package sso-flarum
 */

/**
 * Fired during plugin activation.
 *
 * @since      1.0.0
 * @package    sso-flarum
 * @subpackage sso-flarum/includes
 * @author     maicol07 <maicolbattistini@live.it>
 */
class SSO_Flarum_Activator {

	/**
	 * Activate and update the plugin
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void {
		$old_version = get_option( 'flarum_sso_plugin_version', '1.0' );

		if ( version_compare( FLARUM_SSO_VERSION, $old_version, '>' ) ) {
			// Apply migrations.
			$files = glob( 'updates/*.php' );

			foreach ( $files as $file ) {
				if ( version_compare( basename( $file, '.php' ), $old_version, '>' ) ) {
					require_once $file;
				}
			}

			if ( get_option( 'flarum_sso_plugin_version', false ) === false ) {
				add_option( 'flarum_sso_plugin_version' );
			}
			update_option( 'flarum_sso_plugin_version', FLARUM_SSO_VERSION );

			if ( get_option( 'flarum_sso_plugin_disable_composer_installer' ) ) {
				return;
			}
			// Run composer install.
			require 'composer/composer-install.php';
			try {
				$result = install_dependencies( ( defined( 'FLARUM_SSO_PATH' ) ? FLARUM_SSO_PATH : __DIR__ ) . '/includes/composer' );
				if ( ! $result ) {
					throw new Exception( $result );
				}
			} catch ( Exception $e ) {
				/** @noinspection ForgottenDebugOutputInspection */
				wp_die(
					sprintf(
						__( "Can't download dependencies. Please run the following command or download the plugin zip with all the dependencies from %s:<br><code>composer install --no-dev</code><br><br>Exception message: {$e->getMessage()}" ),
						'<a href="https://github.com/maicol07/flarum_sso_wp_plugin/releases">' . __( 'Github releases' ) . '</a>'
					)
				);
			}
		}
	}

}
