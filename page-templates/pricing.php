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

	<section class="">
		<div class="wrapper">
			<h2 class="aligncenter">Frequently asked questions</h2>

			<div class="grid columns-2 pricing-faq">

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.</p>
					</div>
				</div>

				<div class="grid-child">
					<div class="grid-wrap">
						<p><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit</strong></p>
						<p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo	consequat.</p>
					</div>
				</div>


			</div>
		</div>
	</section>



	</div>
</div>
<?php
get_footer();
