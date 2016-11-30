<?php
/**
 * Changelog
 *
 * Loads Restrict Content Pro's changelog via ajax, caches it, and displays it in a modal window
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

	// Check for transient, if none, grab post meta
	if ( false === ( $changelog = get_transient( 'pp_rcp_changelog' ) ) ) {

		$changelog = get_post_meta( rcp_get_download_id(), '_edd_sl_changelog', true );

		// Store remote HTML file in transient, expire after 24 hours
		set_transient( 'pp_rcp_changelog', $changelog, 24 * HOUR_IN_SECONDS );

	}

	if ( $changelog ) {
		return stripslashes_deep( $changelog );
	}

	return false;

}

/**
 * Clears the changelog transient when the RCP download is saved.
 */
function rcp_delete_changelog_transient( $post_id ) {

	if ( rcp_get_download_id() == $post_id ) {
		delete_transient( 'pp_rcp_changelog' );
	}

}
add_action( 'save_post_download', 'rcp_delete_changelog_transient' );
