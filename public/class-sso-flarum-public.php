<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://maicol07.it
 * @since      1.0.0
 *
 * @package    sso-flarum
 * @subpackage sso-flarum/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    sso-flarum
 * @subpackage sso-flarum/public
 * @author     maicol07 <maicolbattistini@live.it>
 */
class SSO_Flarum_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		add_action( 'wp_head', array( $this, 'print_wp_path_js' ) );
	}

	/**
	 * Print WP Path to JS Global variables
	 */
	public function print_wp_path_js(): void {
		echo '<script> WP_PATH = "' . esc_js( get_site_url() ) . '"; </script>';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @param string $hook Page ID.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( string $hook ): void {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sso-flarum-public.css', array(), $this->version );
		do_action( 'flarum_sso_plugin_add_css', $hook );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @param string $hook Page ID.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( string $hook ): void {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sso-flarum-public.js', array( 'jquery' ), $this->version, true );
		do_action( 'flarum_sso_plugin_add_js', $hook );
	}
}
