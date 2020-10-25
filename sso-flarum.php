<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://maicol07.it
 * @since             1.0.0
 * @package           sso-flarum
 *
 * @wordpress-plugin
 * Plugin Name:       SSO for Flarum
 * Plugin URI:        https://github.com/maicol07/flarum-sso-wp-plugin
 * Description:       Plugin for your WordPress website to get the SSO extension working
 * Version:           2.0
 * Author:            maicol07
 * Author URI:        https://maicol07.it
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sso-flarum
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'FLARUM_SSO_VERSION', '2.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-activator.php';
	SSO_Flarum_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-deactivator.php';
	SSO_Flarum_Disabler::deactivate();
}

register_activation_hook( __FILE__, 'activate_flarum_sso' );
register_deactivation_hook( __FILE__, 'deactivate_flarum_sso' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_flarum_sso() {
	$plugin = new SSO_Flarum();
	$plugin->run();
}

run_flarum_sso();

// Composer Autoloader.
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

use Maicol07\SSO\Flarum;
use Maicol07\SSO\User;

/**
 * Main features
 */
function main() {
	global $flarum;
	global $flarum_user;

	$verify = get_option( 'flarum_sso_plugin_verify_ssl', true );
	if ( is_numeric( $verify ) ) {
		$verify = ( (int) $verify ) ? true : false;
	}

	$flarum = new Flarum(
		array(
			'url'               => get_option( 'flarum_sso_plugin_flarum_url' ),
			'root_domain'       => get_option( 'flarum_sso_plugin_root_domain' ),
			'api_key'           => get_option( 'flarum_sso_plugin_api_key' ),
			'password_token'    => get_option( 'flarum_sso_plugin_password_token' ),
			'lifetime'          => get_option( 'flarum_sso_plugin_lifetime', 14 ),
			'verify_ssl'        => $verify,
			'set_groups_admins' => get_option( 'flarum_sso_plugin_set_groups_admins', true ),
		)
	);
	$flarum = apply_filters( 'flarum_sso_plugin_init_flarum', $flarum );

	$user     = wp_get_current_user();
	$username = null;
	if ( $user instanceof WP_User && 0 !== $user->ID ) {
		$username = $user->user_login;
	}
	$flarum_user                           = new User( $username, $flarum );
	$flarum_user                           = apply_filters( 'flarum_sso_plugin_init_flarum_user', $flarum_user );

	/**
	 * Redirect user to Flarum
	 *
	 * @param string $redirect_to If redirect to is 'forum' user get redirected to Flarum.
	 * @param string $request_redirect The requested redirect destination URL.
	 * @param WP_User|WP_Error $user WP User (or error).
	 *
	 * @return string
	 */
	function flarum_sso_login_redirect( string $redirect_to, string $request_redirect, $user ): string {
		global $flarum;

		if ( 'forum' === $redirect_to && $user instanceof WP_User ) {
			$flarum->redirect();
		}

		return $redirect_to;
	}
	add_filter( 'login_redirect', 'flarum_sso_login_redirect', 10, 3 );

	/**
	 * Login to flarum
	 *
	 * @param null|WP_User|WP_Error $user WordPress User (or error).
	 * @param string $username Username typed in the login form.
	 * @param string $password Password typed in the login form.
	 *
	 * @return WP_Error|WP_User
	 */
	function flarum_sso_login( $user, string $username, string $password ) {
		if ( ! $user instanceof WP_User ) {
			return new WP_Error();
		}
		global $flarum_user;

		$flarum_user->attributes->username = $user->user_login;
		$flarum_user->fetchUser();

		$flarum_user->attributes->password = $password;
		$flarum_user->attributes->email    = $user->user_email;
		$flarum_user->attributes->bio      = $user->user_description;

		$flarum_user = apply_filters( 'flarum_sso_plugin_before_login', $flarum_user, $user );

		$flarum_user->login();

		return $user;
	}
	add_filter( 'authenticate', 'flarum_sso_login', 35, 3 );

	/**
	 * Logout from Flarum
	 */
	function flarum_sso_logout() {
		global $flarum;

		$flarum->logout();
	}

	add_action( 'wp_logout', 'flarum_sso_logout' );

	/**
	 * Delete the user from Flarum when has been deleted from WP
	 *
	 * @param int $user_id User ID.
	 */
	function flarum_sso_delete_user( int $user_id ) {
		global $flarum_user;

		$flarum_user->delete();
	}

	add_action( 'delete_user', 'flarum_sso_delete_user', 10 );

	/**
	 * Update user password when resetted through email link
	 *
	 * @param WP_User $user WP User.
	 * @param string $password New password.
	 */
	function flarum_sso_update_user_password( WP_User $user, string $password ) {
		global $flarum_user;

		$flarum_user->attributes->password = $password;
		$flarum_user->update();
	}

	add_action( 'after_password_reset', 'flarum_sso_update_user_password', 10, 3 );

	/**
	 * Update user details in Flarum when they change
	 *
	 * @param int $user_id User ID.
	 * @param WP_User $old_user Old user data.
	 */
	function flarum_sso_update_details( int $user_id, WP_User $old_user ) {
		global $flarum;

		// Don't use global user variables, as the update can be done from another user (like an admin).

		$user        = get_userdata( $user_id );
		$flarum_user = new User( $old_user->user_login, $flarum );

		$flarum_user->attributes->username    = $user->user_login;
		$flarum_user->attributes->email       = $user->user_email;
		$flarum_user->attributes->bio         = $user->user_description;
		$flarum_user->attributes->displayName = $user->display_name;
		$flarum_user->attributes->avatarUrl   = get_avatar_url( $user, array( 'size' => 100 ) );

		$flarum_user->update();
	}
	add_action( 'profile_update', 'flarum_sso_update_details', 10, 2 );
}

if ( get_option( 'flarum_sso_plugin_active' ) ) {
	add_action( 'plugins_loaded', 'main' );
}
