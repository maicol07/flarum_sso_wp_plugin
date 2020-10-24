<?php
/**
 * Fired during plugin activation.
 *
 * @since      1.0.0
 * @package    sso-flarum
 * @subpackage sso-flarum/includes
 * @author     maicol07 <maicolbattistini@live.it>
 */
class Flarum_SSO_Activator {

	/**
	 * Activate and update the plugin
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void {
		$old_version = get_option( 'flarum_sso_plugin_version', '1.0' );

		if ( version_compare( FLARUM_SSO_VERSION, $old_version, '>' ) ) {
			$files = glob( 'updates/*.php' );

			foreach ( $files as $file ) {
				if ( version_compare( basename( $file, '.php' ), $old_version, '>' ) ) {
					require_once $file;
				}
			}
		}
	}

}
