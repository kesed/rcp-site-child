<?php

/**
 * Pricing table
 */
function rcp_pricing_table() {

	$download_id = function_exists( 'rcp_get_download_id' ) ? rcp_get_download_id() : '';
	$checkout_url = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '';

	$download_url = add_query_arg( array( 'edd_action' => 'add_to_cart', 'download_id' => $download_id ), $checkout_url );



	$count_pro_add_ons           = function_exists( 'rcp_get_add_on_count' ) ? rcp_get_add_on_count( 'pro' ) : '';
	$count_official_free_add_ons = function_exists( 'rcp_get_add_on_count' ) ? rcp_get_add_on_count( 'official-free' ) : '';

?>

	<section class="container-fluid pricing-table mb-xs-4" id="pricing">

	    <div class="wrapper">

			<?php

			$cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

		//	var_dump( $cart_items );

			if ( $cart_items ) {
				$options = wp_list_pluck(  $cart_items, 'options' );
				$price_ids = wp_list_pluck(  $options, 'price_id' );
			}


		//	var_dump( $price_ids );


			?>

			<div class="row pricing table-row mb-xs-2">

				<?php
					$price_id = 4;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-5 mb-sm-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
                        <h2>Ultimate</h2>

                        <ul class="mb-xs-2">
                            <li class="pricing">
								<span class="price"><span class="currency">$</span>449</span>
								<span class="length">one-time payment</span>
							</li>
							<li class="feature"><strong><a href="#modal-pro-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_pro_add_ons; ?> pro add-ons</a></strong></li>

                            <li class="feature"><strong>Lifetime updates</strong></li>
                            <li class="feature"><strong>Lifetime support</strong></li>
							<li class="feature"><strong>Unlimited sites</strong></li>
							<li class="feature">All features included</li>

                        </ul>

                        <div class="footer">
							<?php
								if ( $in_cart ) {
									$button_link = $checkout_url;
									$text = 'Checkout';
								} else {
									$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
									$text = 'Purchase';
								}
							?>
							<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
                        </div>

	                </div>
	            </div>

				<?php
					$price_id = 3;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';

					if ( ! $cart_items ) {
						$highlight_class = ' best-value';
					} else {
						$highlight_class = '';
					}
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2<?php echo $highlight_class; ?><?php echo $in_cart_class; ?>">

	                <div class="table-option pv-xs-2">
						<?php if ( ! $cart_items ) : ?>
						<span>Most popular</span>
						<?php endif; ?>

						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>

	                        <h2>Professional</h2>

	                        <ul class="mb-xs-2">
	                            <li class="pricing">

									<span class="price">
										<span class="currency">$</span>199</span>
										<span class="length">per year</span>
								</li>

								<li class="feature"><strong><a href="#modal-pro-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_pro_add_ons; ?> pro add-ons</a></strong></li>

	                            <li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature"><strong>Unlimited sites</strong></li>
								<li class="feature">All features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>
	                </div>
	            </div>

				<?php
					$price_id = 2;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
							<h2>Plus</h2>

	                        <ul class="mb-xs-2">

								<li class="pricing">
									<span class="price"><span class="currency">$</span>99</span>
									<span class="length">per year</span>
								</li>
								<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>

	                            <li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature">5 sites</li>
								<li class="feature">All features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>
	                </div>
	            </div>

				<?php
					$price_id = 1;
					$in_cart = $cart_items ? in_array( $price_id, $price_ids ) : '';
					$in_cart_class = $cart_items && in_array( $price_id, $price_ids ) ? ' in-cart' : '';
				?>
	            <div class="col-xs-12 col-sm-6 col-lg-3 align-xs-center mb-xs-2<?php echo $in_cart_class; ?>">
	                <div class="table-option pv-xs-2">
						<?php if ( $in_cart ) : ?>
						<span>In your cart</span>
						<?php endif; ?>
	                        <h2>Personal</h2>

	                        <ul class="mb-xs-2">

								<li class="pricing">
									<span class="price"><span class="currency">$</span>49</span>
									<span class="length">per year</span>
								</li>

								<li class="feature"><strong><a href="#modal-offical-free-add-ons" class="popup-content" data-effect="mfp-move-from-bottom"><?php echo $count_official_free_add_ons; ?> official free add-ons</a></strong></li>

								<li class="feature">Plugin updates *</li>
	                            <li class="feature">Email support *</li>
								<li class="feature">1 site</li>
								<li class="feature">All features included</li>
	                        </ul>

							<div class="footer">
								<?php
									if ( $in_cart ) {
										$button_link = $checkout_url;
										$text = 'Checkout';
									} else {
										$button_link = $download_url . '&amp;edd_options[price_id]=' . $price_id;
										$text = 'Purchase';
									}
								?>
								<a class="button" href="<?php echo $button_link; ?>"><?php echo $text; ?></a>
	                        </div>

	                </div>
	            </div>

	        </div>

			<div class="row center-sm">
				<div class="col-xs-12 col-sm-10">
					<p><small>* Plugin updates and support are provided for the duration of your current subscription. Renewals discounted at 30%. Pro add-ons are only available with Professional and Ultimate licenses. See FAQs below for details. All purchases are subject to our terms of use.</small></p>
				</div>
			</div>

	    </div>

	</section>

	<?php rcp_add_on_popups(); ?>

	<?php
}


