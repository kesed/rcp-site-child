<?php
/**
 * Template Name: Wide
 */

get_header(); ?>

<div class="primary content-area">
	<div class="wrapper wide">

	<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'content', 'page' );

		endwhile;
	?>

	</div>
</div>
<?php
get_footer();