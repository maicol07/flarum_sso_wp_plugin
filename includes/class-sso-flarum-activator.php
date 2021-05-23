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
		}
	}
}
