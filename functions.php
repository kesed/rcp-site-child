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
	define( 'RCP_THEME_VERSION', '1.7.3' );
}

function themedd_styles() {

	// Theme stylesheet.
	wp_enqueue_style( 'rcp', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'themedd_styles' );

/**
 * Setup
 *
 * @since 1.0
 */
function rcp_setup() {

	// add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );

	// add subtitles to downloads
	add_post_type_support( 'download', 'subtitles' );

	// Theme functions
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'theme-functions.php' );

	// Theme functions
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'countdown.php' );

	// Scripts
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'scripts.php' );

	if ( themedd_is_affiliatewp_active() ) {
		// Affiliates
		require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'affiliates.php' );
	}

	// General.
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'general.php' );

	// Tweaks to theme based on parent theme
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'theme-tweaks.php' );

	// add pricing to EDD Pricing Tables extension
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'pricing.php' );

	// GravityForm tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'gravity-forms.php' );

	// Simple Notices Pro tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'notices.php' );

	// Navigation tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'navigation.php' );

	// Account tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'account.php' );

	// Account tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'changelog.php' );

	// Checkout tweaks
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'checkout.php' );

	// Functions
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'functions.php' );

	// Subtitles
	require_once( trailingslashit( RCP_INCLUDES_DIR ) . 'compatibility/subtitles.php' );

	// EDD functions
	if ( function_exists( 'themedd_is_edd_active' ) && themedd_is_edd_active() ) {
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
 * Enqueue scripts
 *
 * @since 1.0.0
 */
function rcp_enqueue_scripts() {

	// in addition to the parent theme's JS we load our own
	wp_register_script( 'rcp-js', get_stylesheet_directory_uri() . '/js/rcp.min.js', array( 'jquery' ), THEMEDD_VERSION, true );
	wp_enqueue_script( 'rcp-js' );

	if ( is_page( 'account' ) ) {

		wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
		wp_enqueue_style( 'edd-sl-styles' );
	}

}
add_action( 'wp_enqueue_scripts', 'rcp_enqueue_scripts' );

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
