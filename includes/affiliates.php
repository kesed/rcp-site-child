<?php

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
