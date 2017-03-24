<?php

/**
 * Forces AffiliateWP's front-end scripts to load on our /affiliates page
 * We're not using the [affiliate_area] shortcode since we don't want a form to show when logged out
 */
function rcp_theme_force_affwp_scripts( $ret ) {

	if ( is_page( 'affiliates' ) ) {
		$ret = true;
	}

	return $ret;
}
add_filter( 'affwp_force_frontend_scripts', 'rcp_theme_force_affwp_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 */
function rcp_theme_affiliates_body_classes( $classes ) {
	global $post;

	if ( is_page( 'affiliates' ) ) {
		$classes[] = 'affiliate-area';
	}

	return $classes;
}
add_filter( 'body_class', 'rcp_theme_affiliates_body_classes' );

/**
 * Redirections
 *
 * @since 1.0.0
 * @return void
 */
function rcp_theme_affiliate_redirect() {

	/**
	 * Redirect to the /affiliates page if a logged-in user tries to access the login page
	 */
	if ( is_user_logged_in() && is_page( 'affiliates/login' ) ) {
		wp_redirect( site_url( 'affiliates' ) );
		exit;
	}

	/**
	 * Redirect active affiliates to the /affiliates page if they try and access the join page
	 */
	if ( is_user_logged_in() && function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate() && affwp_is_active_affiliate() ) {
		if ( is_page( 'affiliates/join' ) ) {
			wp_redirect( site_url( 'affiliates' ) );
			exit;
		}
	}

}
add_action( 'template_redirect', 'rcp_theme_affiliate_redirect' );

/**
 * Back to account link
 *
 * @since
 * @return void
 */
function rcp_theme_dashboard_tabs( $affiliate_id, $active_tab ) {
	?>

	<li class="affwp-affiliate-dashboard-tab">
		<a href="<?php echo esc_url( site_url( 'account' ) ); ?>"><?php _e( '&larr; Back to Account', 'affiliate-wp' ); ?></a>
	</li>

	<?php
}
add_action( 'affwp_affiliate_dashboard_tabs', 'rcp_theme_dashboard_tabs', 10, 2 );
