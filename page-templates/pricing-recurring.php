<?php
/**
 * Template Name: Pricing - Recurring
 */

get_header(); ?>

<header class="page-header<?php echo trustedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>

<div class="content-area">

	<div class="mb-xs-2 wrapper ph-lg-1">

	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

		endwhile;
	?>

	<?php echo rcp_pricing_table();	?>

	<?php rcp_add_on_popups(); ?>

	</div>

	<section class="container-fluid feature testimonials">

	    <div class="row around-sm pv-xs-2 pv-sm-3 ph-lg-2">

	        <div class="col-xs-12 col-md-6 ph-xs-2 pv-lg-2 align-xs-center mb-xs-2 mb-md-0">

				<img class="avatar" src="<?php echo get_stylesheet_directory_uri() . '/images/testimonial-chris-lema.png'; ?>" alt="Chris Lema recommends Restrict Content Pro" />

				<div class="testimonial-wrap ph-xs-2 pv-xs-2">

					<blockquote>
	                    <p>When it comes to a fast and clean membership site, nothing is faster for end users than RCP. When it comes to extensible code that a developer will love, nothing is better than Pippin’s code.</p>
	                    <footer>&mdash; Chris Lema</footer>
	                </blockquote>
				</div>

	        </div>

	        <div class="col-xs-12 col-md-6 pv-lg-2 align-xs-center">
				<img class="avatar" src="<?php echo get_stylesheet_directory_uri() . '/images/testimonial-travis-northcutt.png'; ?>" alt="Travis Northcutt recommends Restrict Content Pro" />
				<div class="testimonial-wrap ph-xs-2 pv-xs-2">
					<blockquote>
						<p>RCP is always at the top of my list when helping clients choose a membership platform. In addition to being a great plugin ​today​, the pace of improvement is impressive. RCP gets better and better all the time.</p>
	                    <footer>&mdash; Travis Northcutt, The Bright Agency</footer>
	                </blockquote>
				</div>
	        </div>

	    </div>

	</section>

	<section class="container-fluid pv-xs-4 pv-lg-4">

		<h2 class="align-xs-center mb-sm-4">Frequently asked questions</h2>

	    <div class="row around-sm ph-sm-2 ph-lg-6">

	        <div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Do I need to renew my license?</strong></p>
				<p>Your license key is valid for one year from the purchase date. You need an active license key for continued access to automatic updates and support. License keys automatically renew at a 30% discount from the purchase price.</p>
	        </div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Can I cancel my subscription?</strong></p>
				<p>Yes, your subscription can be cancelled at anytime from your account page. You will retain access to support and updates until your license key expires, one year from the purchase date.</p>
	        </div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Can I upgrade my license?</strong></p>
				<p>Yes, you can easily upgrade your license from your <a href="<?php echo site_url( 'account'); ?>">account</a> page.</p>
	        </div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Can I purchase the pro add-ons separately?</strong></p>
				<p>The pro add-ons are only available to Professional or Ultimate license holders and cannot be purchased separately.</p>
	        </div>

			<?php
			$count_pro_add_ons           = rcp_get_add_on_count( 'pro' );
			$count_official_free_add_ons = rcp_get_add_on_count( 'official' );

			?>
			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Do I get access to add-ons?</strong></p>
				<p>We have <a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a> available for all license holders.</p>

				<p>If you have either a Professional or Ultimate license you also receive access to <a href="#modal-pro-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_pro_add_ons; ?> pro add-ons</a>, plus any additional pro add-ons we release in the future.</p>

				<p>There are also many <a href="<?php echo site_url( 'add-ons/3rd-party' ); ?>">3rd-party add-ons</a> (free and paid) available to either download or purchase.</p>

	        </div>


			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>I don't want a subscription</strong></p>
				<p>Your subscription can be cancelled at anytime after purchase. Once cancelled, your license key will not renew automatically and will expire on the expiration date. Once expired, you will no longer receive automatic updates or have access to support. You may manually renew your license at any time to reactivate your subscription.</p>
	        </div>


			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Do you have a refund policy?</strong></p>
				<p><a href="#refund-policy" class="popup-content" data-effect="mfp-move-from-bottom">Yes we do!</a> We stand behind the quality of our product and will refund 100% of your money if you are unhappy with the plugin.</p>
	        </div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Do I get updates for the plugin?</strong></p>
				<p>Yes! Automatic updates are available free of charge to all users with a valid license key.</p>
			</div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Do you offer support if I need help?</strong></p>
				<p>Yes! Top-notch customer support is key for a quality product, so we’ll do our very best to resolve any issues you encounter via our <a href="<?php echo esc_url( site_url( 'support' ) ); ?>">support page</a>.</p>
			</div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>I have other pre-sale questions, can you help?</strong></p>
				<p>Yes! You can ask us any question through our <a href="<?php echo esc_url( site_url( 'support' ) ); ?>">support page</a>.</p>
			</div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Will Restrict Content Pro work on WordPress.com?</strong></p>
				<p>No, Restrict Content Pro will not work on WordPress.com. It only works on self-hosted WordPress installs.</p>
			</div>

			<div class="col-xs-12 col-sm-5 ph-sm-0 mb-sm-2">
				<p><strong>Does Restrict Content Pro support dripped-content?</strong></p>
				<p>No, Restrict Content Pro does not support dripped content at this time.</p>
			</div>

	    </div>

		<div class="row center-sm ph-xs-2">
			<a href="#page" class="scroll button huge">Get started now</a>
		</div>

	</section>

</div>
<?php
get_footer();
