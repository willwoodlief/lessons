<div class="eltdf-course-list-holder <?php echo esc_attr( $holder_classes ); ?>" <?php echo wp_kses( $holder_data, array( 'data' ) ); ?>>
	<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/filter', '', $params, $additional_params ); ?>
	<div class="eltdf-cl-inner <?php echo esc_attr( $holder_inner_classes ); ?> clearfix">
		<?php
		if ( $query_results->have_posts() ):
			while ( $query_results->have_posts() ) : $query_results->the_post();
				echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'course-item', $slug, $params );
			endwhile;
		else:
			echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/posts-not-found' );
		endif;
		
		wp_reset_postdata();
		?>
	</div>
	
	<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'pagination/' . $pagination_type, '', $params, $additional_params ); ?>
</div>