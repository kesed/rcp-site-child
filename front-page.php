<?php
/**
 * Front page
 */
get_header(); ?>


<section class="">
	<div class="wrapper wide">

		<div class="grid features columns-2">

				<div class="grid-child">
					<div class="grid-wrap">

						<div>
							<svg width="63.5" height="55.501">
								<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-discount'; ?>"></use>
							</svg>
						</div>

						<div>
							<h4>Discount Codes</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">

						<div>
							<svg width="60" height="44">
								<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-integrations'; ?>"></use>
							</svg>
						</div>

						<div>
							<h4>Built-in Integrations</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
							<svg width="60" height="60">
								<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-reports'; ?>"></use>
							</svg>
						</div>

						<div>
							<h4>Reports</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
							<svg width="45" height="58">
								<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-export'; ?>"></use>
							</svg>
						</div>
						<div>
							<h4>Data Export</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">

						<div>
							<svg width="58" height="58">
								<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-support'; ?>"></use>
							</svg>
						</div>

						<div>
							<h4>Extensive Help</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
						<svg width="38" height="60">
							<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-demo'; ?>"></use>
						</svg>
						</div>
						<div>
							<h4>Live Demonstration</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
						<svg width="60" height="31">
							<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-unlimited-subscriptions'; ?>"></use>
						</svg>
						</div>
						<div>
							<h4>Unlimited Subscription Packages</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
						<svg width="60" height="60">
							<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-member-management'; ?>"></use>
						</svg>
						</div>
						<div>
							<h4>Members Management</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<div>
						<svg width="43" height="59">
							<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-simple-setup'; ?>"></use>
						</svg>
						</div>
						<div>
							<h4>Simple Set up</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>


				</div>
		</div>

	</div>
</section>

<section id="pricing">
	<div class="wrapper wide aligncenter">
		<h1>30 Day Money Back Guarantee</h1>
		<p>We stand behind our product 100% - see our refund We stand behind our product 100% - <a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">see our refund policy</a></p>
		<?php echo do_shortcode( '[edd_pricing_table]' ); ?>
	</div>
</section>
<?php rcp_embed_refund_policy(); ?>
<section class="feature">
		<div class="wrapper">
			<!-- <h1 class="aligncenter">Testimonials</h1> -->

			<div class="grid columns-3 testimonials">

				<div class="grid-child">
					<div class="grid-wrap">
						<blockquote>
							<?php echo get_avatar( 'andrew@sumobi.com', '96', '', 'Andrew Munro, Sumobi' ); ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</blockquote>

						<p class="testimonial-footer">&mdash; Andrew Munro, Sumobi</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<blockquote>
							<?php echo get_avatar( 'andrew@sumobi.com', '96', '', 'Andrew Munro, Sumobi' ); ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut enim ad minim veniam.</p>
						</blockquote>

						<p class="testimonial-footer">&mdash; Andrew Munro, Sumobi</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<blockquote>
							<?php echo get_avatar( 'andrew@sumobi.com', '96', '', 'Andrew Munro, Sumobi' ); ?>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</blockquote>

						<p class="testimonial-footer">&mdash; Andrew Munro, Sumobi</p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<section>
		<div class="wrapper wide aligncenter">
		<h1>Restrict Content Pro in action</h1>
		<p><a href="<?php echo site_url( 'screenshots'); ?>">View more screenshots</a></p>

		<?php
		// show 6 images from the screenshots page
		$page = get_page_by_title( 'Screenshots' );

		$args = array(
			'post_mime_type' => 'image',
			'numberposts'    => 3,
			'post_parent'    => $page->ID,
			'post_type'      => 'attachment'
		);

		$gallery = get_children( $args );

		?>

		<div class="gallery gallery-columns-3 gallery-size-large">

		<?php foreach( $gallery as $image ) { ?>

			<figure class="gallery-item">
				<div class="gallery-icon landscape">
					<a href="<?php echo wp_get_attachment_url( $image->ID ); ?>">
						<?php echo wp_get_attachment_image( $image->ID, 'large' ); ?>
					</a>
				</div>

				<?php if ( $image->post_excerpt ) : ?>
					<figcaption class="wp-caption-text gallery-caption"><?php echo $image->post_excerpt; ?></figcaption>
				<?php endif; ?>
			</figure>

		<?php } ?>
		</div>

		<?php
		//echo do_shortcode( '[gallery size="large" ids="23,24,25, 26, 27 ,28"]' );
		?>
		</div>
	</section>


<section id="payment-integrations">
	<div class="wrapper slim aligncenter">
		<h1>Payment integrations</h1>
		<p>Restrict Content Pro includes support for Stripe.com, Braintree, PayPal Standard, PayPal Express, and PayPal Website Payments Pro.</p>
	</div>

	<div class="wrapper aligncenter">

			<img src="<?php echo get_stylesheet_directory_uri() . '/images/stripe.svg'; ?>" alt="Stripe" />
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/braintree.svg'; ?>" alt="Braintree" />
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/paypal.svg'; ?>" alt="PayPal" />

	</div>
</section>

<?php get_footer(); ?>
