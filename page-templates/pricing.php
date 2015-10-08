<?php
/**
 * Template Name: Pricing
 */

get_header(); ?>

<div class="content-area">
	<div class="wrapper wide">

	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );

		endwhile;
	?>

	<?php echo do_shortcode( '[edd_pricing_table]' ); ?>

	</div>

	<div class="wrapper">

		<section class="feature testimonials">
			<div class="wrapper">

				<div class="grid columns-2">

					<div class="grid-child">
						<div class="grid-wrap">
							<img class="avatar" src="<?php echo get_stylesheet_directory_uri() . '/images/testimonial-chris-lema.png'; ?>" alt="Chris Lema recommends Restrict Content Pro" />

							<div class="testimonial-wrap">
								<blockquote>
									<p>When it comes to a fast and clean membership site, nothing is faster for end users than RCP. When it comes to extensible code that a developer will love, nothing is better than Pippin’s code.</p>
								</blockquote>

								<p class="testimonial-footer">&mdash; Chris Lema</p>
							</div>

						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<img class="avatar" src="<?php echo get_stylesheet_directory_uri() . '/images/testimonial-travis-northcutt.png'; ?>" alt="Travis Northcutt recommends Restrict Content Pro" />

							<div class="testimonial-wrap">
								<blockquote>
									<p>RCP is always at the top of my list when helping clients choose a membership platform. In addition to being a great plugin ​today​, the pace of improvement is impressive. RCP gets better and better all the time.</p>
								</blockquote>

								<p class="testimonial-footer">&mdash; Travis Northcutt, The Bright Agency</p>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section>
	</div>

	<div class="wrapper wide">

		<section class="">
			<div class="wrapper">
				<h2 class="aligncenter">Frequently asked questions</h2>

				<div class="grid columns-2 pricing-faq">

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Do I need to renew my license?</strong></p>
							<p>Your license key is valid for one year from the purchase date. You need an active license key for continued access to automatic updates and support. If you renew your license each year you’ll receive a huge 40% discount off the current price!</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Do you have a refund policy?</strong></p>
							<p><a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Yes we do!</a> We stand behind the quality of our product and will refund 100% of your money if you are unhappy with the plugin.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Do I get updates for the plugin?</strong></p>
							<p>Yes! Automatic updates are available free of charge to all users with a valid license key.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Can I upgrade my single-site license?</strong></p>
							<p>Yes, you can easily upgrade your license from <a href="https://pippinsplugins.com/account/">your account</a> page at any time.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Do you offer support if I need help?</strong></p>
							<p>Yes! Top-notch customer support is key for a quality product, so we’ll do our very best to resolve any issues you encounter via our <a href="<?php echo esc_url( site_url( 'support' ) ); ?>">support page</a>.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>I have other pre-sale questions, can you help?</strong></p>
							<p>Yes! You can ask us any question through our <a href="<?php echo esc_url( site_url( 'support' ) ); ?>">support page</a>.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Will Restrict Content Pro work on WordPress.com?</strong></p>
							<p>No, Restrict Content Pro will not work on WordPress.com. It only works on self-hosted WordPress installs.</p>
						</div>
					</div>

					<div class="grid-child">
						<div class="grid-wrap">
							<p><strong>Does Restrict Content Pro support dripped-content?</strong></p>
							<p>No, Restrict Content Pro does not support dripped content at this time.</p>
						</div>
					</div>


				</div>
			</div>
		</section>
	</div>



</div>
<?php
get_footer();
