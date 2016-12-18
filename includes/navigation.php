<?php

// add primary navigation where secondary navigation is located
add_action( 'themedd_site_header_main', 'themedd_primary_menu' );

/**
 * Prepend home link to the primary navigation
 *
 * @since 1.0.0
*/
function rcp_wp_nav_menu_items( $items, $args ) {

    if ( 'primary' == $args->theme_location ) {
    	$home = ! is_front_page() ? rcp_nav_home() : '';
        return $home . $items;
    }

    return $items;

}
//add_filter( 'wp_nav_menu_items', 'rcp_wp_nav_menu_items', 10, 2 );

/**
 * Add the account menu just before the cart icon
 */
function rcp_account_menu( $items ) {
    return $items . rcp_nav_account();
}
add_filter( 'themedd_wp_nav_menu_items', 'rcp_account_menu' );





/**
 * Append account to main navigation
 * @return [type] [description]
 */
function rcp_nav_account() {

	$account_link_text 	= 'Account';
	$account_page 		= '/account';
	$affiliates_page 	= '/affiliates';
	$active 			= is_page( 'account' ) || is_page( 'affiliates' ) ? ' current-menu-item' : '';

	ob_start();
	?>
		<li class="menu-item menu-item-has-children has-sub-menu account<?php echo $active; ?>">
			<a title="<?php echo $account_link_text; ?>" href="<?php echo site_url( $account_page ); ?>"><?php echo $account_link_text; ?></a>
			<ul class="sub-menu">
				<?php if ( is_user_logged_in() ) : ?>
					<li>
						<a title="<?php echo $account_link_text; ?>" href="<?php echo site_url( $account_page ); ?>"><?php echo $account_link_text; ?></a>
					</li>
				<?php endif; ?>
                <?php if ( function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate() ) : ?>
				<li>
					<a title="<?php _e( 'Affiliates', 'rcp' ); ?>" href="<?php echo site_url( $account_page . $affiliates_page ); ?>"><?php _e( 'Affiliates', 'rcp' ); ?></a>
				</li>
                <?php endif; ?>
				<?php if( ! is_user_logged_in() ) : ?>
					<li>
						<a title="<?php _e( 'Log in', 'rcp' ); ?>" href="<?php echo site_url( $account_page ); ?>"><?php _e( 'Log in', 'rcp' ); ?></a>
					</li>
				<?php else: ?>

					<li>
						<a title="<?php _e( 'Log out', 'rcp' ); ?>" href="<?php echo wp_logout_url( add_query_arg( 'logout', 'success', site_url( $account_page ) ) ); ?>"><?php _e( 'Log out', 'rcp' ); ?></a>
					</li>
				<?php endif; ?>


			</ul>
		</li>

	<?php $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

/**
 * Prepend home link to main navigation
 *
 * @since 1.0.0
 */
function rcp_nav_home() {
	 ob_start();
	?>

	<li class="menu-item home">
		<a href="<?php echo site_url(); ?>">Home</a>
	</li>

	<?php $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

/**
 * Highlight add-ons menu item if on single download page
 */
function rcp_highlight_menu_item( $classes ) {

	if ( is_singular( 'download' ) ) {
	    if ( in_array ( 'add-ons', $classes ) ) {
	      $classes[] = 'current-menu-item';
	    }
	}

	if ( is_singular( 'post' ) ) {
	    if ( in_array ( 'blog', $classes ) ) {
	      $classes[] = 'current-menu-item';
	    }
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'rcp_highlight_menu_item' );
