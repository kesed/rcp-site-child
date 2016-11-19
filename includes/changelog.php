<?php
/**
 * Changelog
 *
 * Loads AffiliateWP's changelog via ajax, caches it, and displays it in a modal window
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Append changelog to the changelog page
 *
 * @since 1.0.0
 */
function rcp_theme_append_changelog() {

	if ( ! is_page( 'changelog' ) ) {
		return;
	}

	echo rcp_get_changelog();
}
add_action( 'themedd_entry_content_end', 'rcp_theme_append_changelog' );

/**
 * Get changelog
 */
function rcp_get_changelog() {

    // Check for transient, if none, grab remote HTML file
	if ( false === ( $html = get_transient( 'pp_rcp_changelog' ) ) ) {

        // Get remote HTML file
		$response = wp_remote_get( 'https://restrictcontentpro.com/downloads/restrict-content-pro/changelog/' );

        // Check for error
		if ( is_wp_error( $response ) ) {
			return;
		}

        // Parse remote HTML file
		$data = wp_remote_retrieve_body( $response );

        // Check for error
		if ( is_wp_error( $data ) ) {
			return;
		}

        // Store remote HTML file in transient, expire after 24 hours
		set_transient( 'pp_rcp_changelog', $data, 24 * HOUR_IN_SECONDS );

	}

	if ( $html ) {
		return stripslashes_deep( $html );
	} else {
		return stripslashes_deep( $data );
	}

}

/**
 * Clears the changelog transient when the RCP download is saved.
 */
function rcp_delete_changelog_transient( $post_id ) {

	if ( rcp_get_download_id() == $post_id ) {
		delete_site_transient( 'pp_rcp_changelog' );
	}

}
add_action( 'save_post_download', 'rcp_delete_changelog_transient' );
