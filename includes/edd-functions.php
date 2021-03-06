<?php

/**
 * Load the post header on the single download pages
 * we don't want the header showing the default position
 */
function rcp_themedd_single_download_post_header() {

	if ( is_singular( 'download' ) ) {
		themedd_post_header();
	}

}
add_action( 'themedd_content_start', 'rcp_themedd_single_download_post_header' );

/**
 * Set the primary colummn width
 */
function rcp_themedd_primary_column_widths( $classes ) {

	if ( is_singular( 'download' ) ) {
		// reset the array
		$classes = array();
		// add our new classes
		$classes[] = 'col-xs-12 col-md-8';
	}

	// remove primary column widths on add-on pages
	if ( is_page( 'pro' ) || is_page( 'official' ) ) {
		$classes = array();
	}

	return $classes;

}
add_filter( 'themedd_primary_classes', 'rcp_themedd_primary_column_widths' );

/**
 * Set the secondary colummn width
 */
function rcp_themedd_secondary_column_widths( $classes ) {

	// make the secondary column slimmer
	$classes = array();
	$classes[] = 'col-xs-12 col-md-4';

	return $classes;

}
add_filter( 'themedd_secondary_classes', 'rcp_themedd_secondary_column_widths' );

/**
 * Remove download meta styling
 */
remove_action( 'wp_head', 'edd_download_meta_styles' );

/**
 * Add the cart icon to the primary navigation
 */
function rcp_themedd_cart_link_position() {
	return 'primary_menu';
}
add_filter( 'themedd_edd_cart_link_position', 'rcp_themedd_cart_link_position' );

/**
 * Turn cart icon count off since we're only selling 1 product
 */
add_filter( 'themedd_edd_cart_icon_count', '__return_false' );

/**
 * Show a full cart icon
 */
add_filter( 'themedd_edd_cart_icon_full', '__return_true' );

/**
 * Remove default class from cart icon anchor link
 */
function rcp_themedd_edd_cart_link_defaults( $defaults ) {
	$defaults['classes'] = array();

	return $defaults;
}
add_filter( 'themedd_edd_cart_link_defaults', 'rcp_themedd_edd_cart_link_defaults' );

/**
 * Remove pricing from pro add-on single download pages
 */
function rcp_remove_pricing_pro_addons() {

	if ( has_term( 'pro', 'download_category', get_the_ID() ) ) {
		remove_action( 'themedd_sidebar_download', 'themedd_edd_pricing' );
	}

}
add_action( 'template_redirect', 'rcp_remove_pricing_pro_addons' );

/**
 * Prevent pro addons from being added to cart with ?edd_action=add_to_cart&download_id=XXX
 *
 * @param int $download_id Download Post ID
 */
function rcp_edd_pre_add_to_cart( $download_id, $options ) {

	if ( has_term( 'pro', 'download_category', $download_id ) ) {
		wp_die( 'This add-on cannot be purchased', 'Error', array( 'back_link' => true, 'response' => 403 ) );
	}

}
add_action( 'edd_pre_add_to_cart', 'rcp_edd_pre_add_to_cart', 10, 2 );

/**
 * Shows a download button for logged-in Professional or Ultimate license holders
 * Shows an upgrade notice for logged-in Personal or Plus license holders
 * Shows a purchase button for logged-out users
 *
 * @since 1.0.0
 */
function rcp_edd_download_pro_add_on() {

	if ( ! has_term( 'pro', 'download_category' ) || ! edd_get_download_files( get_the_ID() ) ) {
		return;
	}

	?>
	<aside>
		<?php
			$has_ultimate_license     = in_array( 4, rcp_get_users_price_ids() );
			$has_professional_license = in_array( 3, rcp_get_users_price_ids() );

			if ( $has_ultimate_license || $has_professional_license ) : ?>
				<a href="<?php echo rcp_get_add_on_download_url( get_the_ID() ); ?>" class="button wide">Download Now</a>
			<?php else :  ?>
				<a href="#no-access" class="button popup-content wide" data-effect="mfp-move-from-bottom">Download Now</a>
				<?php rcp_upgrade_or_purchase_modal();
			endif;
		?>
	</aside>
<?php
}
add_action( 'themedd_sidebar_download', 'rcp_edd_download_pro_add_on' );


