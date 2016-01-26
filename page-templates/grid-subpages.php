<?php
/**
 * Template Name: Grid - Subpages
 */

get_header();

// get the child pages of the current page
$child_pages = get_pages( 'parent=' . get_the_ID() . '&sort_column=menu_order&child_of=' . get_the_ID() );

?>

<header class="page-header<?php echo trustedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>

<section class="container-fluid">
	<div class="wrapper wide">
	    <div class="content-area">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'template-parts/content', 'page' );

				endwhile;
			?>

			<?php if ( $child_pages ) : ?>
			<div class="grid row mb-xs-4">
				<?php foreach ( $child_pages as $page ) :

				$page_id   = $page->ID;
				$title     = $page->post_title;
				$excerpt   = $page->post_excerpt;
				$permalink = get_permalink( $page_id );
				$image     = get_the_post_thumbnail ( $page_id );

				?>

				<div class="col-xs-12 col-sm-4 grid-item">
					<div class="grid-item-inner">

						<?php if ( $image ) : ?>
						<div class="grid-item-image"><a href="<?php echo $permalink; ?>"><?php echo $image; ?></a></div>
						<?php endif; ?>

						<div class="grid-item-content">
							<h3 class="grid-title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3>

							<?php if ( $excerpt ) : ?>
							<p><?php echo $excerpt; ?></p>
							<?php endif; ?>

						</div>

						<footer>
							<a href="<?php echo $permalink; ?>">Learn more</a>
						</footer>
					</div>
				</div>

	            <?php endforeach; ?>
		    </div>
			<?php endif; ?>

		</div>
	</div>
</section>
<?php
get_footer();
