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

	add_post_type_support( 'page', 'excerpt' );

	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'pricing.php' );

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

	if ( 'footer' == $args->theme_location ) {

    	$changelog = rcp_nav_changelog();

		return $items . $changelog;
    }

	return $items;

}
add_filter( 'wp_nav_menu_items', 'rcp_wp_nav_menu_items', 10, 2 );


/**
 * Prepend home link to main navigation
 *
 * @since  1.0
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
 * Prepend home link to main navigation
 *
 * @since  1.0
 */
function rcp_nav_changelog() {
	 ob_start();
	?>

	<li class="menu-item home">
		<a id="rcp-changelog" href="#" data-effect="mfp-move-from-bottom">Changelog</a>
	</li>

	<?php $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

/**
 * Add a notice underneath the pricing table
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
 * Prevent tabbing from one form to another accidentally
 *
 * @since 1.0.0
*/
add_filter( 'gform_tabindex', '__return_false' );

/**
 * Add hero
 *
 * @since 1.0.0
*/
function rcp_hero() {

	if ( ! is_front_page() ) {
		return;
	}

?>
	<div class="hero">

		<div class="hero-wrapper">
		<?php do_action( 'trustedd_hero' ); ?>
		</div>
	</div>
<?php
}
//add_action( 'trustedd_content_start', 'rcp_hero', 2 );

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

			    <?php /*
			    <text x="35" y="30" font-size="1em" text-anchor="middle" fill="#000000"><?php echo get_bloginfo( 'name' ); ?></text>
			    */ ?>
			</svg>
		</a>

	<?php

}
add_action( 'trustedd_site_branding_start', 'rcp_header_logo' );


/**
 * Hero
 *
 * @since 1.0.0
 */
function rcp_hero_middle2() {

	if ( ! is_front_page() ) {
		return;
	}

	?>

	<section>
		<div class="wrapper wide">
			<div class="intro aligncenter mb-4">
				<?php /* <h1>Restrict WordPress content, <br/>like never before.</h1> */?>
				<h1>A simple, yet powerful membership plugin for WordPress.</h1>

					<?php /* 	<h1>Powerful WordPress Memberships are finally simple.</h1>*/?>
				<?php /* <h2>Restrict Content Pro is a powerful membership plugin for WordPress that makes it easy to show content to your members.</h2> */ ?>


			</div>
		</div>

		<div class="wrapper wide">
			<div class="how-it-works columns-2 aligncenter">

				<div class="step">
					<div class="step-wrap">

					<object type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/step-one.svg'; ?>">Your browser does not support SVGs</object>

						<h2>Restrict your content</h2>
						<p>You've bled, sweat, and let's face it, you probably cried. But now you have amazing digital content people want.</p>
						<?php /* <p>You've put in the hard yards and have produced something truly amazing that you can't wait for others to get hold offproduced top quality digital content.</p> */ ?>
					</div>
				</div>

				<div class="step">
					<div class="step-wrap">

						<object type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/step-two.svg'; ?>">Your browser does not support SVGs</object>

						<h2>Reap the rewards</h2>
						<p>Once the customer makes payment, your content is instantly unlocked for their viewing pleasure.</p>
					</div>
				</div>


			</div>
		</div>

	</section>
	<?php

}
//add_action( 'trustedd_hero', 'rcp_hero_middle2', 11 );

/**
 * Hero
 *
 * @since 1.0.0
 */
function rcp_hero_middle() {

	if ( ! is_front_page() ) {
		return;
	}

	?>

	<section>
		<div class="wrapper wide">
			<div class="intro aligncenter mb-4">
				<?php /* <h1>Restrict WordPress content, <br/>like never before.</h1> */?>
				<h1>A simple, yet powerful membership plugin for WordPress.</h1>

				<object type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/step-one.svg'; ?>">Your browser does not support SVGs</object>

					<?php /* 	<h1>Powerful WordPress Memberships are finally simple.</h1>*/?>
				<?php /* <h2>Restrict Content Pro is a powerful membership plugin for WordPress that makes it easy to show content to your members.</h2> */ ?>

				<div class="wrapper aligncenter">
					<a href="#pricing" class="button huge mb-4">Let's go!</a>

				</div>

			</div>
		</div>



	</section>
	<?php

}
//add_action( 'trustedd_hero', 'rcp_hero_middle', 11 );


/**
 * Hero bottom
 */
