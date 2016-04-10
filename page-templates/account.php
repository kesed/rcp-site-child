<?php
/**
 * Template Name: Account
 *
 */

get_header();

global $current_user;
get_currentuserinfo();

$price_ids = function_exists( 'rcp_get_users_price_ids' ) ? rcp_get_users_price_ids() : array();

$has_ultimate_license     = in_array( 4, $price_ids );
$has_professional_license = in_array( 3, $price_ids );
$has_plus_license         = in_array( 2, $price_ids );
$has_personal_license     = in_array( 1, $price_ids );

?>

<div id="tabs">
<header class="aligncenter page-header<?php echo themedd_page_header_classes(); ?>">

	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>

	<h2 class="subtitle">
		<?php if ( is_user_logged_in() ) : ?>
			<?php printf( __( 'Welcome, %s', 'rcp' ), $current_user->display_name ); ?>
		<?php else : ?>
			<?php _e( 'Come on in!', 'rcp' ); ?>
		<?php endif; ?>

	</h2>

</header>

<?php
$wrapper_class = ! is_user_logged_in() ? ' slim' : '';

?>
<section class="container-fluid">
<div class="wrapper<?php echo $wrapper_class; ?>">



	<div class="row">

		<div class="col-xs-12">


			<?php if ( affwp_is_affiliate() ) : ?>
			<p class="aligncenter"><a href="/account/affiliates">Go to your affiliate area &rarr;</a></p>
			<?php endif; ?>

			<?php if ( is_user_logged_in() ) : ?>
			<ul class="center-xs">
				<li><a href="#tab-1">Licenses</a></li>
				<li><a href="#tab-2">Subscriptions</a></li>
				<li><a href="#tab-3">Purchases</a></li>
				<li><a href="#tab-4">Profile</a></li>
				<li><a href="#tab-5">Downloads</a></li>
			</ul>
			<?php endif; ?>

			<?php
			/**
			 * Logout message
			 */
			if ( isset( $_GET['logout'] ) && $_GET['logout'] == 'success' ) { ?>
				<p class="alert notice">
					<?php _e( 'You have been successfully logged out', 'rcp' ); ?>
				</p>
			<?php } ?>

			<?php if ( ! is_user_logged_in() ) : ?>

				<?php /*
				<p>
					<a href="<?php echo site_url( 'account/register' ); ?>">Need to register an account?</a>
				</p>
				*/ ?>

				<?php echo edd_login_form( add_query_arg( array( 'login' => 'success', 'logout' => false ), site_url( $_SERVER['REQUEST_URI'] ) ) ); ?>

			<?php endif; ?>


			<?php if ( is_user_logged_in() ) : ?>

			<div id="tab-1">
				<h2>Licenses</h2>
				<?php echo do_shortcode( '[edd_license_keys]'); ?>
			</div>

			<div id="tab-2">
	  			<h2>Subscriptions</h2>
	  			<?php echo do_shortcode( '[edd_subscriptions]'); ?>
	  		</div>

			<div id="tab-3">
				<h2>Purchases</h2>
				<?php echo do_shortcode( '[purchase_history]'); ?>
			</div>

			<div id="tab-4">
				<div class="wrapper">
					<h2>Edit your profile</h2>
					<?php echo do_shortcode( '[edd_profile_editor]'); ?>
				</div>
			</div>

			<div id="tab-5">
				<h2>Downloads</h2>

				<?php if ( function_exists( 'rcp_edd_download_url' ) && rcp_edd_download_url( rcp_get_download_id() ) ) : ?>
					<h4>Restrict Content Pro</h4>
				    <p><a href="<?php echo rcp_edd_download_url( rcp_get_download_id() ); ?>" class="button">Download Restrict Content Pro</a></p>
				<?php endif; ?>

				<h4>Pro add-ons</h4>

				<?php

				global $post;
				/**
				 * Displays the most recent post
				 */
				$args = array(
					'posts_per_page' 	=> -1,
					'post_type'			=> 'download',
					'tax_query' => array(
							array(
								'taxonomy' => 'download_category',
								'field' => 'slug',
								'terms' => 'pro'
							),
						)
				);

				$add_ons = new WP_Query( $args );

				?>
				<table id="pro-add-ons">
					<thead>
						<tr>
							<th><?php _e( 'Name', 'rcp' ); ?></th>
							<th><?php _e( 'Version', 'rcp' ); ?></th>
							<th><?php _e( 'RCP Version required', 'rcp' ); ?></th>
							<th><?php _e( 'Download', 'rcp' ); ?></th>
						</tr>
					</thead>

					<tbody>

				<?php if ( have_posts() ) : ?>

						<?php while ( $add_ons->have_posts() ) : $add_ons->the_post(); ?>

						<?php

							$version 	= get_post_meta( get_the_ID(), '_edd_sl_version', true );
							$requires 	= get_post_meta( get_the_ID(), '_edd_download_meta_rcp_version_required', true );
						?>
						<tr>
							<td>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</td>
							<td><?php echo esc_attr( $version ); ?></td>
							<td><?php echo esc_attr( $requires ); ?></td>
							<td>
								<?php if ( edd_get_download_files( get_the_ID() ) ) : ?>

									<?php if ( ! ( $has_ultimate_license || $has_professional_license ) ) : ?>

											<?php if ( $has_plus_license || $has_personal_license ) : // upgrade ?>

												<a href="#upgrade" title="Upgrade License" class="popup-content" data-effect="mfp-move-from-bottom">Upgrade license to download</a>

											<?php else : // no license ?>
												<a href="<?php echo site_url('pricing'); ?>">Purchase Professional or Ultimate<br/> license to download</a>
											<?php endif; ?>

									<?php else : ?>

										<?php if ( $has_ultimate_license || $has_professional_license ) : ?>
												<a href="<?php echo rcp_get_add_on_download_url( get_the_ID() ); ?>">Download add-on</a>
										<?php endif; ?>
									<?php endif; ?>

								<?php endif; // edd_get_download_files ?>
							</td>
						</tr>

					<?php endwhile; ?>

				<?php endif; wp_reset_postdata(); ?>
					</tbody>
				</table>

			</div>
			<?php endif; ?>

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;

			?>
			</div>
		</div>


</div>
</section>

</div>
<?php
get_footer();
