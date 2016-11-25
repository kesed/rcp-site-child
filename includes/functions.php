<?php


/**
 * Determine if the purchase was part of the Black Friday/Cyber Monday sale
 * Returns true if the discount was used
 */
function rcp_theme_was_sale() {

	// has discount expired?
	$is_discount_expired = edd_is_discount_expired( edd_get_discount_id_by_code( 'BFCM2016' ) );

	// is active?
	$is_discount_active = edd_is_discount_active( edd_get_discount_id_by_code( 'BFCM2016' ) );

	$is_discount_started = edd_is_discount_started( edd_get_discount_id_by_code( 'BFCM2016' ) );

	$purchase_session = edd_get_purchase_session();

	if ( $purchase_session && ! ( isset( $_GET['payment_key'] ) && $_GET['payment_key'] ) ) {

		// main purchase confirmation page
		$payment_id = edd_get_purchase_id_by_key( $purchase_session['purchase_key'] );

	} elseif ( isset( $_GET['payment_key'] ) && $_GET['payment_key'] ) {

		$payment_key = isset( $_GET['payment_key'] ) ? $_GET['payment_key'] : '';

		if ( $payment_key ) {
			// get the payment ID from the purchase key
			$payment_id = edd_get_purchase_id_by_key( $payment_key );
		}
	}

	// payment ID found
	if ( isset( $payment_id ) ) {

		$payment   = new EDD_Payment( $payment_id );
		$discounts = $payment->discounts;

		if ( 'BFCM2016' === $discounts && $is_discount_started && $is_discount_active && ! $is_discount_expired ) {
			return true;
		}

	}

	return false;
}
