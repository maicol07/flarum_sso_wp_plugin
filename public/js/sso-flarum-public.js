(function( $ ) {
	'use strict';

    $(document).ready(() => {
        $('.mepr-account-change-password, .mepr-login-actions').find('a').attr('href', WP_PATH + '/wp-login.php?action=lostpassword')
    })
})( jQuery );
