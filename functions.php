<?php
/**
 * Constants
 *
 * @since 1.0
 */
if ( ! defined( 'RCP_INCLUDES_DIR' ) ) {
	define( 'RCP_INCLUDES_DIR', trailingslashit( get_stylesheet_directory() ) . 'includes' ); /* Sets the path to the theme's includes directory. */
}

if ( ! defined( 'RCP_THEME_VERSION' ) ) {
	define( 'RCP_THEME_VERSION', '1.0.6' );
}

/**
 * Setup
 *
 * @since 1.0
 */
function rcp_setup() {

	// add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

	// add pricing to EDD Pricing Tables extension
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'pricing.php' );

	// GravityForm tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'gravity-forms.php' );

	// EDD functions
	if ( function_exists( 'trustedd_is_edd_active' ) && trustedd_is_edd_active() ) {
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'edd-functions.php' );
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'download-meta.php' );
	}

	// Register footer menu
	register_nav_menus( array(
		'footer'   => __( 'Footer Menu', 'rcp' ),
	) );

}
add_action( 'after_setup_theme', 'rcp_setup' );

/**
 * Append extra links to primary navigation
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
		<a title="Home" href="<?php echo site_url(); ?>">Home</a>
	</li>

	<?php $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

/**
 * Add a notice underneath the pricing table
 *
 * @since 1.0.0
 */
function rcp_pricing_table_notice() {
	?>
	<p class="trustedd-notice">After choosing a pricing option you will be redirected to PippinsPlugins.com for payment.</p>
<?php
}
add_action( 'edd_pricing_table_bottom', 'rcp_pricing_table_notice' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function rcp_body_classes( $classes ) {

	if ( is_page( 'about' ) ) {
		$classes[] = 'about';
	}

	return $classes;
}
add_filter( 'body_class', 'rcp_body_classes' );

/**
 * Load our new site logo
 *
 * @since 1.0.0
 */
function rcp_header_logo() {

	?>

		<a id="logo" title="<?php echo get_bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<svg width="64" height="64" viewBox="0 0 172 173" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
				<title><?php echo get_bloginfo( 'name' ); ?></title>
				<desc><?php echo get_bloginfo( 'name' ); ?> - Membership plugin for WordPress</desc>
			        <path d="M151.333,12.3789L12.3789,12.3789L12.3789,151.333L-1.13687e-13,151.333L-1.13687e-13,-2.27374e-13L151.333,-2.27374e-13L151.333,12.3789Z" />
			        <path d="M21.2786,22.5397L21.2786,173.873L172.612,173.873L172.612,22.5397L21.2786,22.5397ZM157.187,158.42L105.233,158.42L91.3446,112.302C99.6136,107.837 105.233,99.0937 105.233,89.0377C105.233,74.4447 93.4026,62.6157 78.8106,62.6157C78.8026,62.6157 78.7956,62.6167 78.7876,62.6167L78.8106,158.396L36.7036,158.396L36.7036,37.7117L111.086,37.7117C136.547,37.7117 157.188,58.3517 157.188,83.8137C157.188,100.138 148.696,114.469 135.897,122.661L157.187,158.42Z" />
			</svg>
		</a>

	<?php

}
add_action( 'trustedd_site_branding_start', 'rcp_header_logo' );


/**
 * Filter specific titles
 *
 * @since 1.0.0
 */
function rcp_the_title( $title, $id = null ) {

	if ( is_page( 'pricing' ) && $id == get_the_ID() ) {
		$title = '<span class="entry-title-primary">30 Day Money Back Guarantee</span><span class="entry-subtitle">We stand behind our product 100% ' . rcp_show_refund_policy_link() . '</span>';
	}

    return $title;
}
add_filter( 'the_title', 'rcp_the_title', 10, 2 );

/**
 * Load our site navigation
 *
 * @since 1.0.0
 */
function rcp_footer_navigation() {

?>

<div class="wrapper footer-links">

	<section id="sign-up">
		<h3>Psst! Want to receive updates?</h3>

		<?php
			if ( function_exists( 'gravity_form' ) ) {
				gravity_form( 1, false, false, false, '', true );
			}
		?>

		<p>Unsubscribe at any time. No spam.</p>

		<div id="mascot">

			<div id="mascot-group">

				<div id="mascot-animate">
					<div id="mascot-body"></div>
					<div id="mascot-wing"></div>
				</div>

				<div id="mascot-shadow">
					<img src="<?php echo get_stylesheet_directory_uri() . '/images/mascot-shadow.png'; ?>" />
				</div>
			</div>

		</div>

	</section>

</div>

	<?php
}
add_action( 'trustedd_footer_start', 'rcp_footer_navigation' );

/**
 * Load the lightbox
 *
 * @since 1.0.0
 */
function rcp_load_lightbox( $lightbox ) {

	// load lightbox on pricing page
	if ( is_page( 'pricing' ) || is_front_page() ) {
		$lightbox = true;
	}

	return $lightbox;
}
add_filter( 'trustedd_enable_popup', 'rcp_load_lightbox' );

/**
 * Show refund policy link
 *
 * @since 1.0.0
 */
function rcp_show_refund_policy_link() {

	ob_start();
	?>

	- <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">see our refund policy</a>

	<?php

	return ob_get_clean();
}

/**
 * Embed the refund policy
 *
 * @since 1.0.0
 */
function rcp_embed_refund_policy() {

	// only show the refund policy on the homepage and the pricing page
	if ( ! ( is_page( 'pricing' ) || is_front_page() ) ) {
		return;
	}

	$refund_policy = get_page_by_title( 'refund policy' );

	if ( ! $refund_policy ) {
		return;
	}

	?>
	<div id="refund-policy" class="popup entry-content mfp-with-anim mfp-hide">
		<h1>
			<?php echo $refund_policy->post_title; ?>
		</h1>

		<?php echo stripslashes( wpautop( $refund_policy->post_content, true ) ); ?>
	</div>
	<?php
}
add_action( 'wp_footer', 'rcp_embed_refund_policy' );

/**
 * Enqueue scripts
 *
 * @since 1.0.0
 */
function rcp_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'rcp-js', get_stylesheet_directory_uri() . '/js/rcp.min.js', array( 'jquery' ), RCP_THEME_VERSION, true );
	wp_enqueue_script( 'rcp-js' );

}
add_action( 'wp_enqueue_scripts', 'rcp_enqueue_scripts' );

/**
 * Disable jetpack carousel comments
 *
 * @since 1.0.0
 */
function rcp_remove_comments_on_attachments( $open, $post_id ) {

	$post = get_post( $post_id );

	if ( $post->post_type == 'attachment' ) {
        return false;
    }

	return $open;

}
add_filter( 'comments_open', 'rcp_remove_comments_on_attachments', 10 , 2 );