/**
 * Upgrade or purchase license modal
 */
function rcp_upgrade_or_purchase_modal() {

	$has_plus_license     = in_array( 2, rcp_get_users_price_ids() );
	$has_personal_license = in_array( 1, rcp_get_users_price_ids() );
	$upgrade_required     = $has_personal_license || $has_plus_license;
	$professional_add_ons = rcp_get_pro_add_on_count( 'pro' );

	?>
	<div id="no-access" class="popup entry-content mfp-with-anim mfp-hide">

		<?php if ( $upgrade_required ) : // has personal or plus license ?>
			<h1>Upgrade your license and get instant access!</h1>
		<?php else : // is logged out, or with no access ?>
			<h1>Get instant access to all pro add-ons!</h1>
		<?php endif; ?>

		<p>Pro add-ons are only available to <strong>Professional</strong> or <strong>Ultimate</strong> license-holders.
		Once you have one of these licenses you'll have access to all <?php echo $professional_add_ons; ?> pro add-ons (including this one), as well as any pro add-ons we build in the future.</p>

		<?php if ( ! $upgrade_required ) : // has personal or plus license ?>
		<p>If you already have a license that grants you access to the pro add-ons, simply log in to <a href="/account">your account</a> and visit the "downloads" section. Or, come back to this page to download!</p>
		<?php endif; ?>

		<?php

		$licenses = rcp_get_users_licenses();

		if ( $licenses ) : ?>
		<div class="rcp-licenses">
			<?php

			$license_heading = count( $licenses ) > 1 ? 'Your current licenses' : 'Your current license';
			?>

			<h2><?php echo $license_heading; ?></h2>

			<?php
				// a customer can happily have more than 1 license of any type
				if ( $licenses ) : ?>

					<?php foreach ( $licenses as $id => $license ) :

						if ( $license['limit'] == 0 ) {
							$license['limit'] = 'Unlimited';
						} else {
							$license['limit'] = $license['limit'];
						}

						$license_limit_text = $license['limit'] > 1 || $license['limit'] == 'Unlimited' ? ' sites' : ' site';

						?>
						<div class="rcp-license">

							<p><strong><?php echo edd_get_price_option_name( rcp_get_download_id(), $license['price_id'] ); ?></strong>  - <?php echo $license['license']; ?></p>

							<?php if ( rcp_has_license_expired( $license['license'] ) ) :

								$renewal_link = edd_get_checkout_uri( array(
									'edd_license_key' => $license['license'],
									'download_id'     => rcp_get_download_id()
								) );

								?>
								<p class="license-expired"><a href="<?php echo esc_url( $renewal_link ); ?>">Your license has expired. Renew your license now and save 40% &rarr;</a></p>
							<?php endif; ?>

							<ul>
								<?php if ( $license['price_id'] == 1 || $license['price_id'] == 2 ) : // personal or plus license

									// IDs are that of the "License Upgrade Paths" from the download page
								?>
									<li><a href="<?php echo esc_url( edd_sl_get_license_upgrade_url( $id, 2 ) ); ?>">Upgrade to Professional license (unlimited sites + pro add-ons)</a></li>
									<li><a href="<?php echo esc_url( edd_sl_get_license_upgrade_url( $id, 3 ) ); ?>">Upgrade to Ultimate license (unlimited sites + pro add-ons)</a></li>
								<?php endif; ?>
							</ul>

						</div>

					<?php endforeach; ?>

				<?php else : ?>
					<p>You do not have a license yet. <a href="<?php echo site_url( 'pricing' ); ?>">View pricing &rarr;</a></p>
				<?php endif; ?>
		</div>
		<?php endif; ?>

		<h2>The Professional license</h2>
		<ul>
			<li>Access all <?php echo $professional_add_ons; ?> pro add-ons, including any built in the future</li>
			<li>Use Restrict Content Pro on as many sites as you'd like</li>
			<li>1 year of updates and support</li>
		</ul>

		<?php

			$download_id = function_exists( 'rcp_get_download_id' ) ? rcp_get_download_id() : '';
			$checkout_url = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '';

			$download_url = add_query_arg( array( 'edd_action' => 'add_to_cart', 'download_id' => $download_id ), $checkout_url );

			$text = $upgrade_required ? 'Upgrade to' : 'Purchase';

			if ( $upgrade_required ) {
				$purchase_link = edd_sl_get_license_upgrade_url( $id, 2 );
			} else {
				// purchase link
				$purchase_link = $download_url . '&amp;edd_options[price_id]=3';
			}

		?>

		<a href="<?php echo esc_url( $purchase_link ); ?>" class="button"><?php echo $text; ?> Professional license</a>

		<h2>The Ultimate license</h2>
		<ul>
			<li>Access all <?php echo $professional_add_ons; ?> pro add-ons, including any built in the future</li>
			<li>Use Restrict Content Pro on as many sites as you'd like</li>
			<li>Receive unlimited updates and support &mdash; you'll never have to renew your license</li>
		</ul>

		<?php

		if ( $upgrade_required ) {
			$purchase_link = edd_sl_get_license_upgrade_url( $id, 3 );
		} else {
			// purchase link
			$purchase_link = $download_url . '&amp;edd_options[price_id]=4';
		}
		?>

		<a href="<?php echo esc_url( $purchase_link ); ?>" class="button"><?php echo $text; ?> Ultimate license</a>

	</div>

	<?php
}

