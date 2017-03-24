<?php
/**
 * General
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Post Lightboxes
 */
function rcp_theme_post_lightbox() {

    if ( ! ( is_singular( 'post' ) || is_singular( 'download' ) || is_page( 'affiliates' ) ) ) {
        return;
    }

	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

			$('.enlarge').magnificPopup({
                type: 'image',
                preloader: true,
                closeOnContentClick: true,
                closeBtnInside: false,
                fixedContentPos: true,
                mainClass: 'mfp-with-zoom',
                image: {
                    verticalFit: true
                },
                zoom: {
                    enabled: true,
                    duration: 300
                }
            });

		});
	</script>

<?php
}
add_action( 'wp_footer', 'rcp_theme_post_lightbox', 100 );

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

	if ( is_page_template( 'page-templates/account.php' ) ) {
		$classes[] = 'account';
	}

	if ( rcp_is_template_child_page() ) {
		$classes[] = 'has-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'rcp_body_classes' );
