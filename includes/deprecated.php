<?php

/**
 * Add external icon to pricing buttons
 *
 * @since 1.0.0
 */
function rcp_edd_pricing_table_purchase_button_end() {
	?>

	<object type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/svgs/combined/external.svg'; ?>"></object>

<?php
}
add_action( 'edd_pricing_table_purchase_button_end', 'rcp_edd_pricing_table_purchase_button_end' );


/**
 * Add a notice underneath the pricing table
 *
 * @since 1.0.0
 */
function rcp_pricing_table_notice() {
	?>
	<p class="trustedd-notice aligncenter">After choosing a pricing option you will be redirected to PippinsPlugins.com for payment.</p>

	<p class="trustedd-notice aligncenter">* You must renew the license after one calendar year for continued updates and support. All purchases are subject to our terms and conditions of use.</p>

<?php
}
add_action( 'edd_pricing_table_bottom', 'rcp_pricing_table_notice' );
