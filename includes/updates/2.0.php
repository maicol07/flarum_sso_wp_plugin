<?php
/**
 * 2.0 Update
 *
 * @package sso-flarum
 */

$insecure = get_option( 'flarum_sso_plugin_insecure' );
add_option( 'flarum_sso_plugin_verify_ssl', ! $insecure );
delete_option( 'flarum_sso_plugin_insecure' );