/**
 * Get the download URL of Restrict Content Pro, based on the user's purchase
 */
function rcp_edd_download_url( $download_id = 0 ) {

	// get user's current purchases
	$purchases = edd_get_users_purchases( get_current_user_id(), -1, false, 'complete' );

	$found_purchase_key = false;

	if ( $purchases ) {

		foreach ( $purchases as $key => $purchase ) {

			$payment_meta = edd_get_payment_meta( $purchase->ID );

			// get array of all downloads purchased
			$download_ids = wp_list_pluck( $payment_meta['downloads'], 'id' );

			// download found
			if ( in_array( $download_id, $download_ids ) ) {
				$found_purchase_key = $key;
				break;
			}

		}

		// get payment meta for the purchase containing the download
		if ( $found_purchase_key ) {
			$payment_meta = edd_get_payment_meta( $purchases[$found_purchase_key]->ID );
		}

		// get the download files for the download
		$download_files = edd_get_download_files( $download_id );

		if ( ! $download_files ) {
			// no download file exists
			return false;
		}

		// we want to retrieve the first download file attached
		$download_index = array_keys( $download_files );

		// build the download URL
		$download_url = edd_get_download_file_url( $payment_meta['key'], $payment_meta['user_info']['email'], $download_index[0], $download_id );

		if ( $download_url ) {
			return $download_url;
		}

	}

	return false;

}





/**
 * Terms and conditions
 */
function rcp_show_refund_policy() {

	if ( ! function_exists( 'edd_is_checkout' ) || ! edd_is_checkout() ) {
		return;
	}

	$post = get_page_by_title( 'purchase terms and refund policy' );

	if ( ! $post ) {
		return;
	}

	?>

	<div id="refund-policy" class="popup entry-content mfp-with-anim mfp-hide">
		<h1><?php echo $post->post_title; ?></h1>
		<?php echo wpautop( $post->post_content, true ); ?>
	</div>

	<?php
}
add_action( 'wp_footer', 'rcp_show_refund_policy' );


/**
 * Redirect to pricing page when cart is empty.
 *
 * @return void
 */
