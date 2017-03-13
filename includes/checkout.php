<?php

/**
 * Link to terms page
 * @return [type] [description]
 */
function rcp_edd_terms_agreement() {
	global $edd_options;

	// Does the cart contain a recurring subscription?
	$cart_contains_recurring = function_exists( 'EDD_Recurring' ) && EDD_Recurring()->cart_contains_recurring() ? true: false;

	// Tweak the agreement text if a subscription in being purchased.
	$extra_text = $cart_contains_recurring ? ' am purchasing a subscription and' : '';

	if ( isset( $edd_options['show_agree_to_terms'] ) ) : ?>


	<fieldset id="edd_terms_agreement">
		<input name="edd_agree_to_terms" class="required" type="checkbox" id="edd_agree_to_terms" value="1" />
		<label for="edd_agree_to_terms">
			I acknowledge and agree that I<?php echo $extra_text; ?> have read the <?php echo '<a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">purchase terms and refund policy</a>'; ?>
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
 * Add a hook before the content, but only on the EDD success page
 */
function rcp_theme_edd_success_page_the_content( $content ) {

	global $post;

	if ( $post && edd_is_success_page() && is_main_query() && ! post_password_required() ) {
		ob_start();
		do_action( 'rcp_theme_edd_success_page_the_content', $post->ID );
		$content = ob_get_clean() . $content;
	}

	return $content;
}
add_filter( 'the_content', 'rcp_theme_edd_success_page_the_content' );

/**
 * Success page modifications
 */
function rcp_theme_edd_success_page_content() {
	$purchase_session = edd_get_purchase_session();

	if ( $purchase_session ) : ?>
	<p class="mb-xs-4">Your purchase means a lot to us! In just a few moments you'll receive an email containing a download link for Restrict Content Pro. You can also download Restrict Content Pro from <a href="/account/">your account</a> or at the bottom of this page.</p>
	<?php endif;

	/**
	 * Ask the customer to share via Twitter if the purchase included a sale discount and the sale is still going (discount not expired, is active etc)
	 * Customer must use a valid sale discount for this to appear
	 */
	if ( rcp_theme_was_sale_purchase() ) :

		// Get discount.
		$discount = edd_get_discount( edd_get_discount_id_by_code( rcp_theme_was_sale_purchase() ) );

		// Get the discount amount.
		$discount_title  = $discount->name;
		$discount_amount = $discount->amount;


		$tweet = 'I just saved ' . $discount_amount . '%25 on Restrict Content Pro (@rcpwp), a membership solution for WordPress! Check it out:';
		$url   = 'https://restrictcontentpro.com';

	?>

	<section class="signup box mb-xs-4">

		<div class="mb-xs-2">
			<h3 class="signup-header aligncenter">You just saved <?php echo $discount_amount; ?>% on Restrict Content Pro during our <?php echo $discount_title; ?>!</h3>
		</div>

		<div class="aligncenter">
			<a class="button large twitter" href="https://twitter.com/intent/tweet/?text=<?php echo $tweet; ?>&amp;url=<?php echo $url; ?>" target="_blank">
				<svg version="1.1" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
					<g>
						<path d="M23.444,4.834c-0.814,0.363-1.5,0.375-2.228,0.016c0.938-0.562,0.981-0.957,1.32-2.019c-0.878,0.521-1.851,0.9-2.886,1.104 C18.823,3.053,17.642,2.5,16.335,2.5c-2.51,0-4.544,2.036-4.544,4.544c0,0.356,0.04,0.703,0.117,1.036 C8.132,7.891,4.783,6.082,2.542,3.332C2.151,4.003,1.927,4.784,1.927,5.617c0,1.577,0.803,2.967,2.021,3.782 C3.203,9.375,2.503,9.171,1.891,8.831C1.89,8.85,1.89,8.868,1.89,8.888c0,2.202,1.566,4.038,3.646,4.456 c-0.666,0.181-1.368,0.209-2.053,0.079c0.579,1.804,2.257,3.118,4.245,3.155C5.783,18.102,3.372,18.737,1,18.459 C3.012,19.748,5.399,20.5,7.966,20.5c8.358,0,12.928-6.924,12.928-12.929c0-0.198-0.003-0.393-0.012-0.588 C21.769,6.343,22.835,5.746,23.444,4.834z"/>
					</g>
				</svg>

				<span>Tell your friends on Twitter!</span>

			</a>
		</div>

	</section>

	<section class="more-deals">
		<h3 class="signup-header">More amazing deals!</h3>
		<p>We're also having a sale on our sister products, <a href="https://affiliatewp.com/?ref=867" target="_blank">AffiliateWP</a> and <a href="https://easydigitaldownloads.com/?ref=4680" target="_blank">Easy Digital Downloads</a>. Check them out!</p>
	</section>

	<?php endif;

	if ( $purchase_session ) : ?>

	<h3>Payment Details</h3>
<?php endif; ?>

<?php
}
add_action( 'rcp_theme_edd_success_page_the_content', 'rcp_theme_edd_success_page_content' );

/**
 * Load Twitter JS on purchase confirmation page
 *
 * @since 1.0.0
 */
function rcp_theme_twitter_scripts() {

	if ( ! ( rcp_theme_was_sale_purchase() ) ) {
		return;
	}

	?>

	<script>window.twttr = (function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0],
	    t = window.twttr || {};
	  if (d.getElementById(id)) return t;
	  js = d.createElement(s);
	  js.id = id;
	  js.src = "https://platform.twitter.com/widgets.js";
	  fjs.parentNode.insertBefore(js, fjs);

	  t._e = [];
	  t.ready = function(f) {
	    t._e.push(f);
	  };

	  return t;
	}(document, "script", "twitter-wjs"));</script>

	<?php

}
add_action( 'wp_footer', 'rcp_theme_twitter_scripts' );
