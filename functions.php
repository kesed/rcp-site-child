<?php
/**
 * Constants
 *
 * @since 1.0
 */
if ( ! defined( 'RCP_INCLUDES_DIR' ) ) {
	define( 'RCP_INCLUDES_DIR', trailingslashit( get_stylesheet_directory() ) . 'includes' ); /* Sets the path to the theme's includes directory. */
}

// microdata
// todo Add this back in
remove_action( 'loop_start', 'edd_microdata_wrapper_open', 10 );
remove_action( 'loop_end', 'edd_microdata_wrapper_close', 10 );
remove_filter( 'the_content', 'edd_microdata_description', 10 );
remove_filter( 'the_title', 'edd_microdata_title', 10, 2 );

/**
 * Setup
 *
 * @since 1.0
 */
function rcp_setup() {

	add_post_type_support( 'page', 'excerpt' );

	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'pricing.php' );

	// EDD functions
	if ( trustedd_is_edd_active() ) {
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'edd-functions.php' );
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'download-meta.php' );
	}

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
    }

	return $home . $items;

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
 * Modify front page
 *
 * @since 1.0.0
*/
function front_page_mods() {

	if ( is_front_page() ) {

		// remove the header
		remove_action( 'trustedd_header', 'trustedd_header' );

		add_action( 'trustedd_hero', 'trustedd_header' );

		// remove trustedd site branding
		remove_action( 'trustedd_masthead', 'trustedd_site_branding' );
	} else {
		// site logo
		remove_action( 'trustedd_masthead', 'trustedd_site_branding' );
	}

}
add_action( 'template_redirect', 'front_page_mods' );

/**
 * Add hero
 *
 * @since 1.0.0
*/
function rcp_hero() {
?>
	<div class="hero">
		<div class="hero-wrapper">
		<?php do_action( 'trustedd_hero' ); ?>
		</div>
	</div>
<?php
}
add_action( 'trustedd_header', 'rcp_hero' );

/**
 * Load our new site logo
 *
 * @since 1.0.0
 */
function rcp_header_logo() {

	?>
	<div class="site-branding">
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
	</div>
	<?php

}
add_action( 'trustedd_masthead', 'rcp_header_logo' );


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
add_action( 'trustedd_hero', 'rcp_hero_middle', 11 );


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
add_action( 'trustedd_hero', 'rcp_hero_bottom', 12 );

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
		$title = '<span class="entry-title-primary">30 Day Money Back Guarantee</span><span class="entry-subtitle">We stand behind our product 100% - <a href="#">see our refund policy</a></span>';
	}

    return $title;
}
add_filter( 'the_title', 'rcp_the_title', 10, 2 );


/**
 * Gravity Forms - change spinner
 *
 * @since 1.0
*/
function affwp_gform_ajax_spinner_url( $uri, $form ) {


	return get_stylesheet_directory_uri() . '/images/spinner.svg';

}
add_filter( 'gform_ajax_spinner_url', 'affwp_gform_ajax_spinner_url', 10, 2 );
