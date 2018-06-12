<div class="eltdf-course-table-holder">
	<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/table-h', '', $params ); ?>
	<?php if ( $query_results->have_posts() ):
		while ( $query_results->have_posts() ) : $query_results->the_post();
			$featured_item = get_post_meta( get_the_ID(), 'eltdf_course_featured_meta', true);
			$params['item_classes'] = $featured_item === 'yes' ? 'eltdf-cti-is-featured' : '';
			
			echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'course-table-item', '', $params );
		endwhile;
	else:
		echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/posts-not-found', '', $params );
	endif;
	
	wp_reset_postdata();
	?>
</div>