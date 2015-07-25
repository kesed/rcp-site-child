<?php
/**
 * Custom fields for the download meta
 * @since 1.0.0
*/

/**
 * Add new fields
 * @since 1.0.0
*/
function rcp_download_meta_add_fields() {
	?>

	<p><strong><?php _e( 'Developer', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-developer" class="screen-reader-text">
			<?php _e( 'Developer', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="trustedd_developer" id="trustedd-developer" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_trustedd_developer', true ) ); ?>" size="30" />
	</p>

	<p><strong><?php _e( 'Developer URL', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-developer-url" class="screen-reader-text">
			<?php _e( 'Developer URL', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="trustedd_developer_url" id="trustedd-developer-url" value="<?php echo esc_attr( get_post_meta( get_the_ID(), '_trustedd_developer_url', true ) ); ?>" size="30" />
	</p>

<?php }
add_action( 'trustedd_download_meta_add_fields', 'rcp_download_meta_add_fields' );

/**
 * Save the new fields
 *
 * @since 1.0.0
 */
function rcp_download_meta_save( $fields ) {

	$new_fields = array(
		'trustedd_developer',
		'trustedd_developer_url'
	);

	return array_merge( $fields, $new_fields );

}
add_filter( 'trustedd_download_meta_save', 'rcp_download_meta_save' );

/**
 * Sanitize fields
 *
 * @since 1.0.0
 */
function rcp_download_meta_santize( $new, $field ) {

	if ( $field == 'trustedd_developer_url' ) {
	    $new = esc_url_raw( $_POST[ $field ] );
	}

	return $new;
}
add_filter( 'trustedd_download_meta_save_fields', 'rcp_download_meta_santize', 10, 2 );

/**
 * Download last updated
 *
 * @since 1.0.0
 */
function rcp_download_developer() {

    $developer     = get_post_meta( get_the_ID(), '_trustedd_developer', true );
	$developer_url = get_post_meta( get_the_ID(), '_trustedd_developer_url', true );

?>
    <?php if ( $developer_url && $developer ) : ?>
    <li>
		<a href="<?php echo esc_url( $developer_url ); ?>" class="download-meta-link">
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</a>
	</li>

<?php elseif( $developer ) : ?>

		<li>
			<img src="<?php echo get_stylesheet_directory_uri() . '/images/download-developer.svg'; ?>" width="24" height="24">
			<span><?php echo $developer; ?></span>
		</li>

	<?php endif; ?>
<?php }
add_action( 'trustedd_product_info', 'rcp_download_developer' );
