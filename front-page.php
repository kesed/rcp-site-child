<?php
/**
 * Front page
 */
get_header(); ?>

<section class="hero">
	<div class="wrapper wide">
		<div class="intro">
			<?php /* <h1>Restrict WordPress content, <br/>like never before.</h1> */?>
			<!-- <h1>A simple, yet powerful membership solution for WordPress.</h1> -->

			<div class="wrapper">

				<div id="get-started">
				<h1>A simple, yet powerful membership solution for WordPress.</h1>
				<a href="#pricing" class="scroll button huge">Restrict your content</a>
				</div>

				<object id="vault" type="image/svg+xml" data="<?php echo get_stylesheet_directory_uri() . '/images/step-one.svg'; ?>">Your browser does not support SVGs</object>

			</div>




				<?php /* 	<h1>Powerful WordPress Memberships are finally simple.</h1>*/?>
			<?php /* <h2>Restrict Content Pro is a powerful membership plugin for WordPress that makes it easy to show content to your members.</h2> */ ?>

			<?php /*
			<div class="wrapper aligncenter">
				<a href="#pricing" class="button huge mb-4">Let's go!</a>

			</div>
			*/ ?>

		</div>
	</div>


</section>

<section class="">
	<div class="wrapper wide">
		<h1 class="aligncenter">Lock away your exclusive content.<br/> Give access to valued members.</h1>
		<p class="aligncenter">See some of the features below and learn why businesses trust Restrict Content Pro.</p>

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
							<p>Create an unlimited number of discount codes and offer percentage or flat rate based discounts.</p>
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
							<p>Accept credit cards with Stripe, Braintree, or PayPal Website Payments Pro. Restrict Content Pro also supports PayPal Standard and Express, as well as multiple payment options at the same time.</p>



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
							<p>Elegant and easy-to-use reports to show you exactly how well your membership site is performing. Easily see the current month’s performance, or any other time period.</p>



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
							<p>Generate a CSV of all active members of any particular subscription level, or a CSV of every member in the system. You can also generate a CSV of every payment that has been made.</p>
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
							<p>Contextual help inside the WordPress admin provides you relevant information at your finger tips.</p>



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
							<p>To help provide a better idea of what Restrict Content Pro looks like for subscribers, <a href="http://pippinsplugins.com/demo-rcp" target="_blank">visit the live demonstration site</a> and test our the registration process yourself.</p>

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
							<p>Create an unlimited number of subscription packages. You can easily create free, trial, and premium subscriptions.</p>
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
							<p>Easily view all active, pending, expired, cancelled, and free users.</p>
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
							<p>Restrict Content Pro makes it extremely easy to deliver premium content to your subscribers.</p>
						</div>
					</div>


				</div>
		</div>

	</div>
</section>

<section id="pricing">
	<div class="wrapper wide aligncenter">
		<h1>30 Day Money Back Guarantee</h1>
		<p>We stand behind our product 100% <?php echo rcp_show_refund_policy_link(); ?></p>
		<?php echo do_shortcode( '[edd_pricing_table]' ); ?>
	</div>
</section>

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
		<h1>See Restrict Content Pro</h1>
		<p><a href="<?php echo site_url( 'screenshots'); ?>">View more screenshots</a></p>

		<?php
		// show 3 images from the screenshots page
		$page = get_page_by_title( 'Screenshots' );

		if ( $page ) {
			$args = array(
				'post_mime_type' => 'image',
				'numberposts'    => 3,
				'post_parent'    => $page->ID,
				'post_type'      => 'attachment'
			);

			$gallery = get_children( $args );

			$gallery_ids = implode( ', ', wp_list_pluck( $gallery, 'ID' ) );

			echo do_shortcode( '[gallery size="large" ids="' . $gallery_ids . '"]' );
		}

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
