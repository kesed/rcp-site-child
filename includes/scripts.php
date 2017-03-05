<?php

/**
 * Enqueue account related scripts
 *
 * @since 1.0.0
 */
function rcp_theme_account_scripts() {

	wp_register_script( 'account-js', get_stylesheet_directory_uri() . '/js/account.min.js', array( 'jquery' ), THEMEDD_VERSION );

	if ( themedd_is_edd_sl_active() ) {
		wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
	}

	// load jQuery UI + tabs for account page
	if ( is_page_template( 'page-templates/account.php' ) ) {

		/**
		 * Account page
		 */
		wp_enqueue_script( 'jquery-ui-tabs' );

		// load jQuery UI
		wp_enqueue_script( 'jquery-ui-core' );

		// load account JS
		wp_enqueue_script( 'account-js' );

		// load EDD SL's CSS styles
		wp_enqueue_style( 'edd-sl-styles' );

	}

}
add_action( 'wp_enqueue_scripts', 'rcp_theme_account_scripts' );
