<div id="secondary" class="<?php echo trustedd_secondary_classes(); ?>">
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'trustedd_primary_sidebar_start' ); ?>

		<aside id="subpages">
			<ul class="">
			    <?php wp_list_pages( array( 'title_li' => '', 'include' => rcp_get_post_top_ancestor_id() ) ); ?>
			    <?php wp_list_pages( array( 'title_li'=> '', 'depth' => 1, 'child_of' => rcp_get_post_top_ancestor_id(), 'sort_column' => 'menu_order' ) ); ?>
			</ul>
		</aside>

	</div>
</div>
