<?php
/**
 * Admin settings
 *
 * @package sso-flarum
 */

do_action( 'flarum_sso_plugin_settings_page' );
?>

<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2><?php esc_html_e( 'Flarum SSO Settings', 'sso-flarum' ); ?></h2>
	<?php settings_errors( '', false, true ); ?>
	<div class="columns" style="margin-top: 8px;">
		<div class="column">
			<div class="box">
				<h2 class="subtitle"
					style="padding-left: 0"><?php esc_html_e( 'General settings', 'sso-flarum' ); ?></h2>
				<p>
					<?php
					echo __(
							'These settings apply to all Flarum SSO Plugin functionality. To know more about something check the <a href="https://docs.maicol07.it/en/flarum-sso/plugins/wordpress">docs</a>.',
							'sso-flarum'
					);
					?>
				</p>
				<form method="POST" action="options.php">
					<?php
					settings_fields( 'flarum_sso_plugin_general_settings' );

					echo '<table class="form-table">';
					do_settings_fields( 'flarum_sso_plugin_general_settings', 'flarum_sso_plugin_general_section' );
					echo '</table>';

					submit_button();
					?>
				</form>
			</div>
		</div>
		<div class="column">
			<div class="box">
				<h2 class="subtitle" style="padding-left: 0"><?php esc_html_e( 'Addons settings' ); ?></h2>
				<p><?php esc_html_e( 'These are settings configurable only for installed addons.' ); ?></p>
				<?php
				$addons = array(
						'memberpress' => __( 'Memberpress', 'sso-flarum' ),
						'jwt'         => __( 'JWT (Json Web Token)', 'sso-flarum' ),
				);
				foreach ( $addons as $addon => $addon_text ) {
					if ( is_plugin_active( "flarum-sso-{$addon}-addon/flarum-sso-{$addon}-addon.php" ) ) {
						$badge_text  = __( 'ACTIVE', 'sso-flarum' );
						$badge_class = 'green';
					} else {
						$badge_text  = __( 'NOT ACTIVE', 'sso-flarum' );
						$badge_class = 'red';
					}
					?>
					<div class="card no-wp">
						<header class="card-header">
							<p class="card-header-title">
								<?php
								echo esc_html( $addon_text );
								do_action( "flarum_sso_plugin_settings_{$addon}_title" );
								?>
							</p>
							<span class="card-header-icon">
								<span class="badge badge-<?php echo esc_attr( $badge_class ); ?>">
									<?php echo esc_html( $badge_text ); ?>
								</span>
							</span>
						</header>
						<div class="card-content">
							<div class="content">
								<form method="POST" action="options.php">
									<?php
									settings_fields( "flarum_sso_plugin_{$addon}_addon_settings" );
									ob_start();

									do_settings_fields( 'flarum_sso_plugin_general_settings', "flarum_sso_plugin_{$addon}_addon_settings" );

									$output = ob_get_clean();
									if ( ! empty( $output ) ) {
										echo '<table class="form-table">' . $output . '</table>';
										submit_button();
									} else {
										esc_html_e( 'No settings can be configured for this plugin at the moment!' );
									}
									?>
								</form>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
