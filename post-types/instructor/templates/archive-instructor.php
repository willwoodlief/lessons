<?php
get_header();
esmarts_elated_get_title();
do_action( 'esmarts_elated_action_before_main_content' ); ?>
<div class="eltdf-container eltdf-default-page-template">
	<?php do_action( 'esmarts_elated_action_after_container_open' ); ?>
	<div class="eltdf-container-inner clearfix">
		<?php
		$eltdf_taxonomy_id   = get_queried_object_id();
		$eltdf_taxonomy      = ! empty( $eltdf_taxonomy_id ) ? get_category( $eltdf_taxonomy_id ) : '';
		$eltdf_taxonomy_slug = ! empty( $eltdf_taxonomy ) ? $eltdf_taxonomy->slug : '';
		
		eltdf_lms_get_instructor_category_list( $eltdf_taxonomy_slug );
		?>
	</div>
	<?php do_action( 'esmarts_elated_action_before_container_close' ); ?>
</div>
<?php get_footer(); ?>
