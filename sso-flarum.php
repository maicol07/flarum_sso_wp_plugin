<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://maicol07.it
 * @since             1.0.0
 * @package           sso-flarum
 *
 * @wordpress-plugin
 * Plugin Name:       SSO for Flarum
 * Plugin URI:        https://github.com/maicol07/flarum-sso-wp-plugin
 * Description:       Plugin for your WordPress website to get the SSO extension working
 * Version:           1.2
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
define( 'FLARUM_SSO_VERSION', '1.2' );

/**
 * The code that runs during plugin activation.
 */
function activate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-activator.php';
	Flarum_SSO_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-deactivator.php';
	Flarum_SSO_Deactivator::deactivate();
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
	$plugin = new Flarum_sso_plugin();
	$plugin->run();
}

run_flarum_sso();

/**
 * Adds settings and donate links to plugins page
 *
 * @param $links
 *
 * @return mixed
 */
function flarum_sso_add_links_to_admin_plugins_page( $links ) {
	$donate_url  = esc_url( 'https://www.paypal.me/maicol072001/10eur' );
	$donate_link = '<a href="' . $donate_url . '">' . __( "Donate", 'sso-flarum' ) . '</a>'; //DONATE

	// Prepend donate link to links array
	array_unshift( $links, $donate_link );

	$url           = esc_url( get_admin_url() . 'options-general.php?page=sso-flarum-settings' );
	$settings_link = '<a href="' . $url . '">' . __( "Settings", 'sso-flarum' ) . '</a>';

	// Prepend settings link to links array
	array_unshift( $links, $settings_link );

	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'flarum_sso_add_links_to_admin_plugins_page' );

/**
 * Adds settings and donate links to plugin meta data in plugins page
 *
 * @param $links
 * @param $file
 *
 * @return array
 */
function flarum_sso_plugin_add_meta_to_admin_plugins_page( $links, $file ): array {
	if ( strpos( $file, plugin_basename( __FILE__ ) ) !== false ) {
		$donate_url = esc_url( 'https://www.paypal.me/maicol072001/10eur' );

		$url = esc_url( get_admin_url() . 'options-general.php?page=sso-flarum-settings' );

		$review_url = esc_url( "https://wordpress.org/support/plugin/sso-flarum/reviews/#new-post" );
		$new_links  = [
			'<a href="' . $url . '"><span class="dashicons dashicons-admin-generic"></span> ' . __( "Settings", 'sso-flarum' ) . '</a>',
			'<a href="' . $review_url . '"><span class="dashicons dashicons-star-filled"></span> ' . __( "Leave a review", 'sso-flarum' ) . '</a>',
			'<a href="' . $donate_url . '"><span class="dashicons dashicons-heart"></span> ' . __( "Donate", 'sso-flarum' ) . '</a>'
		];
		// Add new links to existing links
		$links = array_merge( $links, $new_links );
	}

	return $links;
}

add_filter( 'plugin_row_meta', 'flarum_sso_plugin_add_meta_to_admin_plugins_page', 10, 2 );

/*
 * SSO
 */
require_once plugin_dir_path( __FILE__ ) . "vendor/autoload.php";

use Maicol07\SSO\Flarum;
use Maicol07\SSO\User;

function print_wp_path_js() {
	echo '<script>
		WP_PATH = "' . get_site_url() . '";
		</script>';
}

add_action( 'wp_head', 'print_wp_path_js' );

if ( get_option( 'flarum_sso_plugin_active' ) ) {
	$flarum   = new Flarum( [
		'url'               => get_option( 'flarum_sso_plugin_flarum_url' ),
		'root_domain'       => get_option( 'flarum_sso_plugin_root_domain' ),
		'api_key'           => get_option( 'flarum_sso_plugin_api_key' ),
		'password_token'    => get_option( 'flarum_sso_plugin_password_token' ),
		'lifetime'          => get_option( 'flarum_sso_plugin_lifetime', 14 ),
		'insecure'          => get_option( 'flarum_sso_plugin_insecure', false ),
		'set_groups_admins' => get_option( 'flarum_sso_plugin_set_groups_admins', true )
	] );
	$user     = wp_get_current_user();
	$username = null;
	if ( $user instanceof WP_User ) {
		$username = $user->user_login;
	}
	$flarum_user = new User( $username, $flarum );

	/**
	 * Redirect user to Flarum
	 *
	 * @param string $redirect_to
	 * @param string $request_redirect
	 * @param WP_User|WP_Error $user
	 *
	 * @return string
	 */
	function flarum_sso_login_redirect( string $redirect_to, string $request_redirect, $user ): string {
		global $flarum;

		if ( $redirect_to === 'forum' && $user instanceof WP_User ) {
			$flarum->redirect();
		}

		return $redirect_to;
	}

	add_filter( 'login_redirect', 'flarum_sso_login_redirect', 10, 3 );

	/**
	 * Allow to login with email
	 *
	 * @param string $username
	 */
	function wp_authenticate_by_email( string &$username ) {
		$user = get_user_by( 'email', $username );

		if ( ! $user ) {
			$username = $user->user_login;
		}

	}

	add_action( 'wp_authenticate', 'wp_authenticate_by_email' );

	/**
	 * Login to flarum
	 *
	 * @param null|WP_User|WP_Error $user
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return WP_Error|WP_User
	 */
	function flarum_sso_login( $user, string $username, string $password ) {
		if ( ! $user instanceof WP_User ) {
			return new WP_Error();
		}
		global $flarum_user;

		$flarum_user->attributes->username = $user->user_login;
		$flarum_user->attributes->password = $password;
		$flarum_user->attributes->email    = $user->user_email;
		$flarum_user->attributes->bio      = $user->user_description;
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

	function flarum_sso_delete_user( $user_id ) {
		global $flarum_user;

		$flarum_user->delete();
	}

	add_action( 'delete_user', 'flarum_sso_delete_user', 10 );

	function flarum_sso_update_user_password( WP_User $user, string $password ) {
		global $flarum_user;

		$flarum_user->attributes->password = $password;
		$flarum_user->update();
	}

	add_action( 'after_password_reset', 'flarum_sso_update_user_password', 10, 3 );

	function flarum_sso_update_details() {
		global $user;
		global $flarum_user;

		$flarum_user->attributes->username = $user->user_login;
		$flarum_user->attributes->email    = $user->user_email;
		$flarum_user->attributes->bio      = $user->user_description;
		$flarum_user->update();
	}

	add_action( 'profile_update', 'flarum_sso_update_details' );
}