function rcp_hero_bottom() {

	if ( ! is_front_page() ) {
		return;
	}

	?>

	<section>

		<div class="wrapper aligncenter">
			<a href="#pricing" class="button huge mb-4">Let's go!</a>

		</div>

	</section>
	<?php

}
//add_action( 'trustedd_hero', 'rcp_hero_bottom', 12 );

function rcp_gforms_change_validation_message( $message, $form ) {
    return "<div class='validation_error'><p>Oops! want to try entering your email again?</p></div>";
}
add_filter( 'gform_validation_message_1', 'rcp_gforms_change_validation_message', 10, 2 );


// filter the Gravity Forms button type

function rcp_gforms_pre_submit_button( $button, $form ) {
	return '<p class="note">You will receive an email confirmation that your submission was received.</p>' . $button;
}
add_filter( 'gform_submit_button_2', 'rcp_gforms_pre_submit_button', 10, 2 );

/**
 * Filter specific titles
 */
function rcp_the_title( $title, $id = null ) {

	// about
	// if ( is_page( 'about' ) && $id == get_the_ID() ) {
	// 	$title = __( 'About Pippin Williamson', 'rcp' );
	// }

	if ( is_page( 'pricing' ) && $id == get_the_ID() ) {
		$title = '<span class="entry-title-primary">30 Day Money Back Guarantee</span><span class="entry-subtitle">We stand behind our product 100% ' . rcp_show_refund_policy_link() . '</span>';
	}

    return $title;
}
add_filter( 'the_title', 'rcp_the_title', 10, 2 );



/**
 * Gravity Forms - change spinner
 *
 * @since 1.0
*/
function rcp_gform_ajax_spinner_url( $uri, $form ) {
	return get_stylesheet_directory_uri() . '/images/spinner.svg';
}
add_filter( 'gform_ajax_spinner_url', 'rcp_gform_ajax_spinner_url', 10, 2 );

/**
 * Load our site navigation
 *
 * @since 1.0
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
					<div id="mascot-body">
						<img src="<?php echo get_stylesheet_directory_uri() . '/images/mascot.png'; ?>" />
					</div>
					<div id="mascot-wing">
						<img src="<?php echo get_stylesheet_directory_uri() . '/images/mascot-wing.png'; ?>" />
					</div>
					<div id="mascot-wing-2">
						<img src="<?php echo get_stylesheet_directory_uri() . '/images/mascot-wing.png'; ?>" />
					</div>
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
 * @since  1.0
 */
function rcp_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'rcp-js', get_stylesheet_directory_uri() . '/js/rcp.min.js', array( 'jquery' ), RCP_THEME_VERSION, true );
	wp_enqueue_script( 'rcp-js' );

}
add_action( 'wp_enqueue_scripts', 'rcp_enqueue_scripts' );


/**
 * Changelog
 */
function rcp_product_changelog() {

	//$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );

	// if ( ! ( is_singular( 'download' ) || $changelog || ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) || is_front_page() ) ) {
	// 	return;
	// }

	?>


	<script type="text/javascript">

		 jQuery(document).ready(function($) {


			$('#rcp-changelog').magnificPopup({
				iframe: {
				  markup: '<div class="mfp-iframe-scaler" id="test">'+
				            '<div class="mfp-close"></div>'+
				            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
				          '</div>',
					  },
				type: 'iframe',
				items: {
			      src: 'https://pippinsplugins.com/products/restrict-content-pro/?changelog=1'
			    },
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

		// if ( is_page( 'pricing' ) ) {
		//
		// }



		});
	</script>

	<?php
}
//add_action( 'wp_footer', 'rcp_product_changelog', 100 );




/**
 * Magnific Popup
 */
function affwp_magnific_popup() {

	$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );

	//$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );
	//$affiliate_area = function_exists( 'affiliate_wp' ) ? is_page( affiliate_wp()->settings->get( 'affiliates_page' ) ) : '';

	if ( ! ( is_page( 'pricing' ) || is_front_page() || is_singular( 'download' ) || is_page( 'account' ) ) ) {
		return;
	}

	if ( is_singular( 'download' ) && ! $changelog ) {
		return;
	}

	?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {



		});
	</script>

	<?php
}
//add_action( 'wp_footer', 'affwp_magnific_popup', 100 );


/**
 * Disable jetpack carousel comments
 */
function rcp_remove_comments_on_attachments( $open, $post_id ) {

	$post = get_post( $post_id );

	if ( $post->post_type == 'attachment' ) {
        return false;
    }

	return $open;

}
add_filter( 'comments_open', 'rcp_remove_comments_on_attachments', 10 , 2 );