function rcp_empty_cart_redirect() {
	$cart     = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : false;
	$redirect = site_url( 'pricing' );

	if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() && ! $cart ) {
		wp_redirect( $redirect, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'rcp_empty_cart_redirect' );

/**
 *
 * 10.00 becomes 10
 * 10.50 becomes 10.5
 *
 * @since 1.0
 */
function rcp_edd_download_price( $price, $download_id, $price_id ) {
	return floatval( $price );
}
add_filter( 'edd_download_price', 'rcp_edd_download_price', 10, 3 );

/**
 * Get ID of RCP based on title
 *
 * @since  1.3
 */
function rcp_get_download_id() {

	$download     = get_page_by_title( 'Restrict Content Pro', OBJECT, 'download' );
	$download_id  = $download->ID;

	if ( $download_id ) {
		return $download_id;
	}

	return false;
}

/**
 * Get number of add-ons in the pro add-ons category
 * Excludes any add-ons that are coming soon
 *
 * @since  1.3
 * @return int number of add-ons
 */
function rcp_get_pro_add_on_count() {

	$args = array(
		'post_type'         => 'download',
		'download_category' => 'pro',
		'posts_per_page'    => -1,
	);

	$add_ons = new WP_Query( $args );

	return (int) $add_ons->found_posts;

}

/**
 * Get number of add-ons in each category
 *
 * @since 1.3
 * @return string number of add-ons
 */
function rcp_get_add_on_count( $add_on_category = '' ) {

	if ( ! $add_on_category ) {
		return;
	}

	$args = array(
		'type'     => 'download',
		'taxonomy' => 'download_category',
	);

	$categories = get_categories( $args );

	foreach ( $categories as $category ) {

		if ( $category->slug == $add_on_category ) {
			$count = $category->count;
			return $count;
		}

	}

}

function rcp_get_users_price_ids( $user_id = 0 ) {

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	$keys = rcp_get_users_licenses( $user_id );

	if( $keys ) {
		$keys = wp_list_pluck( $keys, 'price_id' );
	} else {
		$keys = array();
	}

	return $keys;

}

/**
 * Get a user's download price IDs that they have access to
 *
 * @since  1.9
 */
function rcp_get_users_licenses( $user_id = 0 ) {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}

	// if user is still a guest return an empty array as their ID will be 0
	if ( ! $user_id ) {
		return array();
	}

	$args = array(
		'posts_per_page' => -1,
		'post_type'      => 'edd_license',
		'meta_key'       => '_edd_sl_user_id',
		'meta_value'     => $user_id,
		'fields'         => 'ids'
	);

	$keys     = array();
	$licenses = get_posts( $args );

	if ( $licenses ) {
		foreach( $licenses as $key ) {
			$keys[ $key ] = array(
				'license'     => get_post_meta( $key, '_edd_sl_key', true ),
				'price_id'    => get_post_meta( $key, '_edd_sl_download_price_id', true ),
				'limit'       => edd_software_licensing()->get_license_limit( rcp_get_download_id(), $key ),
				'expires'     => edd_software_licensing()->get_license_expiration( $key )
			);
		}
	}

	return $keys;
}


/**
 * Check an individual license to see if it has expired
 */
function rcp_has_license_expired( $license = '' ) {

	if ( ! $license ) {
		return false;
	}

	$check_license = edd_software_licensing()->check_license(
		array(
			'key'     => $license,
			'item_id' => rcp_get_download_id()
		)
	);

	if ( $check_license === 'expired' ) {
		return true;
	}

	return false;
}

/**
 * Check if any of the user's license has expired
 * @since 1.3
 */
function rcp_has_users_license_expired() {

	if ( ! function_exists( 'edd_software_licensing' ) ) {
		return;
	}

	$edd_sl      = edd_software_licensing();
	$licenses    = rcp_get_users_licenses();
	$has_expired = false;

	if ( $licenses ) {

		foreach ( $licenses as $license ) {

			if ( rcp_has_license_expired( $license['license'] ) ) {
				$has_expired = true;
				break;
			}

		}

	}

	return $has_expired;
}


/**
 * Returns the URL to download an add on
 *
 * @since 1.3
 *
 * @return string
*/
function rcp_get_add_on_download_url( $add_on_id = 0 ) {

	$args = array(
		'edd_action' => 'add_on_download',
		'add_on'     => $add_on_id,
	);

	return add_query_arg( $args, home_url() );
}

/**
 * Remove navigation on checkout
 *
 * @since 1.3
 */
function rcp_remove_checkout_nav() {

    if ( ! ( function_exists( 'themedd_is_edd_active' ) && themedd_is_edd_active() ) ) {
		return;
	}

	if ( ! edd_is_checkout() ) {
		return;
	}

    // remove the primary navigation
	remove_action( 'themedd_site_header_main', 'themedd_primary_menu' );

    // remove the mobile menu
    remove_action( 'themedd_site_header_main', 'themedd_menu_toggle' );

}
add_action( 'template_redirect', 'rcp_remove_checkout_nav' );

