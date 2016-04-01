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
	define( 'RCP_THEME_VERSION', '1.3.5' );
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

	// Simple Notices Pro tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'notices.php' );

	// Navigation tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'navigation.php' );

	// EDD functions
	if ( function_exists( 'trustedd_is_edd_active' ) && trustedd_is_edd_active() ) {
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'edd-functions.php' );

		// adds additional options to the download meta plugin
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'download-meta.php' );
	}

	if ( is_admin() ) {
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'metabox.php' );
	}

	// Register footer menu
	register_nav_menus( array(
		'footer'   => __( 'Footer Menu', 'rcp' ),
	) );

}
add_action( 'after_setup_theme', 'rcp_setup' );





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
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function rcp_body_classes( $classes ) {

	global $post;

	if ( isset( $post) && has_shortcode( $post->post_content, 'gallery' ) ) {
		$classes[] = 'has-gallery';
	}

	if ( is_page( 'about' ) ) {
		$classes[] = 'about';
	}

	if ( is_page( 'features' ) ) {
		$classes[] = 'features';
	}

	if ( rcp_is_single_feature() ) {
		$classes[] = 'single-features';
	}

	$cart_items = edd_get_cart_contents();

	if ( $cart_items ) {
		$classes[] = 'items-in-cart';
	}

	if ( is_page_template( 'page-templates/account.php' ) ) {
		$classes[] = 'account';
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

	if ( ( is_page( 'pricing' ) || is_page( 'pricing-2' ) ) && $id == get_the_ID() ) {
		$title = '<span class="entry-title-primary">30 Day Money Back Guarantee</span><span class="subtitle">We stand behind our product 100% ' . rcp_show_refund_policy_link() . '</span>';
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
	if ( is_page( 'pricing' ) || is_page( 'pricing-2' ) || is_front_page() ) {
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
	if ( ! ( is_page( 'pricing' ) || is_page( 'pricing-2' ) || is_front_page() ) ) {
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

	wp_enqueue_script( 'jquery-ui-tabs' );

	// load jQuery UI + tabs for account page
	if ( is_page( 'account' ) ) {
		wp_enqueue_script( 'jquery-ui-core' );

		wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
		wp_enqueue_style( 'edd-sl-styles' );
	}

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

	if ( edd_is_checkout() ) {
		return;
	}

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

	if ( edd_is_checkout() ) {
		return;
	}

?>

<section class="container-fluid footer-links">

	<div class="row">

		<div class="col-xs-12 col-sm-6 col-lg-3">
			<h4>Restrict Content Pro</h4>
			<ul>
				<li><a href="<?php echo site_url( 'pricing' ); ?>">Pricing</a></li>
				<li><a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Refund policy</a></li>
				<li><a href="<?php echo site_url( 'support' ); ?>">Support</a></li>
				<li><a href="http://docs.pippinsplugins.com/collection/4-restrict-content-pro" target="_blank">Documentation</a></li>
				<li><a href="<?php echo site_url( 'screenshots' ); ?>">Screenshots</a></li>
				<li><a href="#changelog" id="rcp-changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">Changelog</a></li>
				<li><a href="<?php echo site_url( 'add-ons' ); ?>">Add-ons</a></li>
				<li><a href="<?php echo site_url( 'about' ); ?>">About</a></li>
				<li><a href="<?php echo site_url( 'consultants' ); ?>">Consultants</a></li>
				<li><a href="https://twitter.com/rcpwp" target="blank">Follow on Twitter</a></li>
			</ul>
		</div>

		<div class="col-xs-12 col-sm-6 col-lg-3">
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

		<div class="col-xs-12 col-sm-6 col-lg-3">
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

		<div class="col-xs-12 col-sm-6 col-lg-3 meet-the-family">
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
		$response = wp_remote_get( 'https://restrictcontentpro.com/downloads/restrict-content-pro/changelog' );

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

/**
 * Load the gateway sidebar for subpages
 */
function rcp_load_sidebars( $sidebar ) {

	if ( rcp_is_template_child_page() ) {
		$sidebar = 'subpages'; // sidebar-subpages.php
	}

	return $sidebar;
}
add_filter( 'trustedd_get_sidebar', 'rcp_load_sidebars' );

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

/**
 * Change primary column classes for payment gateway pages
 */
function rcp_trustedd_primary_classes( $classes ) {

	// give subpages navigation some room
	if ( rcp_is_template_child_page() && ! is_page_template() ) {
		$classes = array();
		$classes[] = 'col-xs-12 col-md-8';
	}

	return $classes;
}
add_filter( 'trustedd_primary_classes', 'rcp_trustedd_primary_classes' );

/**
 * Change CSS classes for wrapper
 */
function rcp_force_sidebar_layout( $classes ) {

	// tell the theme we want a sidebar class so the spacing is adjusted
	if ( rcp_is_template_child_page() && ! is_page_template() ) {
		$classes = array();
		$classes[] = 'has-sidebar';
	}

	return $classes;
}
add_filter( 'trustedd_wrapper_classes', 'rcp_force_sidebar_layout' );

/**
 * Add a purchase button to the feature subpages
 */
function rcp_subpages_cta() {
	?>

	<div class="wrapper ph-xs-2 mb-xs-2">
		<a href="<?php echo site_url( 'pricing' ); ?>" class="button">Get started now &rarr;</a>
	</div>

	<?php
}
add_action( 'trustedd_subpages_end', 'rcp_subpages_cta' );

/**
 * Hide the post thumbnail on the feature pages
 */
function rcp_hide_post_thumbnail( $return ) {

	if ( rcp_is_single_feature() ) {
		$return = false;
	}

	return $return;
}
add_filter( 'trusted_post_thumbnail', 'rcp_hide_post_thumbnail' );

/**
 * Show the SVGs in the metabox
 */
function rcp_custom_admin_styles() {
	?>
	<style>	img.mpt-thumbnail{width: auto;}
	<?php
}
add_action( 'admin_head', 'rcp_custom_admin_styles' );

/**
 * Show draft pages in the pages dropdown
 */
function rcp_show_draft_pages( $dropdown_args, $post ) {

	$dropdown_args[ 'post_status' ] = array( 'publish', 'draft' );

	return $dropdown_args;

}
add_filter( 'page_attributes_dropdown_pages_args', 'rcp_show_draft_pages', 10, 2 );

/**
 * Alternate layout for features page
 * Removes the default wide wrapper class bringing the images to the edges
 */
function rcp_list_subpages_wrapper_class( $class ) {

	if ( is_page( 'features' ) ) {
		$class = 'full-width';
	}

	return $class;

}
//add_filter( 'trustedd_list_subpages_wrapper_class', 'rcp_list_subpages_wrapper_class' );


/**
 * Add learn more link to pro add-ons
 */
function rcp_show_learn_more() {

	if ( ! has_term( 'pro', 'download_category', get_the_ID() ) ) {
		return;
	}

	?>

	<footer>
		<a href="<?php echo get_permalink( get_the_ID() ); ?>">Learn more</a>
	</footer>

	<?php
}
add_action( 'edd_download_after', 'rcp_show_learn_more' );

/**
 * Show draft downloads to admins
 */
function rcp_edd_downloads_query( $query, $atts ) {

	if ( current_user_can( 'manage_options' ) ) {
		$query['post_status'] = array( 'pending', 'draft', 'future', 'publish' );
	}

	return $query;
}
add_filter( 'edd_downloads_query', 'rcp_edd_downloads_query', 10, 2 );

/**
 * Redirect to correct tab when profile is updated
 */
function rcp_edd_profile_updated( $user_id, $userdata ) {
	wp_safe_redirect( add_query_arg( 'updated', 'true', '#tabs=3' ) );
	exit;
}
add_action( 'edd_user_profile_updated', 'rcp_edd_profile_updated', 10, 2 );

/**
 * Remove the license keys column from the purchases tab
 */
remove_action( 'edd_purchase_history_row_end', 'edd_sl_site_management_links', 10 );
remove_action( 'edd_purchase_history_header_after', 'edd_sl_add_key_column' );

/**
 * Redirect to the second account tab when clicking the update payment method link
 */
function rcp_edd_subscription_update_url( $url, $object ) {

	$url = add_query_arg( array( 'action' => 'update', 'subscription_id' => $object->id ), '#tabs=1' );

	return $url;
}
add_filter( 'edd_subscription_update_url', 'rcp_edd_subscription_update_url', 10, 2 );

/**
 * Removes the "I acknowledge that by updating this subscription, the following subscriptions will also be updated to use this payment method for renewals: {download name}" message
 */
global $edd_recurring_stripe;
remove_action( 'edd_after_cc_fields', array( $edd_recurring_stripe, 'after_cc_fields'  ), 10 );
