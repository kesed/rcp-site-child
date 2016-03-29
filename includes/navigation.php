<?php

/**
 * Append extra links to primary navigation
 *
 * @since 1.0.0
*/
function rcp_wp_nav_menu_items( $items, $args ) {

    if ( 'primary' == $args->theme_location ) {
    	$home = ! is_front_page() ? rcp_nav_home() : '';
    	$items .= rcp_nav_account();
    	$items .= rcp_nav_buy_now();
    }

	return $home . $items;

}
add_filter( 'wp_nav_menu_items', 'rcp_wp_nav_menu_items', 10, 2 );



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
 * Append buy now link to main navigation
 * @return [type] [description]
 */
function rcp_nav_buy_now( $args = array() ) {
	 ob_start();

    $list_item = isset( $args['list_item'] ) && $args['list_item'] === false ? false : true;
    $mobile_class = isset( $args['class'] ) ? ' mobile' : '';

    $checkout_url = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '';

	$cart_items = edd_get_cart_contents();
    $cart_link = $cart_items ? $checkout_url : site_url( 'pricing' );

	if ( ! edd_is_checkout() ) : ?>

        <?php if ( $list_item ) : ?>
		<li class="action checkout menu-item">
        <?php endif; ?>

			<a class="nav-cart<?php echo $mobile_class; ?>" href="<?php echo $cart_link; ?>">
                <?php echo rcp_cart_icon(); ?>
            </a>
        <?php if ( $list_item ) : ?>
		</li>
        <?php endif; ?>

	<?php endif;

    $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

function rcp_trustedd_menu_toggle_before() {
    echo rcp_nav_buy_now( array( 'list_item' => false, 'class' => 'mobile' ) );
}
add_action( 'trustedd_menu_toggle_before', 'rcp_trustedd_menu_toggle_before' );


function rcp_cart_icon() {
    $cart_items = edd_get_cart_contents();
    ?>

    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
  <defs>
    <style>
      .cls-1, .cls-3 {
        fill: none;
      }

      .cls-2 {
        fill: #595959;
      }

      .cls-3 {
        stroke: 595959;
        stroke-miterlimit: 10;
        stroke-width: 2px;
      }
    </style>
  </defs>
  <?php if ( $cart_items ) : ?>
      <title>Checkout now</title>
  <?php else : ?>
      <title>Purchase</title>
  <?php endif; ?>
  <g id="frame">
    <rect class="cls-1" width="48" height="48"/>
  </g>
  <g id="cart">
    <circle id="wheel" class="cls-2" cx="14.86" cy="36.95" r="3.05"/>
    <circle id="wheel-2" data-name="wheel" class="cls-2" cx="27.05" cy="36.95" r="3.05"/>
    <?php if ( $cart_items ) : ?>
    <path id="items" class="cls-2" d="M10.11,15.62h3.41l-1.26-2.53,2-1.34,1.94,3.87h6.27V14.09h3v1.53h3v-3A1.52,1.52,0,0,0,27,11H21a1.52,1.52,0,0,0-1.52,1.52v2.69L16.22,8.84A1.52,1.52,0,0,0,14,8.26l-4.57,3a1.52,1.52,0,0,0-.52,1.95Z"/>
    <?php endif; ?>
    <path id="cart-2" data-name="cart" class="cls-2" d="M33.14,9.52a1.53,1.53,0,0,0-1.49,1.18l-1.48,6.44H10.29A1.53,1.53,0,0,0,8.81,19l3,12.19a1.53,1.53,0,0,0,1.48,1.15H28.57a1.53,1.53,0,0,0,1.49-1.18l4.3-18.63h4.88v-3h-6.1Z"/>
  </g>
  <line class="cls-3" x1="34.63" y1="22.19" x2="46.97" y2="22.19"/>
   <line class="cls-3" x1="32.94" y1="25.94" x2="41.8" y2="25.94"/>
   <line class="cls-3" x1="35.16" y1="29.68" x2="45.91" y2="29.68"/>
</svg>

    <?php
}

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

/**
 * Append account to main navigation
 * @return [type] [description]
 */
function rcp_nav_account() {
	global $current_user;
	get_currentuserinfo();

	$account_link_text 	= 'Account';
	$account_page 		= '/account';
	$affiliates_page 	= '/affiliates';
	$active 			= is_page( 'account' ) || is_page( 'affiliates' ) ? ' current-menu-item' : '';


	 ob_start();
	?>


		<li class="menu-item has-sub-menu account<?php echo $active; ?>">
			<a title="<?php echo $account_link_text; ?>" href="<?php echo site_url( $account_page ); ?>"><?php echo $account_link_text; ?></a>
			<ul class="sub-menu">
				<?php if (  is_user_logged_in() ) : ?>
					<li>
						<a title="<?php echo $account_link_text; ?>" href="<?php echo site_url( $account_page ); ?>"><?php echo $account_link_text; ?></a>
					</li>
				<?php endif; ?>
				<li>
					<a title="<?php _e( 'Affiliates', 'rcp' ); ?>" href="<?php echo site_url( $account_page . $affiliates_page ); ?>"><?php _e( 'Affiliates', 'rcp' ); ?></a>
				</li>
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
