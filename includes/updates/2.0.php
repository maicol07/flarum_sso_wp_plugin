<?php
// Update
$insecure = get_option( 'flarum_sso_plugin_insecure' );
add_option( 'flarum_sso_plugin_verify_ssl', $insecure ? false : true );
delete_option( 'flarum_sso_plugin_insecure' );