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
 * @package    sso-flarum
 * @subpackage sso-flarum/admin
 * @author     maicol07 <maicolbattistini@live.it>
 */
class SSO_Flarum_Admin {

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
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ), 9 );
		add_action( 'admin_init', array( $this, 'register_build_fields' ) );

		add_filter(
			"plugin_action_links_{$this->plugin_name}/{$this->plugin_name}.php",
			array( $this, 'flarum_sso_add_links_to_admin_plugins_page' )
		);
		add_filter( 'plugin_row_meta', array( $this, 'flarum_sso_plugin_add_meta_to_admin_plugins_page' ), 10, 2 );
	}

	/**
	 * Add plugin settings link to the plugin entry in plugins page
	 */
	public function add_plugin_admin_menu(): void {
		add_submenu_page(
			'options-general.php',
			__( 'Flarum SSO Plugin Settings', 'sso-flarum' ),
			__( 'Flarum SSO Plugin', 'sso-flarum' ),
			'administrator',
			$this->plugin_name . '-settings',
			array( $this, 'display_plugin_admin_settings' )
		);
	}

	/**
	 * Shows plugin admin settings
	 */
	public function display_plugin_admin_settings(): void {
		// set this var to be used in the settings-display view
		// $active_tab = $_GET['tab'] ?? 'general';.
		if ( isset( $_GET['error_message'] ) ) {
			add_action( 'admin_notices', array( $this, 'flarumSSOPluginSettingsMessages' ) );
			do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}

	/**
	 * Adds settings fields
	 */
	public function register_build_fields(): void {
		add_settings_section(
			'flarum_sso_plugin_general_section',
			'',
			array( $this, 'flarum_sso_plugin_display_general_account' ),
			'flarum_sso_plugin_general_settings'
		);
		unset( $args );
		$fields = array(
			array(
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_active',
				'name'             => 'flarum_sso_plugin_active',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Enable SSO', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'url',
				'id'               => 'flarum_sso_plugin_flarum_url',
				'name'             => 'flarum_sso_plugin_flarum_url',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Flarum URL', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'url',
				'id'               => 'flarum_sso_plugin_root_domain',
				'name'             => 'flarum_sso_plugin_root_domain',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Root Domain', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_api_key',
				'name'             => 'flarum_sso_plugin_api_key',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'API Key', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_password_token',
				'name'             => 'flarum_sso_plugin_password_token',
				'required'         => 'true',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Password Token', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_verify_ssl',
				'name'             => 'flarum_sso_plugin_verify_ssl',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Verify SSL', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_verify_ssl_cert_path',
				'name'             => 'flarum_sso_plugin_verify_ssl_cert_path',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'SSL certificate absolute path', 'sso-flarum' ),
			),
			array(
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_update_user_avatar',
				'name'             => 'flarum_sso_plugin_update_user_avatar',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'Update user avatar', 'sso-flarum' ),
			),
		);

		// Default values.
		$values = array(
			'root_domain' => get_site_url(),
			'verify_ssl'  => true,
		);
		foreach ( $values as $option => $value ) {
			if ( get_option( 'flarum_sso_plugin_' . $option ) === false ) {
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
	 * @param array $args Settings field options.
	 */
	public function flarum_sso_plugin_render_settings_field( array $args ): void {
		$value = null;
		if ( 'option' === $args['wp_data'] ) {
			$value = get_option( $args['name'] );
		} elseif ( 'post_meta' === $args['wp_data'] ) {
			$value = get_post_meta( $args['post_id'], $args['name'], true );
		}

		switch ( $args['type'] ) {
			case 'input':
				if ( 'checkbox' !== $args['subtype'] ) {
					$prepend_start = ( isset( $args['prepend_value'] ) ) ? '<div class="input-prepend"> <span class="add-on">' . esc_html( $args['prepend_value'] ) . '</span>' : '';
					$prepend_end   = ( isset( $args['prepend_value'] ) ) ? '</div>' : '';
					$step          = ( isset( $args['step'] ) ) ? 'step="' . esc_html( $args['step'] ) . '"' : '';
					$min           = ( isset( $args['min'] ) ) ? 'min="' . esc_html( $args['min'] ) . '"' : '';
					$max           = ( isset( $args['max'] ) ) ? 'max="' . esc_html( $args['max'] ) . '"' : '';
					if ( isset( $args['disabled'] ) ) {
						echo $prepend_start . '<input type="' . esc_attr( $args['subtype'] ) . '" id="' . esc_attr( $args['id'] ) . '_disabled" ' . esc_attr( $step ) . ' ' . esc_attr( $max ) . ' ' . esc_attr( $min ) . ' name="' . esc_attr( $args['name'] ) . '_disabled" size="40" disabled value="' . esc_attr( $value ) . '" /><input type="hidden" id="' . esc_attr( $args['id'] ) . '" ' . esc_attr( $step ) . ' ' . esc_attr( $max ) . ' ' . esc_attr( $min ) . ' name="' . esc_attr( $args['name'] ) . '" size="40" value="' . esc_attr( $value ) . '" />' . $prepend_end;
					} else {
						echo $prepend_start . '<input type="' . esc_attr( $args['subtype'] ) . '" id="' . esc_attr( $args['id'] ) . '" "' . esc_attr( $args['required'] ) . '" ' . esc_attr( $step ) . ' ' . esc_attr( $max ) . ' ' . esc_attr( $min ) . ' name="' . esc_attr( $args['name'] ) . '" size="40" value="' . esc_attr( $value ) . '" />' . $prepend_end;
					}
				} else {
					$checked = ( $value ) ? 'checked' : '';
					echo '<input type="' . esc_attr( $args['subtype'] ) . '" id="' . esc_attr( $args['id'] ) . '" "' . esc_attr( $args['required'] ) . '" name="' . esc_attr( $args['name'] ) . '" size="40" value="1" ' . esc_attr( $checked ) . ' />';
				}
				break;
			default:
				break;
		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param string $hook Page requesting stylesheets.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( string $hook ): void {
		if ( 'settings_page_sso-flarum-settings' !== $hook ) {
			return;
		}
		wp_enqueue_style( $this->plugin_name, plugins_url( 'css/sso-flarum-admin.css', __FILE__ ), array(), '0.2' );
		wp_enqueue_style( $this->plugin_name . '_bulma', plugins_url( 'css/bulma.min.css', __FILE__ ), array(), '0.9.1' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param string $hook Page requesting javascript.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( string $hook ): void {
		if ( 'settings_page_sso-flarum-settings' !== $hook ) {
			return;
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sso-flarum-admin.js', array( 'jquery' ), '0.1', true );
	}

	/**
	 * Adds settings and donate links to plugins page
	 *
	 * @param array $links Links already added by WP.
	 *
	 * @return mixed
	 */
	public function flarum_sso_add_links_to_admin_plugins_page( array $links ): array {
		$settings_url  = esc_url( get_admin_url() . 'options-general.php?page=sso-flarum-settings' );
		$settings_link = '<a href="' . $settings_url . '">' . esc_html__( 'Settings', 'sso-flarum' ) . '</a>';

		$donate_url  = esc_url( 'https://www.paypal.me/maicol072001/10eur' );
		$donate_link = '<a href="' . $donate_url . '">' . esc_html__( 'Donate', 'sso-flarum' ) . '</a>';

		$docs_url  = esc_url( 'https://docs.maicol07.it/en/flarum-sso/plugins/wordpress' );
		$docs_link = '<a href="' . $docs_url . '">' . esc_html__( 'Docs', 'sso-flarum' ) . '</a>';

		// Prepend new link to links array.
		array_unshift( $links, $settings_link, $donate_link, $docs_link );

		return $links;
	}

	/**
	 * Adds settings and donate links to plugin meta data in plugins page
	 *
	 * @param array $links Links already added by WP.
	 * @param string $file Current file.
	 *
	 * @return array
	 */
	public function flarum_sso_plugin_add_meta_to_admin_plugins_page( array $links, string $file ): array {
		if ( strpos( $file, $this->plugin_name ) !== false ) {
			$settings_url = esc_url( get_admin_url() . 'options-general.php?page=sso-flarum-settings' );
			$review_url   = esc_url( 'https://wordpress.org/support/plugin/sso-flarum/reviews/#new-post' );
			$donate_url   = esc_url( 'https://www.paypal.me/maicol072001/10eur' );
			$docs_url     = esc_url( 'https://docs.maicol07.it/en/flarum-sso/plugins/wordpress' );

			$new_links = array(
				'<a href="' . $settings_url . '"><span class="dashicons dashicons-admin-generic"></span> ' . __( 'Settings', 'sso-flarum' ) . '</a>',
				'<a href="' . $review_url . '"><span class="dashicons dashicons-star-filled"></span> ' . __( 'Leave a review', 'sso-flarum' ) . '</a>',
				'<a href="' . $donate_url . '"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', 'sso-flarum' ) . '</a>',
				'<a href="' . $docs_url . '"><span class="dashicons dashicons-heart"></span> ' . __( 'Donate', 'sso-flarum' ) . '</a>',
			);

			// Add new links to existing links.
			$links = array_merge( $links, $new_links );
		}

		return $links;
	}
}
