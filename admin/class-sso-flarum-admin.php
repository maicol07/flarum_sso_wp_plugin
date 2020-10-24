<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://maicol07.it
 * @since      1.0.0
 *
 * @package    sso-flarum
 * @subpackage sso-flarum/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    sso-flarum
 * @subpackage sso-flarum/admin
 * @author     maicol07 <maicolbattistini@live.it>
 */
class Flarum_SSO_Admin {

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
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 * @noinspection UnusedConstructorDependenciesInspection
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'admin_menu', [ $this, 'addPluginAdminMenu' ], 9 );
		add_action( 'admin_init', [ $this, 'registerAndBuildFields' ] );

		// Plugin page
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [
			$this,
			'flarum_sso_add_links_to_admin_plugins_page'
		] );
		add_filter( 'plugin_row_meta', [ $this, 'flarum_sso_plugin_add_meta_to_admin_plugins_page' ], 10, 2 );
	}

	public function addPluginAdminMenu(): void {
		add_submenu_page(
			'options-general.php',
			__( 'Flarum SSO Plugin Settings', 'sso-flarum' ),
			__( 'Flarum SSO plugin', 'sso-flarum' ), 'administrator',
			$this->plugin_name . '-settings',
			[
				$this,
				'displayPluginAdminSettings'
			]
		);
	}

	/**
	 * Shows plugin admin settings
	 */
	public function displayPluginAdminSettings(): void {
		// set this var to be used in the settings-display view
		// $active_tab = $_GET['tab'] ?? 'general';
		if ( isset( $_GET['error_message'] ) ) {
			add_action( 'admin_notices', [ $this, 'flarumSSOPluginSettingsMessages' ] );
			do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}

	/**
	 * Adds settings fields
	 */
	public function registerAndBuildFields(): void {
		add_settings_section(
			'flarum_sso_plugin_general_section',
			'',
			[ $this, 'flarum_sso_plugin_display_general_account' ],
			'flarum_sso_plugin_general_settings'
		);
		unset( $args );
		$fields = [
			[
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_active',
				'name'             => 'flarum_sso_plugin_active',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Enable SSO', 'sso-flarum' )
			],
			[
				'type'             => 'input',
				'subtype'          => 'url',
				'id'               => 'flarum_sso_plugin_flarum_url',
				'name'             => 'flarum_sso_plugin_flarum_url',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Flarum URL', 'sso-flarum' )
			],
			[
				'type'             => 'input',
				'subtype'          => 'url',
				'id'               => 'flarum_sso_plugin_root_domain',
				'name'             => 'flarum_sso_plugin_root_domain',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Root Domain', 'sso-flarum' )
			],
			[
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_api_key',
				'name'             => 'flarum_sso_plugin_api_key',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'API Key', 'sso-flarum' )
			],
			[
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_password_token',
				'name'             => 'flarum_sso_plugin_password_token',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Password Token', 'sso-flarum' )
			],
			[
				'type'             => 'input',
				'subtype'          => 'number',
				'id'               => 'flarum_sso_plugin_lifetime',
				'name'             => 'flarum_sso_plugin_lifetime',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Token Lifetime', 'sso-flarum' ),
			],
			[
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_verify_ssl',
				'name'             => 'flarum_sso_plugin_verify_ssl',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( "Verify SSL (uncheck only if you don't have a valid SSL certificate, like a self-signed one)", 'sso-flarum' ),
			],
			[
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_verify_ssl_cert_path',
				'name'             => 'flarum_sso_plugin_verify_ssl_cert_path',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( "SSL certificate absolute path (optional if you have disabled the verify ssl option)", 'sso-flarum' ),
			]
		];

		// Default values
		$values = [
			'lifetime'    => 14,
			'root_domain' => get_site_url(),
			'verify_ssl'  => true
		];
		foreach ( $values as $option => $value ) {
			if ( get_option( 'flarum_sso_plugin_' . $option ) === false ) // Nothing yet saved
			{
				update_option( 'flarum_sso_plugin_' . $option, $value );
			}
		}

		foreach ( $fields as $field ) {
			add_settings_field(
				$field['id'],
				$field['label'],
				array( $this, 'flarum_sso_plugin_render_settings_field' ),
				'flarum_sso_plugin_general_settings',
				'flarum_sso_plugin_general_section',
				$field
			);

			register_setting(
				'flarum_sso_plugin_general_settings',
				$field['id']
			);
		}
		do_action( 'flarum_sso_plugin_addons_register_settings' );
	}

	/**
	 * Render settings fields
	 *
	 * @param $args
	 */
	public function flarum_sso_plugin_render_settings_field( $args ): void {
		if ( $args['wp_data'] === 'option' ) {
			$wp_data_value = get_option( $args['name'] );
		} elseif ( $args['wp_data'] === 'post_meta' ) {
			$wp_data_value = get_post_meta( $args['post_id'], $args['name'], true );
		}

		switch ( $args['type'] ) {
			case 'input':
				/** @noinspection PhpUndefinedVariableInspection */
				$value = ( $args['value_type'] === 'serialized' ) ? serialize( $wp_data_value ) : $wp_data_value;
				if ( $args['subtype'] !== 'checkbox' ) {
					$prependStart = ( isset( $args['prepend_value'] ) ) ? '<div class="input-prepend"> <span class="add-on">' . $args['prepend_value'] . '</span>' : '';
					$prependEnd   = ( isset( $args['prepend_value'] ) ) ? '</div>' : '';
					$step         = ( isset( $args['step'] ) ) ? 'step="' . $args['step'] . '"' : '';
					$min          = ( isset( $args['min'] ) ) ? 'min="' . $args['min'] . '"' : '';
					$max          = ( isset( $args['max'] ) ) ? 'max="' . $args['max'] . '"' : '';
					if ( isset( $args['disabled'] ) ) {
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '_disabled" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '_disabled" size="40" disabled value="' . esc_attr( $value ) . '" /><input type="hidden" id="' . $args['id'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr( $value ) . '" />' . $prependEnd;
					} else {
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr( $value ) . '" />' . $prependEnd;
					}

				} else {
					$checked = ( $value ) ? 'checked' : '';
					echo '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" name="' . $args['name'] . '" size="40" value="1" ' . $checked . ' />';
				}
				break;
			default:
				# code...
				break;
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param string $hook Page requesting stylesheets
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( string $hook ): void {
		if ( $hook !== 'settings_page_sso-flarum-settings' ) {
			return;
		}
		wp_enqueue_style( $this->plugin_name, plugins_url( 'css/sso-flarum-admin.css', __FILE__ ), [], '0.2' );
		wp_enqueue_style( $this->plugin_name . '_bulma', 'https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css', [], '0.9.1' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param string $hook Page requesting javascript
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( string $hook ): void {
		if ( $hook !== 'settings_page_sso-flarum-settings' ) {
			return;
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sso-flarum-admin.js', [ 'jquery' ], '0.1', true );
	}

	/**
	 * Adds settings and donate links to plugins page
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function flarum_sso_add_links_to_admin_plugins_page( $links ) {
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

	/**
	 * Adds settings and donate links to plugin meta data in plugins page
	 *
	 * @param $links
	 * @param $file
	 *
	 * @return array
	 */
	public function flarum_sso_plugin_add_meta_to_admin_plugins_page( $links, $file ): array {
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
}
