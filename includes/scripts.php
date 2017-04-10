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

/*
 * Ouput Perfect Audience conversion tracking script
 */
function rcp-_perfect_audience_tracking() {
?>
<script type="text/javascript">
  (function() {
    window._pa = window._pa || {};
    <?php if( $session = edd_get_purchase_session() ) : $payment_id = edd_get_purchase_id_by_key( $session['purchase_key'] ); ?>
    _pa.orderId = "<?php echo $payment_id; ?>";
    _pa.revenue = "<?php echo edd_get_payment_amount( $payment_id ); ?>";
    <?php endif; ?>
    var pa = document.createElement('script'); pa.type = 'text/javascript'; pa.async = true;
    pa.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + "//tag.marinsm.com/serve/58eb9cd0abc468e5fd0000ac.js";
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pa, s);
  })();
</script>
<?php
}
add_action( 'wp_footer', 'rcp-_perfect_audience_tracking' );
