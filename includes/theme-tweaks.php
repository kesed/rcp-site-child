<?php

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
add_action( 'themedd_site_branding_start', 'rcp_header_logo' );

/**
 * Filter specific titles
 *
 * @since 1.0.0
 */
function rcp_the_title( $title, $id = null ) {

	if ( is_page( 'pricing' ) && $id === get_the_ID() && in_the_loop() ) {
		$title = '<span class="entry-title-primary">30 Day Money Back Guarantee</span><span class="subtitle mb-sm-6">We stand behind our product 100% ' . rcp_show_refund_policy_link() . '</span>';
	}

    return $title;
}
add_filter( 'the_title', 'rcp_the_title', 10, 2 );

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
add_filter( 'themedd_enable_popup', 'rcp_load_lightbox' );

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
 * Load Footer signup and mascot
 *
 * @since 1.0.0
 */
function rcp_footer_sign_up() {

	if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) {
		return;
	}

	if ( is_page( 'support' ) ) {
		return;
	}

?>



	<section id="sign-up" class="container-fluid mb-xs-2">
        <div class="wrapper aligncenter">
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
        </div>
	</section>



	<?php
}
add_action( 'themedd_footer_start', 'rcp_footer_sign_up' );

/**
 * Footer links
 *
 * @since 1.0.0
 */
function rcp_footer_menu() {

    if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) {
		return;
	}

?>

<div class="footer-wrapper">

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
                    <li><a href="<?php echo get_stylesheet_directory_uri() . '/changelog.php'; ?>" id="rcp-changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">Changelog</a></li>
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
						'title'        => 'Blog posts',  // Title of the Widget
						'url'          => 'https://restrictcontentpro.com/feed/', // URL of the RSS Feed
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
						<a href="https://affiliatewp.com/?ref=1" target="_blank">
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
						<a href="https://easydigitaldownloads.com/?ref=4632" target="_blank">
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

	</section>
</div>
<?php
}
add_action( 'themedd_footer_start', 'rcp_footer_menu' );

/**
 * Get changelog
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
 * Clears the changelog transient when the RCP download is saved.
 */
function rcp_delete_changelog_transient( $post_id ) {
	if ( rcp_get_download_id() == $post_id ) {
		delete_site_transient( 'pp_rcp_changelog' );
	}
}
add_action( 'save_post_download', 'rcp_delete_changelog_transient' );

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
             type: 'ajax',
             fixedContentPos: true,
             alignTop: true,
             fixedBgPos: true,
             overflowY: 'scroll', // as we know that popup content is tall we set scroll overflow by default to avoid jump
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
 * Load the subpages sidebar for subpages
 */
function rcp_load_sidebars( $sidebar ) {

	if ( rcp_is_template_child_page() ) {
		$sidebar = 'subpages'; // sidebar-subpages.php
	}

	return $sidebar;
}
add_filter( 'themedd_get_sidebar', 'rcp_load_sidebars' );

/**
 * Remove sidebars
 */
function rcp_remove_sidebars( $ret ) {

	if ( is_page( 'pro' ) || is_page( 'official-free' ) ) {
		$ret = false;
	}

	return $ret;
}
add_filter( 'themedd_show_sidebar', 'rcp_remove_sidebars' );

/**
 * Change primary column classes for payment gateway pages
 */
function rcp_themedd_primary_classes( $classes ) {

    // give subpages navigation some room
    if ( rcp_is_template_child_page() && ! is_page_template() ) {
        $classes = array();
        $classes[] = 'col-xs-12 col-md-8';
    }

    return $classes;
}
add_filter( 'themedd_primary_classes', 'rcp_themedd_primary_classes' );


function rcp_themedd_force_sidebar() {
	if ( rcp_is_template_child_page() && ! is_page_template() ) {
		add_filter( 'themedd_force_sidebar', '__return_true' );
	}
}
add_action( 'template_redirect', 'rcp_themedd_force_sidebar' );

/**
 * Remove download info from beginning of content
 */
remove_action( 'themedd_entry_content_start', 'themedd_edd_download_info' );

/**
 * Remove sidebar download info
 */
remove_action( 'themedd_sidebar_download', 'themedd_edd_download_info' );


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
add_action( 'themedd_subpages_end', 'rcp_subpages_cta' );

/**
 * Hide the post thumbnail on the feature pages
 */
function rcp_hide_post_thumbnail( $return ) {

	if ( rcp_is_single_feature() ) {
		$return = false;
	}

	return $return;
}
add_filter( 'themedd_post_thumbnail', 'rcp_hide_post_thumbnail' );

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
//add_filter( 'themedd_list_subpages_wrapper_class', 'rcp_list_subpages_wrapper_class' );
