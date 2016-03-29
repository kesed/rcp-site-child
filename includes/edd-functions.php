<?php

/**
 * Link to terms page
 * @return [type] [description]
 */
function rcp_edd_terms_agreement() {
	global $edd_options;

	if ( isset( $edd_options['show_agree_to_terms'] ) ) : ?>


	<fieldset id="edd_terms_agreement">
		<input name="edd_agree_to_terms" class="required" type="checkbox" id="edd_agree_to_terms" value="1" />
		<label for="edd_agree_to_terms">
			I acknowledge and agree that I am purchasing a subscription and have read the <?php echo '<a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">purchase terms and refund policy</a>'; ?>
		</label>
	</fieldset>

	<?php // seems to only work when placed here ?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {

		// inline
		$('.popup-content').magnificPopup({
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

	<?php endif;
}
remove_action( 'edd_purchase_form_before_submit', 'edd_terms_agreement' );
add_action( 'edd_purchase_form_before_submit', 'rcp_edd_terms_agreement' );


/**
 * Terms and conditions
 */
function rcp_show_refund_policy() {

	if ( ! function_exists( 'edd_is_checkout' ) || ! edd_is_checkout() ) {
		return;
	}

	$post = get_page_by_title( 'purchase terms and refund policy' );

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
//add_filter( 'edd_download_price', 'rcp_edd_download_price', 10, 3 );

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
 * Upgrade license modal
 */
function rcp_upgrade_license_modal() {

	$professional_add_ons = rcp_get_pro_add_on_count( 'pro' );
	?>
	<div id="upgrade" class="popup entry-content mfp-with-anim mfp-hide">

		<h1>Upgrade your license</h1>
		<p>Pro add-ons are only available to <strong>Professional</strong> or <strong>Ultimate</strong> license-holders.</p>

		<p>Once you upgrade your license you'll have access to all <?php echo $professional_add_ons; ?> pro add-ons (including this one), as well as any pro add-ons we build in the future.</p>

		<div class="rcp-licenses">
			<?php
			$licenses = rcp_get_users_licenses();
			$license_heading = count( $licenses ) > 1 ? 'Your Licenses' : 'Your license';
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

							<p><strong><?php echo edd_get_price_option_name( rcp_get_download_id(), $license['price_id'] ); ?></strong> (<?php echo $license['limit'] . $license_limit_text; ?>) - <?php echo $license['license']; ?></p>

							<?php if ( rcp_has_license_expired( $license['license'] ) ) :

								$renewal_link = edd_get_checkout_uri( array(
									'edd_license_key' => $license['license'],
									'download_id'     => rcp_get_download_id()
								) );

								?>
								<p class="license-expired"><a href="<?php echo esc_url( $renewal_link ); ?>">Your license has expired. Renew your license now and save 40% &rarr;</a></p>
							<?php endif; ?>

							<?php if ( $license['price_id'] != 4 ) : // only provide upgrade if not ultimate ?>


								<ul>
									<?php if ( $license['price_id'] == 1 ) : // personal ?>
										<li><a title="Upgrade to Ultimate license" href="<?php echo rcp_get_license_upgrade_url( 'ultimate', $id ); ?>">Upgrade to Ultimate license (unlimited sites)</a></li>
										<li><a title="Upgrade to Professional license" href="<?php echo rcp_get_license_upgrade_url( 'professional', $id ); ?>">Upgrade to Professional license (unlimited sites)</a></li>
										<li><a title="Upgrade to Plus license" href="<?php echo rcp_get_license_upgrade_url( 'plus', $id ); ?>">Upgrade to Plus license (3 sites)</a></li>
									<?php endif; ?>

									<?php if ( $license['price_id'] == 2 ) : // plus ?>
										<li><a title="Upgrade to Ultimate license" href="<?php echo rcp_get_license_upgrade_url( 'ultimate', $id ); ?>">Upgrade to Ultimate license (unlimited sites)</a></li>
										<li><a title="Upgrade to Professional license" href="<?php echo rcp_get_license_upgrade_url( 'professional', $id ); ?>">Upgrade to Professional license (unlimited sites)</a></li>
									<?php endif; ?>

									<?php if ( $license['price_id'] == 3 ) : // professional ?>
										<li><a title="Upgrade to Ultimate license" href="<?php echo rcp_get_license_upgrade_url( 'ultimate', $id ); ?>">Upgrade to Ultimate license (unlimited sites)</a></li>
									<?php endif; ?>
								</ul>

							<?php endif; ?>

						</div>

					<?php endforeach; ?>

				<?php else : ?>
					<p>You do not have a license yet. <a href="<?php echo site_url( 'pricing' ); ?>">View pricing &rarr;</a></p>
				<?php endif; ?>
		</div>
		<h2>The Ultimate licence</h2>
		<ul>
			<li>Access all <?php echo $professional_add_ons; ?> pro add-ons, including any built in the future</li>
			<li>Use Restrict Content Pro on as many sites as you'd like</li>
			<li>Receive unlimited updates and support &mdash; you'll never have to renew your license</li>
		</ul>

		<h2>The Professional licence</h2>
		<ul>
			<li>Access all <?php echo $professional_add_ons; ?> pro add-ons, including any built in the future</li>
			<li>Use Restrict Content Pro on as many sites as you'd like</li>
			<li>1 year of updates and support</li>
		</ul>

	</div>

	<?php
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
 * Returns the URL to upgrade a license from personal -> plus or professional, or from plus -> professional
 *
 * @since 1.3
 *
 * @return string
*/
function rcp_get_license_upgrade_url( $type = '', $key_id = 0 ) {

	if ( ! function_exists( 'edd_get_checkout_uri' ) || ! $type ) {
		return home_url( '/pricing' );
	}

	switch ( $type ) {

		case 'plus' :
			$upgrade_id = 2;
			break;

		case 'professional' :
		default :
			$upgrade_id = 3;
			break;

		case 'ultimate' :
			$upgrade_id = 4;
			break;

	}

	return edd_sl_get_license_upgrade_url( $key_id, $upgrade_id );
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

	if ( ! edd_is_checkout() ) {
		return;
	}

	remove_action( 'trustedd_masthead', 'trustedd_navigation' );
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
		wp_die( 'You need either a Professional or Ultimate license to download this add-on', 'Error', array( 'response' => 403 ) );
	}

	$user_info = array();
	$user_data 			= get_userdata( get_current_user_id() );
	$user_info['email'] = $user_data->user_email;
	$user_info['id'] 	= $user_data->ID;
	$user_info['name'] 	= $user_data->display_name;

	edd_record_download_in_log( $add_on, 0, $user_info, edd_get_ip(), 0, 0 );

	$download_files = edd_get_download_files( $add_on );
	$requested_file = $download_files[0]['file'];
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
