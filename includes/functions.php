<?php

/**
 * Determine if the purchase was part of a sale
 */
function rcp_theme_was_sale_purchase() {

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

		// purchase must contain discount, discount must be started, active, and not expired

		$discount_id = edd_get_discount_id_by_code( $discounts );

		if (
			function_exists( 'rcpcf_discount_ids' ) &&
			in_array( $discount_id, rcpcf_discount_ids() ) && // make sure discount exists in the discount array
			edd_is_discount_started( $discount_id, false ) && // make sure discount has started, don't set error at checkout
			edd_is_discount_active( $discount_id ) &&         // make sure discount is active
			! edd_is_discount_expired( $discount_id )         // make sure discount has not expired
		) {
			return $discounts;
		}

	}

	return false;
}
