<?php

if ( ! function_exists( 'eltdf_lms_course_category_fields' ) ) {
	function eltdf_lms_course_category_fields() {
		
		$course_category_fields = esmarts_elated_add_taxonomy_fields(
			array(
				'scope' => 'course-category',
				'name'  => 'course_category'
			)
		);
		
		esmarts_elated_add_taxonomy_field(
			array(
				'name'        => 'course_category_icon_pack',
				'type'        => 'icon',
				'label'       => esc_html__( 'Icon Pack', 'eltdf-lms' ),
				'description' => esc_html__( 'Choose icon from icon pack for taxonomy', 'eltdf-lms' ),
				'parent'      => $course_category_fields
			)
		);
	}
	
	add_action( 'esmarts_elated_action_custom_taxonomy_fields', 'eltdf_lms_course_category_fields' );
}