<?php

/**
 * Is single feature page
 *
 */
function rcp_is_single_feature() {
	global $post;

	if ( $post ) {
		$parent_post_id = $post->post_parent;

		$features_page = get_page_by_title( 'features' );

		if ( $features_page->ID === $parent_post_id ) {
			return true;
		}
	}

	return false;

}

/**
 * Count how many screenshots there are
 *
 * @since 1.0.0
 */
function rcp_screenshot_count() {

	$count = 0;

	$page = get_page_by_title( 'Screenshots' );

	$args = array(
		'post_mime_type' => 'image',
		'numberposts'    => -1,
		'post_parent'    => $page->ID,
		'post_type'      => 'attachment',
	);

	$gallery = get_children( $args );

	if ( $gallery ) {
		$count = count( $gallery );
	}

	return $count;

}

/**
 * Gets the id of the topmost ancestor of the current page. Returns the current
 * page's id if there is no parent.
 *
 * @uses object $post
 * @return int
 */
function rcp_get_post_top_ancestor_id() {

    global $post;

    if ( $post->post_parent ) {
        $ancestors = array_reverse( get_post_ancestors( $post->ID ) );

		// page has two ancestors, return the second one which is the direct parent
		if ( count( $ancestors ) === 2 ) {
			return $ancestors[1];
		}

		// only one ancestor
		return $ancestors[0];
    }

    return $post->ID;

}


/**
 * Is page a child page of the grid page?
 */
function rcp_is_template_child_page() {

	global $post;

	$is_child_page = false;

	if ( isset( $post ) ) {
		$parent_post_id  = $post->post_parent;

		// parent page cannot be 0
		if ( $parent_post_id ) {

			$template_slug = get_page_template_slug( $parent_post_id );

			if ( $template_slug === 'page-templates/grid-subpages.php' || $template_slug === 'page-templates/list-subpages.php' ) {
				$is_child_page = true;
			}

		}
	}

	return $is_child_page;

}
