<?php
/**
 * Custom fields for the download meta
 * @since 1.0.0
*/

/**
 * Add documentation icon
 */
function rcp_download_meta_icon_documentation() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-documentation.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_documentation', 'rcp_download_meta_icon_documentation' );

/**
 * Add last updated icon
 */
function rcp_download_meta_icon_last_updated() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-last-updated.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_last_updated', 'rcp_download_meta_icon_last_updated' );

/**
 * Add release date icon
 */
function rcp_download_meta_icon_release_date() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-released.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_release_date', 'rcp_download_meta_icon_release_date' );

/**
 * Add changelog icon
 */
function rcp_download_meta_icon_changelog() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-changelog.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_changelog', 'rcp_download_meta_icon_changelog' );

/**
 * Add version icon
 */
function rcp_download_meta_icon_version() {
	?>

	<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-version.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_version', 'rcp_download_meta_icon_version' );



/**
 * Add new fields
 * @since 1.0.0
*/
function rcp_download_meta_add_fields() {
	?>

	<p><strong><?php _e( 'Developer', 'trustedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-developer" class="screen-reader-text">
			<?php _e( 'Developer', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_developer" id="edd-download-meta-developer" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_developer', true ) ); ?>" size="30" />
	</p>

	<p><strong><?php _e( 'Developer URL', 'trustedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-developer-url" class="screen-reader-text">
			<?php _e( 'Developer URL', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_developer_url" id="edd-download-meta-developer-url" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_developer_url', true ) ); ?>" size="30" />
	</p>

	<p><strong><?php _e( 'RCP Version Required', 'trustedd' ); ?></strong></p>
	<p>
		<label for="edd-download-meta-developer-url" class="screen-reader-text">
			<?php _e( 'RCP Version Required', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="edd_download_meta_rcp_version_required" id="edd-download-meta-rcp-version-required" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_edd_download_meta_rcp_version_required', true ) ); ?>" size="30" />
	</p>

<?php }
add_action( 'edd_download_meta_add_fields', 'rcp_download_meta_add_fields' );

/**
 * Save the new fields
 *
 * @since 1.0.0
 */
function rcp_download_meta_save( $fields ) {

	$new_fields = array(
		'edd_download_meta_developer',
		'edd_download_meta_developer_url',
		'edd_download_meta_rcp_version_required'
	);

	return array_merge( $fields, $new_fields );

}
add_filter( 'edd_download_meta_save', 'rcp_download_meta_save' );

/**
 * Sanitize fields
 *
 * @since 1.0.0
 */
function rcp_download_meta_santize( $new, $field ) {

	if ( $field == 'edd_download_meta_developer_url' ) {
	    $new = esc_url_raw( $_POST[ $field ] );
	}

	return $new;
}
add_filter( 'edd_download_meta_save_fields', 'rcp_download_meta_santize', 10, 2 );

/**
 * Download developer
 *
 * @since 1.0.0
 */
function rcp_download_developer() {

    $developer     = get_post_meta( get_the_ID(), '_edd_download_meta_developer', true );
	$developer_url = get_post_meta( get_the_ID(), '_edd_download_meta_developer_url', true );

?>
    <?php if ( $developer_url && $developer ) : ?>
    <div class="download-meta">
		<a href="<?php echo esc_url( $developer_url ); ?>" class="download-meta-link" target="_blank">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</a>
	</div>

<?php elseif( $developer ) : ?>

		<div class="download-meta">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</div>

	<?php endif; ?>
<?php }
add_action( 'edd_download_meta', 'rcp_download_developer' );

/**
 * Changelog
 *
 * @since 1.0.0
 */
function rcp_download_meta_changelog() {

	// changelog
	$changelog = function_exists( 'edd_download_meta_has_edd_sl_enabled' ) && edd_download_meta_has_edd_sl_enabled() ? stripslashes( wpautop( get_post_meta( get_the_ID(), '_edd_sl_changelog', true ), true ) ) : '';

?>

	<?php if ( $changelog ) : ?>
		<div class="download-meta">

			<a href="#changelog" class="popup-content download-meta-link" data-effect="mfp-move-from-bottom">

				<?php do_action( 'edd_download_meta_changelog' ); ?>

				<span>View Changelog</span>
			</a>

			<div id="changelog" class="popup entry-content mfp-with-anim mfp-hide">
				<h1>Changelog</h1>
				<?php echo $changelog; ?>
			</div>

		</div>
		<?php endif; ?>

<?php }
add_action( 'edd_download_meta', 'rcp_download_meta_changelog', 10 );


/**
 *
 * Show the add-on's download category
 * @since 1.0.0
 */
function rcp_download_meta_category() {

	if ( has_term( 'pro', 'download_category', get_the_ID() ) ) {
		$link = site_url( 'add-ons/pro' );
		$text = 'Pro add-on';
	} elseif( has_term( 'official', 'download_category', get_the_ID() ) ) {
		$link = site_url( 'add-ons/official' );
		$text = 'Official add-on';
	} else {
		$link = '';
		$text = '';
	}

?>

	<?php if ( $text && $link ) : ?>
	<div class="download-meta">
		<a href="<?php echo $link; ?>" class="download-meta-link">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/svgs/download-category.svg'; ?>" width="24" height="24">
			<span><?php echo $text; ?></span>
		</a>
	</div>
	<?php endif; ?>

<?php }
add_action( 'edd_download_meta', 'rcp_download_meta_category', 10 );
