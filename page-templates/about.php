<?php
/**
 * Template Name: About
 */

get_header(); ?>

<header class="page-header<?php echo themedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>

<div class="content-area">

	<div class="wrapper wide mb-xs-5">
		<section class="container-fluid about-team">
	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

		endwhile;
	?>
	</section>
	</div>

    <header class="page-header<?php echo themedd_page_header_classes(); ?>">
        <h1 class="page-title"><span class="entry-title-primary">Meet the team</span></h1>

    </header>

	<div class="mb-xs-2 wrapper wide">
	    <section class="container-fluid about-team">

			<div class="row mb-xs-2 mb-lg-4">
				<div class="col-xs-12 col-sm-3 mb-xs-2">
					<img class="profile" alt="About Pippin Williamson" src="<?php echo get_stylesheet_directory_uri() . '/images/about/pippin-williamson.jpg'; ?>">
				</div>

				<div class="col-xs-12 col-sm-9 mb-xs-2 mb-lg-4">
					<h2>Pippin Williamson</h2>
					<p>I'm a WordPress plugin developer from Hutchinson, Kansas, and the lead developer for Restrict Content Pro. Restrict Content Pro is an awesome membership and content management plugin - I know you'll love it!</p>
	<p>I'm a regular WordPress core contributor, and also the founder of <em>Easy Digital Downloads</em>, a complete eCommerce plugin for selling digital products through WordPress, and <em>AffiliateWP</em>, a complete affiliate marketing plugin for WordPress.</p>
	<p>In case you can't tell, WordPress is my passion, so if you're part of the WordPress community you'll likely see me around online (or offline, at various WordCamps).</p>
	<p class="mb-xs-0">Beyond the world of WordPress, I love spending time with my beautiful family, brewing different coffee varieties or craft beers, and getting out and about for a hike or bike.</p>
				</div>

			</div>

			<div class="row mb-xs-2 mb-lg-4">

				<div class="col-xs-12 col-sm-3 mb-xs-2 first-sm last-lg">
	                <img class="profile" alt="About John Parris" src="<?php echo get_stylesheet_directory_uri() . '/images/about/john-parris.jpg'; ?>">
	            </div>

	            <div class="col-xs-12 col-sm-9 mb-xs-2 mb-lg-4">
	                <h2>John Parris</h2>
	                <p>John has been a WordPress user since around 2008 (he doesn't really remember the year), and started developing WordPress software in 2012. As part of the Restrict Content Pro team, he helps develop, test, and support Restrict Content Pro and its add-ons.</p>
	<p>Before joining the Restrict Content Pro team, John worked full-time with the Easy Digital Downloads team. Prior to entering the WordPress world, John spent 20 years in various network administration and IT management roles.</p>

	<p class="mb-xs-0">In his spare time he enjoys hanging out with his wife, walking in the woods, and enjoying a nice cold-brewed coffee.</p>
	            </div>

	        </div>

	        <div class="row mb-xs-2 mb-lg-4">

				<div class="col-xs-12 col-sm-3 mb-xs-2">
					<img class="profile" alt="About Michael Beil" src="<?php echo get_stylesheet_directory_uri() . '/images/about/michael-beil.jpg'; ?>">
	            </div>

	            <div class="col-xs-12 col-sm-9 mb-xs-2 mb-lg-4">
	                <h2>Michael Beil</h2>
	                <p>Michael Beil is an avid WordPress user. He began his WordPress journey as a side job when a friend asked for some help in 2011, and he has not looked back since. As part of the Restrict Content Pro crew, he helps with support, testing, and emoji sharing.</p>
	                <p class="mb-xs-0">Michael is from the land of cheese and lakes, that is Madison, Wisconsin, where he enjoys playing hammered dulcimer, sailing, coffee brewing, and hanging out with his wife.</p>
	            </div>

	        </div>





	    </section>
	</div>





</div>
<?php
get_footer();