/**
 * Addon popups
 */
function rcp_add_on_popups() {

	// remove the filter on the pricing page title.
	remove_filter( 'the_title', 'rcp_the_title', 10, 2 );

	// remove the subtitles from showing in the pop ups
	remove_filter( 'the_title', array( Subtitles::getInstance(), 'the_subtitle' ), 10, 2 );

	  $args = array(
	      'post_type' => 'download',
	      'posts_per_page' => -1,
	      'tax_query' => array(
	          array(
	              'taxonomy' => 'download_category',
	              'field' => 'slug',
	              'terms' => 'pro'
	          )
	      )
	  );

	  $wp_query = new WP_Query( $args );
	?>

	<div id="modal-pro-add-ons" class="modal addons popup entry-content mfp-with-anim mfp-hide">
		<h1>Pro add-ons</h1>
		<p>Pro add-ons are only available to <strong>Professional</strong> or <strong>Ultimate</strong> license-holders.</p>
		<?php if ( $wp_query->have_posts() ) : ?>

		    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
		        <article>
		    		<h2><?php the_title(); ?></h2>

					<div class="row">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="col-xs-6">
								<?php the_excerpt(); ?>
							</div>
							<div class="col-xs-6">
								<?php themedd_post_thumbnail( 'thumbnail', false ); ?>
							</div>
						<?php else : ?>
							<div class="col-xs-12">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>
		    <?php endwhile; wp_reset_query(); ?>

		<?php endif; ?>

	</div>

	<?php

	  $args = array(
	      'post_type' => 'download',
	      'posts_per_page' => -1,
	      'tax_query' => array(
	          array(
	              'taxonomy' => 'download_category',
	              'field' => 'slug',
	              'terms' => 'official-free'
	          )
	      )
	  );

	  $official_free = new WP_Query( $args );

	?>

	<div id="modal-offical-free-add-ons" class="modal addons popup entry-content mfp-with-anim mfp-hide">

		<h1>Official Free Add-ons</h1>

		<?php if ( $official_free->have_posts() ) : ?>

		    <?php while ( $official_free->have_posts() ) : $official_free->the_post(); ?>

				<article>
		    		<h2><?php the_title(); ?></h2>

					<div class="row">
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="col-xs-6">
								<?php the_excerpt(); ?>
							</div>
							<div class="col-xs-6">
								<?php themedd_post_thumbnail( 'thumbnail', false ); ?>
							</div>
						<?php else : ?>
							<div class="col-xs-12">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>

					</div>
				</article>

		    <?php endwhile; wp_reset_query(); ?>

		<?php endif; ?>


	</div>

	<?php
}
