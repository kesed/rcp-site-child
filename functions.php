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
	define( 'RCP_THEME_VERSION', '1.0.2' );
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
 * Add external icon to pricing buttons
 *
 * @since 1.0.0
 */
function rcp_edd_pricing_table_purchase_button_end() {
	?>

	<object type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/svgs/combined/external.svg'; ?>"></object>

<?php
}
add_action( 'edd_pricing_table_purchase_button_end', 'rcp_edd_pricing_table_purchase_button_end' );


/**
 * Add a notice underneath the pricing table
 *
 * @since 1.0.0
 */
function rcp_pricing_table_notice() {
	?>
	<p class="trustedd-notice aligncenter">After choosing a pricing option you will be redirected to PippinsPlugins.com for payment.</p>

	<p class="trustedd-notice aligncenter">* You must renew the license after one calendar year for continued updates and support. All purchases are subject to our terms and conditions of use.</p>

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
 * Disable the primary menu from showing in the footer at mobile resolutions
 *
 * @since 1.0.0
 */
add_filter( 'trusted_footer_primary_menu', '__return_false' );

/**
 * Load our site navigation
 *
 * @since 1.0.0
 */
function rcp_footer_sign_up() {

?>

<div class="wrapper">

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
add_action( 'trustedd_footer_start', 'rcp_footer_sign_up' );

/**
 * Footer links
 *
 * @since 1.0.0
 */
function rcp_footer_menu() {
?>

<section>
	<div class="wrapper footer-links">

		<div class="grid columns-4">

			<div class="grid-child">


					<h4>Restrict Content Pro</h4>
					<ul>
						<li><a href="<?php echo site_url( 'pricing' ); ?>">Pricing</a></li>
						<li><a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Refund policy</a></li>
						<li><a href="<?php echo site_url( 'support' ); ?>">Support</a></li>
						<li><a href="http://docs.pippinsplugins.com/collection/4-restrict-content-pro" target="_blank">Documentation</a></li>
						<li><a href="<?php echo site_url( 'screenshots' ); ?>">Screenshots</a></li>
						<li><a href="#changelog" id="rcp-changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">Changelog</a></li>
						<!-- <li><a href="#">Features</a></li> -->
						<li><a href="<?php echo site_url( 'add-ons' ); ?>">Add-ons</a></li>
						<li><a href="<?php echo site_url( 'about' ); ?>">About</a></li>
						<li><a href="<?php echo site_url( 'consultants' ); ?>">Consultants</a></li>
						<li><a href="https://twitter.com/rcpwp" target="blank">Follow on Twitter</a></li>

						<!-- <li><a href="#">Pippin's Plugins</a></li> -->
						<!-- <li><a href="#">Testimonials</a></li> -->
						<!-- <li><a href="#">Brand Assets</a></li> -->

					</ul>




			</div>

			<div class="grid-child">

					<h4>Quick help</h4>
					<ul>
						<li><a href="http://docs.pippinsplugins.com/category/27-installation" target="_blank">Installation</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/815-payment-gateways" target="_blank">Payment gateways</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/45-common-issues" target="_blank">Common issues and FAQs</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/37-restricting-content" target="_blank">Restricting content</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/38-short-codes" target="_blank">Shortcodes</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/48-add-ons" target="_blank">Add-ons</a></li>
						<li><a href="http://docs.pippinsplugins.com/category/41-developer-documentation" target="_blank">Developer documentation</a></li>

					</ul>

			</div>

			<div class="grid-child">

			<?php
				$args = array(
					'title'        => 'Pippin\'s Plugins',  // Title of the Widget
					'url'          => 'https://pippinsplugins.com/feed/', // URL of the RSS Feed
					'items'        => 5, // Number of items to be displayed
					'show_summary' => 0, // Show post excerpts?
					'show_author'  => 0, // Set 1 to display post author
					'show_date'    => 0 // Set 1 to display post dates
				);

				the_widget( 'WP_Widget_RSS', $args );
			?>

			</div>

			<div class="grid-child meet-the-family">

					<h4>Meet the family</h4>
					<ul id="our-sites">

						<li class="affwp">
							<a href="http://affiliatewp.com/" target="_blank">
								<div class="mascot">
									<img src="<?php echo get_stylesheet_directory_uri() . '/images/affwp.png'; ?>" />
								</div>
								<div class="info">
									<h4>AffiliateWP</h4>
									<p>The best affiliate marketing plugin for WordPress.</p>
								</div>

							</a>

						</li>

						<li class="edd">
							<a href="https://easydigitaldownloads.com/" target="_blank">
								<div class="mascot">
									<img src="<?php echo get_stylesheet_directory_uri() . '/images/eddwp.png'; ?>" />
								</div>
								<div class="info">
									<h4>Easy Digital Downloads</h4>
									<p>The easiest way to sell digital downloads through WordPress,	for free.</p>
								</div>

							</a>

						</li>

					</ul>

			</div>

		</div>
	</div>

	<div id="changelog" class="popup entry-content mfp-with-anim mfp-hide">
		<h1>Changelog</h1>
		<?php echo rcp_get_changelog(); ?>
	</div>

</section>

<?php
}
add_action( 'trustedd_footer_before_site_info', 'rcp_footer_menu' );

/**
 * Get changelog from Pippin's Plugins
 */
function rcp_get_changelog() {

    // Check for transient, if none, grab remote HTML file
	if ( false === ( $html = get_transient( 'pp_rcp_changelog' ) ) ) {

        // Get remote HTML file
		$response = wp_remote_get( 'https://pippinsplugins.com/products/restrict-content-pro/changelog' );

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
 * Changelog
 *
 * @since 1.0.0
 */
function rcp_product_changelog() {

	?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {

			$('#rcp-changelog').magnificPopup({
				type: 'inline',
				fixedContentPos: true,
				fixedBgPos: true,
				overflowY: 'scroll',
				closeBtnInside: true,
				preloader: false,
				callbacks: {
					beforeOpen: function() {
					this.st.mainClass = this.st.el.attr('data-effect');
					}
				},
				midClick: true,
				removalDelay: 300
	        });

		});
	</script>

	<?php
}
add_action( 'wp_footer', 'rcp_product_changelog', 100 );

/**
 * Output custom icons - favicon & apple touch icon
 * @link https://github.com/audreyr/favicon-cheat-sheet
 */
function rcp_favicons() {
?>
	<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri() . '/images/favicon-152.png'; ?>">
	<?php
}
add_action( 'wp_head', 'rcp_favicons' );
