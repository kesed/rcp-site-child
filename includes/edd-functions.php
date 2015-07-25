<?php

/**
 *
 * 10.00 becomes 10
 * 10.50 becomes 10.5
 *
 * @since 1.0
 */
function trustedd_edd_download_price( $price, $download_id, $price_id ) {
	return floatval( $price );
}
add_filter( 'edd_download_price', 'trustedd_edd_download_price', 10, 3 );
