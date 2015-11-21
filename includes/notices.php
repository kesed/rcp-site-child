<?php

/**
 * Dequeue simple notices pro
 */
function affwp_dequeue_style() {
	wp_dequeue_style( 'notifications' );
}
add_action( 'wp_enqueue_scripts', 'affwp_dequeue_style' );

/**
 * Show notices
 */
function rcp_display_notice() {

	/// this displays the notification area if the user has not read it before
	global $user_ID;

	$notice_args = array(
		'post_type'      => 'notices',
		'posts_per_page' => 1,
		'meta_key'       => '_enabled',
		'meta_value'     => '1'
	);

	$expired = get_page_by_title( 'License expired', 'OBJECT', 'notices' );

	// exclude notice if license has not expired
	if ( $expired && ! affwp_has_users_license_expired() ) {
		$notice_args['exclude'] = array( $expired->ID );
	}

	$notices = get_posts( $notice_args );

	if ( $notices ) {

		foreach ( $notices as $key => $notice ) {

			$logged_in_only = get_post_meta($notice->ID, '_notice_for_logged_in_only', true);

			$can_view = false;

			if ( $logged_in_only == 'All' ) {
				$can_view = true;
			} else if ( $logged_in_only == 'Logged In' && is_user_logged_in() ) {
				$can_view = true;
			} else if ( $logged_in_only == 'Logged Out' && ! is_user_logged_in() ) {
				$can_view = true;
			}

			if ( $can_view ) {

				if ( pippin_check_notice_is_read( $notice->ID, $user_ID ) != true ) { ?>

					<div id="notification-area" class="snp-hidden">

							<div class="notice-content">

                                <img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/announcement.svg'; ?>" />


								<?php echo do_shortcode( wpautop( $notice->post_content ) ); ?>

							</div>

							<?php if( ! get_post_meta($notice->ID, '_hide_close', true)) { ?>

							<a class="remove-notice" href="#" id="remove-notice" rel="<?php echo $notice->ID; ?>">
							<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/remove.svg'; ?>" />

							<?php } ?>
					</div>
				<?php }

			} // can view
		}
	}
}

remove_action( 'wp_footer', 'pippin_display_notice' );
add_action( 'trustedd_site_before', 'rcp_display_notice' );
