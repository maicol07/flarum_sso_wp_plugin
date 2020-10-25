<?php
/**
 * Define the internationalization functionality
 *
 * @link       https://maicol07.it
 * @since      1.0.0
 *
 * @package    sso-flarum
 * @subpackage sso-flarum/includes
 */

/**
 * Define the internationalization functionality.
 *
 * @since      1.0.0
 * @package    sso-flarum
 * @subpackage sso-flarum/includes
 * @author     maicol07 <maicolbattistini@live.it>
 */
class SSO_Flarum_Localization {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void {
		load_plugin_textdomain(
			'sso-flarum',
			false,
			dirname( plugin_basename( __FILE__ ), 2 ) . '/languages/'
		);
	}
}
