<?php

/**
 * Prevent tabbing from one form to another accidentally
 *
 * @since 1.0.0
*/
add_filter( 'gform_tabindex', '__return_false' );

/**
 * Filter the validation error message on the support form
 *
 * @since 1.0.0
 */
function rcp_gforms_support_validation_message( $message, $form ) {

	if ( $form['title'] != 'Support Request' ) {
		return $message;
	}

	$message = '<div class="validation_error">Oops! There was a problem with your support request, see the errors below.</div>';

	return $message;
}
add_filter( 'gform_validation_message', 'rcp_gforms_support_validation_message', 10, 2 );

/**
 * Filter the validation error message on the email sign up form
 *
 * @since 1.0.0
 */
function rcp_gforms_signup_validation_message( $message, $form ) {

	if ( $form['title'] != 'Signup' ) {
		return $message;
	}

    return "<div class='validation_error'><p>Oops! try entering your email again</p></div>";
}
add_filter( 'gform_validation_message', 'rcp_gforms_signup_validation_message', 10, 2 );

/**
 * Add a note before the support submit button
 *
 * @since 1.0.0
 */
function rcp_gforms_support_add_note( $button, $form ) {

	if ( $form['title'] != 'Support Request' ) {
		return $button;
	}

	$button = '<p class="note">You will receive an email confirmation that your submission was received.</p>' . '<div>' . $button . '</div>';

	return $button;
}
add_filter( 'gform_submit_button', 'rcp_gforms_support_add_note', 10, 2 );

/**
 * Change button text on RCP
 *
 * @since 1.0.0
 */
function rcp_gforms_signup_button( $button, $form ) {

	if ( $form['title'] != 'Signup' ) {
		return $button;
	}

	$subscriber_count = function_exists( 'mailchimp_subscriber_count' ) && mailchimp_subscriber_count()->subscriber_count() ? 'Join ' . mailchimp_subscriber_count()->subscriber_count() . ' site owners' : 'Signup';

	$button = "<input type='submit' id='gform_submit_button_1' class='gform_button button' value='" . $subscriber_count . "' onclick='if(window['gf_submitting_1']){return false;} if( !jQuery('#gform_1')[0].checkValidity || jQuery('#gform_1')[0].checkValidity()){window['gf_submitting_1']=true;}' />";

	return $button;
}
add_filter( 'gform_submit_button', 'rcp_gforms_signup_button', 10, 2 );

/**
 * Gravity Forms - change spinner
 *
 * @since 1.0
*/
function rcp_gform_ajax_spinner_url( $uri, $form ) {
	return get_stylesheet_directory_uri() . '/images/spinner.svg';
}
add_filter( 'gform_ajax_spinner_url', 'rcp_gform_ajax_spinner_url', 10, 2 );
