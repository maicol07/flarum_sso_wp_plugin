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

use Eastwest\Json\Json;

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
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'admin_menu', array( $this, 'addPluginAdminMenu' ), 9 );
		add_action( 'admin_init', array( $this, 'registerAndBuildFields' ) );
	}

	/**
	 * Adds settings menu entry
	 */
	public function addPluginAdminMenu(): void {
		add_submenu_page( 'options-general.php', __( 'Flarum SSO Plugin Settings', 'sso-flarum' ),
			__( 'Flarum SSO plugin', 'sso-flarum' ), 'administrator', $this->plugin_name . '-settings', array(
				$this,
				'displayPluginAdminSettings'
			) );
	}

	/**
	 * Shows plugin admin settings
	 */
	public function displayPluginAdminSettings(): void {
		// set this var to be used in the settings-display view
		// $active_tab = $_GET['tab'] ?? 'general';
		if ( isset( $_GET['error_message'] ) ) {
			add_action( 'admin_notices', array( $this, 'flarumSSOPluginSettingsMessages' ) );
			do_action( 'admin_notices', $_GET['error_message'] );
		}
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}

	/**
	 * Display settings message
	 *
	 * @param $error_message
	 */
	/*public function FlarumSSOPluginSettingsMessages( $error_message ) {
		switch ( $error_message ) {
			case '1':
				$message       = __( 'There was an error adding this setting. Please try again.  If this persists, shoot us an email.', 'sso-flarum' );
				$err_code      = esc_attr( 'flarum_sso_plugin_example_setting' );
				$setting_field = 'flarum_sso_plugin_example_setting';
				break;
		}
		$type = 'error';
		add_settings_error(
			$setting_field,
			$err_code,
			$message,
			$type
		);
	}*/

	/**
	 * Adds settings fields
	 */
	public function registerAndBuildFields(): void {
		/**
		 * First, we add_settings_section. This is necessary since all future settings must belong to one.
		 * Second, add_settings_field
		 * Third, register_setting
		 */
		add_settings_section(
		// ID used to identify this section and with which to register options
			'flarum_sso_plugin_general_section',
			// Title to be displayed on the administration page
			'',
			// Callback used to render the description of the section
			array( $this, 'flarum_sso_plugin_display_general_account' ),
			// Page on which to add this section of options
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
				'subtype'          => 'text',
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
				'subtype'          => 'text',
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
				'subtype'          => 'text',
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
				'subtype'          => 'text',
				'id'               => 'flarum_sso_plugin_pro_key',
				'name'             => 'flarum_sso_plugin_pro_key',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( 'PRO features key', 'sso-flarum' ),
			],
			[
				'type'             => 'input',
				'subtype'          => 'checkbox',
				'id'               => 'flarum_sso_plugin_insecure',
				'name'             => 'flarum_sso_plugin_insecure',
				'required'         => 'false',
				'get_options_list' => '',
				'value_type'       => 'normal',
				'wp_data'          => 'option',
				'label'            => __( "Insecure mode (use only if you don't have a valid SSL certificate)", 'sso-flarum' ),
			]
		];

		// PRO Options
		if ( (bool) get_option( 'flarum_sso_plugin_pro_active' ) ) {
			$fields = array_merge( $fields, [
				[
					'type'             => 'input',
					'subtype'          => 'checkbox',
					'id'               => 'flarum_sso_plugin_set_groups_admins',
					'name'             => 'flarum_sso_plugin_set_groups_admins',
					'required'         => 'false',
					'get_options_list' => '',
					'value_type'       => 'normal',
					'wp_data'          => 'option',
					'label'            => __( "Set groups also for admins", 'sso-flarum' ),
				]
			] );
		}

		// Default values
		$values = [
			'lifetime'          => 14,
			'root_domain'       => get_site_url(),
			'set_groups_admins' => '1'
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
	}

	/**
	 * Display message on plugin settings page
	 */
	public function flarum_sso_plugin_display_general_account(): void {
		echo '<p>' . __( "These settings apply to all Flarum SSO Plugin functionality. To know more about something check the <a href='https://docs.maicol07.it/docs/en/flarum_sso_plugin/wp/introduction'>docs</a>", "sso-flarum" ) . '</p>';
		if ( ! empty( get_option( 'flarum_sso_plugin_pro_key' ) ) ) {
			$r = Requests::post( 'https://' . get_option( 'flarum_sso_plugin_verification_server', 'maicol07.it' ) . '/flarum_sso/wp_check.php',
				[], [
					'sub_id'        => get_option( 'flarum_sso_plugin_pro_key' ),
					'url'           => get_site_url(),
					'get_plan_name' => true
				], get_option( 'flarum_sso_plugin_insecure' ) ? [ 'verify' => false ] : [] );
			if ( $r->success ) {
				$response = Json::decode( $r->body );
				if ( $response->success ) {
					switch ( $response->status ) {
						case 'ACTIVE':
							// translators: %1s: PRO plan name; %2s: Expiry date; %3d: Number of used sites in license; %4d: Number of total sites allowed by license
							echo '<p style="color: green">' . sprintf( __( "You are subscribed to the %1s until %2s and you are using %3d of %4d sites allowed by your license." ),
									$response->plan_name,
									date_i18n( get_option( 'date_format' ), $response->expiry_date ),
									$response->used,
									$response->total
								) . "</p>";
							update_option( 'flarum_sso_plugin_pro_active', true );
							break;
						case 'EXPIRED':
							// translators: %1s: PRO plan name; %2s: Expiry date
							echo '<p style="color: red">' . sprintf( __( "Your %1s license is expired from %2s!" ), $response->plan_name,
									date_i18n( get_option( 'date_format' ), $response->expiry_date ) ) . "</p>";
							update_option( 'flarum_sso_plugin_pro_active', false );
							break;
						case 'FULL':
							// translators: %1s: PRO plan name; %2s: Expiry date; %3d: Number of used sites in license; %4d: Number of total sites allowed by license
							echo '<p style="color: darkorange">' . sprintf( __( "You are subscribed to the %1s until %2s and you are using %3d of %4d sites allowed by your license." ),
									$response->plan_name,
									date_i18n( get_option( 'date_format' ), $response->expiry_date ),
									$response->used,
									$response->total
								) . "</p>";
							update_option( 'flarum_sso_plugin_pro_active', true );
							break;
						case 'CANCELLED':
							// translators: %s: PRO plan name
							echo '<p style="color: red">' . sprintf( __( "Your %s license has been cancelled!" ), $response->plan_name ) . "</p>";
							update_option( 'flarum_sso_plugin_pro_active', false );
							break;
						default:
							// translators: %1s: PRO plan name; %2s: Subscription status
							echo '<p>' . sprintf( __( "Your %1s license is %2s!" ), $response->plan_name, $response->status ) . "</p>";
							update_option( 'flarum_sso_plugin_pro_active', false );
							break;
					}
				} else {
					echo '<p style="color: red">' . __( "There was an error during license verification!" ) . "<br>{$response->error}</p>";
				}
			}
		} else {
			update_option( 'flarum_sso_plugin_pro_active', false );
		}
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
						// hide the actual input bc if it was just a disabled input the informaiton saved in the database would be wrong - bc it would pass empty values and wipe the actual information
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '_disabled" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '_disabled" size="40" disabled value="' . esc_attr( $value ) . '" /><input type="hidden" id="' . $args['id'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr( $value ) . '" />' . $prependEnd;
					} else {
						echo $prependStart . '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" "' . $args['required'] . '" ' . $step . ' ' . $max . ' ' . $min . ' name="' . $args['name'] . '" size="40" value="' . esc_attr( $value ) . '" />' . $prependEnd;
					}
					/*<input required="required" '.$disabled.' type="number" step="any" id="'.$this->plugin_name.'_cost2" name="'.$this->plugin_name.'_cost2" value="' . esc_attr( $cost ) . '" size="25" /><input type="hidden" id="'.$this->plugin_name.'_cost" step="any" name="'.$this->plugin_name.'_cost" value="' . esc_attr( $cost ) . '" />*/

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
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flarum_sso_plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flarum_sso_plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sso-flarum-admin.css', array(), $this->version );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Flarum_sso_plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Flarum_sso_plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sso-flarum-admin.js', array( 'jquery' ), $this->version );
	}

}
