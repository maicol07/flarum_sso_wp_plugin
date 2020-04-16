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
 * Version:           1.0.1
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
define( 'FLARUM_SSO_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 */
function activate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-activator.php';
	Flarum_sso_plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_flarum_sso() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sso-flarum-deactivator.php';
	Flarum_sso_plugin_Deactivator::deactivate();
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
function flarum_sso_plugin_add_meta_to_admin_plugins_page( $links, $file ) {
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

if ( get_option( 'flarum_sso_plugin_active' ) ) {
	$flarum = new Flarum(
		get_option( 'flarum_sso_plugin_flarum_url' ),
		get_option( 'flarum_sso_plugin_root_domain' ),
		get_option( 'flarum_sso_plugin_api_key' ),
		get_option( 'flarum_sso_plugin_password_token' ),
		get_option( 'flarum_sso_plugin_lifetime', 14 ),
		get_option( 'flarum_sso_plugin_insecure', false )
	);

	/**
	 * Redirect user to Flarum
	 *
	 * @param $redirect_to
	 * @param $request
	 * @param $user
	 *
	 * @return string
	 */
	function flarum_sso_login_redirect( $redirect_to, $request, $user ) {
		global $flarum;

		if ( $redirect_to === 'forum' && $user instanceof WP_User ) {
			$flarum->redirectToForum();
		}

		return $redirect_to;
	}

	add_filter( 'login_redirect', 'flarum_sso_login_redirect', 10, 3 );

	/**
	 * Login to flarum
	 *
	 * @param $user
	 *
	 * @param $username
	 * @param $password
	 * @param null|array $groups
	 *
	 * @return WP_User|null
	 */
	function flarum_sso_login( $user, $username, $password, $groups = null ) {
		if ( ! $user instanceof WP_User ) {
			return null;
		}
		global $flarum;

		$flarum->login( $username, $user->user_email, $password, $groups );

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
		global $flarum;

		$user = new WP_User( $user_id );
		$flarum->delete( $user->user_login );
	}

	add_action( 'delete_user', 'flarum_sso_delete_user', 10 );

	if ( get_option( 'flarum_sso_plugin_pro_active' ) ) {
		function pro_cron( $schedules ) {
			$schedules['every_month'] = array(
				'interval' => 60 * 60 * 24 * 30,
				'display'  => esc_html__( 'Every Month' ), );
			return $schedules;
		}
		add_filter( 'cron_schedules', 'pro_cron' );

		function flarum_sso_check_pro() {
			$r = Requests::post( 'https://' . get_option( 'flarum_sso_plugin_verification_server', 'maicol07.it' ) . '/flarum_sso/wp_check.php',
				[], [
					'sub_id' => get_option( 'flarum_sso_plugin_pro_key' ),
					'url'    => get_site_url()
				], get_option( 'flarum_sso_plugin_insecure' ) ? [ 'verify' => false ] : [] );
			$response = json_decode($r->body);
			if ($r->success and $response->success) {
				switch ($response->status) {
					case 'ACTIVE':
						update_option('flarum_sso_plugin_pro_active', true);
						break;
					default:
						update_option('flarum_sso_plugin_pro_active', false);
						break;
				}
			}
		}
		add_action( 'flarum_sso_plugin_cron_hook', 'flarum_sso_check_pro' );
		if ( ! wp_next_scheduled( 'flarum_sso_plugin_cron_hook' ) ) {
			wp_schedule_event( time(), 'every_month', 'flarum_sso_plugin_cron_hook' );
		}

		if (!function_exists('is_plugin_active')) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		// Memberpress integration
		if ( is_plugin_active( 'memberpress/memberpress.php' ) ) {
			/**
			 * Login to flarum (PRO)
			 *
			 * @param $user_login
			 * @param $user
			 */
			function flarum_sso_login_pro( $user, $username, $password ) {
				if (!$user instanceof WP_User) {
					return $user;
				}
				global $wpdb;
				// Membership integration
				$r     = $wpdb->get_var( 'SELECT memberships FROM ' . $wpdb->prefix . 'mepr_members WHERE user_id=' . $user->ID . ';' );
				$rs    = explode( ',', $r );
				$roles = array_map( function ( $ri ) {
					$p = get_post( $ri );
					return $p->post_title;
				}, $rs );

				return flarum_sso_login( $user, $username, $password, $roles );
			}
			remove_filter( 'authenticate', 'flarum_sso_login' );
			add_filter( 'authenticate', 'flarum_sso_login_pro', 31, 3 );
		}

	}
}