/**
 * Process add-on downloads
 *
 * Handles the file download process for add-ons.
 *
 * @access      private
 * @since       1.3
 * @return      void
 */
function rcp_process_add_on_download() {

	if ( ! isset( $_GET['add_on'] ) ) {
		return;
	}

	if ( ! is_user_logged_in() ) {
		return;
	}

	$add_on = absint( $_GET['add_on'] );

	if ( 'download' != get_post_type( $add_on ) ) {
		return;
	}

	$has_ultimate_license     = in_array( 4, rcp_get_users_price_ids() );
	$has_professional_license = in_array( 3, rcp_get_users_price_ids() );

	if ( ! ( $has_ultimate_license || $has_professional_license ) ) {
		wp_die( 'You need either a Professional or Ultimate license to download this pro add-on', 'Error', array( 'response' => 403 ) );
	}

	$user_info = array();
	$user_data 			= get_userdata( get_current_user_id() );
	$user_info['email'] = $user_data->user_email;
	$user_info['id'] 	= $user_data->ID;
	$user_info['name'] 	= $user_data->display_name;

	edd_record_download_in_log( $add_on, 0, $user_info, edd_get_ip(), 0, 0 );

	$download_files = edd_get_download_files( $add_on );
	$download_files = reset( $download_files );

	$requested_file = $download_files['file'];
	$file_extension = edd_get_file_extension( $requested_file );
	$ctype          = edd_get_file_ctype( $file_extension );

	if ( ! edd_is_func_disabled( 'set_time_limit' ) && ! ini_get('safe_mode') ) {
		set_time_limit(0);
	}

	if ( function_exists( 'get_magic_quotes_runtime' ) && get_magic_quotes_runtime() ) {
		set_magic_quotes_runtime(0);
	}

	@session_write_close();
	if( function_exists( 'apache_setenv' ) ) @apache_setenv('no-gzip', 1);
	@ini_set( 'zlib.output_compression', 'Off' );

	nocache_headers();
	header("Robots: none");
	header("Content-Type: " . $ctype . "");
	header("Content-Description: File Transfer");
	header("Content-Disposition: attachment; filename=\"" . basename( $requested_file ) . "\"");
	header("Content-Transfer-Encoding: binary");

	$method = edd_get_file_download_method();

	if ( 'x_sendfile' == $method && ( ! function_exists( 'apache_get_modules' ) || ! in_array( 'mod_xsendfile', apache_get_modules() ) ) ) {
		// If X-Sendfile is selected but is not supported, fallback to Direct
		$method = 'direct';
	}

	switch ( $method ) :

		case 'redirect' :

			// Redirect straight to the file
			header( "Location: " . $requested_file );
			break;

		case 'direct' :
		default:

			$direct       = false;
			$file_details = parse_url( $requested_file );
			$schemes      = array( 'http', 'https' ); // Direct URL schemes

			if ( ( ! isset( $file_details['scheme'] ) || ! in_array( $file_details['scheme'], $schemes ) ) && isset( $file_details['path'] ) && file_exists( $requested_file ) ) {

				/** This is an absolute path */
				$direct    = true;
				$file_path = $requested_file;

			} elseif ( defined( 'UPLOADS' ) && strpos( $requested_file, UPLOADS ) !== false ) {

				/**
				 * This is a local file given by URL so we need to figure out the path
				 * UPLOADS is always relative to ABSPATH
				 * site_url() is the URL to where WordPress is installed
				 */
				$file_path  = str_replace( site_url(), '', $requested_file );
				$file_path  = realpath( ABSPATH . $file_path );
				$direct     = true;

			} elseif ( strpos( $requested_file, WP_CONTENT_URL ) !== false ) {

				/** This is a local file given by URL so we need to figure out the path */
				$file_path  = str_replace( WP_CONTENT_URL, WP_CONTENT_DIR, $requested_file );
				$file_path  = realpath( $file_path );
				$direct     = true;

			}

			// Now deliver the file based on the kind of software the server is running / has enabled
			if ( function_exists( 'apache_get_modules' ) && in_array( 'mod_xsendfile', apache_get_modules() ) ) {

				header("X-Sendfile: $file_path");

			} elseif ( stristr( getenv( 'SERVER_SOFTWARE' ), 'lighttpd' ) ) {

				header( "X-LIGHTTPD-send-file: $file_path" );

			} elseif ( stristr( getenv( 'SERVER_SOFTWARE' ), 'nginx' ) || stristr( getenv( 'SERVER_SOFTWARE' ), 'cherokee' ) ) {

				// We need a path relative to the domain
				$file_path = str_ireplace( $_SERVER[ 'DOCUMENT_ROOT' ], '', $file_path );
				header( "X-Accel-Redirect: /$file_path" );

			} else

			if ( $direct ) {
				edd_deliver_download( $file_path );
			} else {
				// The file supplied does not have a discoverable absolute path
				header( "Location: " . $requested_file );
			}

			break;

	endswitch;

	edd_die();

	exit;
}
add_action( 'edd_add_on_download', 'rcp_process_add_on_download', 100 );

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

