<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Loads the new Featured Icon metabox
 * Requires the Multi Post Thumbnails plugin
 */
function rcp_admin_load_mpt() {

    if ( class_exists( 'MultiPostThumbnails' ) ) {
        new MultiPostThumbnails(
            array(
                'label'     => 'Featured Icon',
                'id'        => 'feature-icon',
                'post_type' => 'page'
            )
        );
    }

}
add_action( 'wp_loaded', 'rcp_admin_load_mpt' );
