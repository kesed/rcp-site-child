<?php

/**
 * Set up the pricing table
 *
 * For now this filters the edd pricing tables plugin which will eventually provide a UI
 */
function rcp_edd_pricing_table_settings( $args ) {

	$args = array(
		'columns' => 3,
		'options' => array(
			'1' => array(
				'title'       => 'Personal',
				'id'          => 7460,
				'price'       => 42,
				'price_option' => 0,
				'button_link' => 'https://pippinsplugins.com/checkout/?referrer=rcp_site&utm_source=rcp-site&utm_medium=button&utm_campaign=RCP%20Site',
				'button_class' => 'external',
				'features' => array(
					1 => '<strong>1 site</strong>',
					2 => 'Updates for <strong>1 year</strong> *',
					3 => 'Support for <strong>1 year</strong> *',
					4 => 'All features included'
				)
			),
			'2' => array(
				'title' => 'Plus',
				'id'          => 7460,
				'price'       => 86,
				'price_option' => 1,
				'button_link' => 'https://pippinsplugins.com/checkout/?referrer=rcp_site&utm_source=rcp-site&utm_medium=button&utm_campaign=RCP%20Site',
				'button_class' => 'external',
				'features' => array(
					1 => '<strong>2 to 5 sites</strong>',
					2 => 'Updates for <strong>1 year</strong> *',
					3 => 'Support for <strong>1 year</strong> *',
					4 => 'All features included'
				)
			),
			'3' => array(
				'title' => 'Professional',
				'id'          => 7460,
				'price'       => 132,
				'price_option' => 2,
				'button_link' => 'https://pippinsplugins.com/checkout/?referrer=rcp_site&utm_source=rcp-site&utm_medium=button&utm_campaign=RCP%20Site',
				'button_class' => 'external',
				'features' => array(
					1 => '<strong>Unlimited sites</strong>',
					2 => 'Updates for <strong>1 year</strong> *',
					3 => 'Support for <strong>1 year</strong> *',
					4 => 'All features included'
				)
			),
		)
	);

	return $args;
}
add_filter( 'edd_pricing_table_settings', 'rcp_edd_pricing_table_settings' );