/**
 * Show button to view documentation after downloading free add-on
 */
function rcp_free_download_documentation_button() {

	if ( ! is_page( 'thanks' ) ) {
		return;
	}

	$purchase_session  = edd_get_purchase_session();
	$download_id       = $purchase_session['downloads'][0];
	$download_name     = $purchase_session['cart_details'][0]['name'];
	$documentation_url = get_post_meta( $download_id, '_edd_download_meta_doc_url', true );

	?>
	<p class="aligncenter">Thanks for downloading <?php echo $download_name; ?>, we hope you like it! <br/>Be sure to check out our other <a href="/add-ons">add-ons</a>.</p>

	<?php if ( $documentation_url ) : ?>
	<p class="aligncenter">
		<a href="<?php echo $documentation_url; ?>" class="button" target="_blank">View documentation for <?php echo $download_name; ?></a>
	</p>
	<?php endif; ?>

	<?php

}
add_action( 'themedd_entry_content_end', 'rcp_free_download_documentation_button' );

// get EDD currency
$currency = function_exists( 'edd_get_currency' ) ? edd_get_currency() : '';

/**
 * Wrap currency symbol in span
 *
 * @since 1.0.0
 */
function themedd_currency_before( $formatted, $currency, $price ) {

	// prevent filter when returning discount amount at checkout
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $formatted;
	}

	$symbol = edd_currency_symbol( $currency );

	if ( $symbol ) {
		$formatted = '<span class="currency">' . $symbol . '</span>' . $price;
	}

	return $formatted;
}
add_filter( 'edd_' . strtolower( $currency ) . '_currency_filter_before', 'themedd_currency_before', 10, 3 );

/**
 * Wrap currency symbol in span
 *
 * @since 1.0
 */
function themedd_currency_after( $formatted, $currency, $price ) {

	// prevent filter when returning discount amount at checkout
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $formatted;
	}

	$symbol = edd_currency_symbol( $currency );

	if ( $symbol ) {
		$formatted = $price . '<span class="currency">' . $symbol . '</span>';
	}

	return $formatted;
}

// remove decimal places when not needed
add_filter( 'edd_' . strtolower( $currency ) . '_currency_filter_after', 'themedd_currency_after', 10, 3 );

/**
 * Remove the existing licenses tab content when "Manage Sites" or "View Upgrades" links are clicked
 *
 * @since 1.0.0
 */
function rcp_theme_edd_sl_remove_content() {

	/**
	 * Make sure this only runs from account page. Consider adding setting to EDD customizer to get correct account page
	 */
	if ( is_page( 'account' ) ) {
		remove_filter( 'the_content', 'edd_sl_override_history_content', 9999 );
	}

	if ( empty( $_GET['action'] ) || 'manage_licenses' != $_GET['action'] ) {
		return;
	}

	if ( empty( $_GET['payment_id'] ) ) {
		return;
	}

	if ( isset( $_GET['license_id'] ) && isset( $_GET['view'] ) && 'upgrades' == $_GET['view'] ) {
		// remove existing tab content
		remove_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );
	} else {
		remove_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );
	}

}
add_action( 'template_redirect', 'rcp_theme_edd_sl_remove_content' );
