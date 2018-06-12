<?php
//Register meta boxes
if ( ! function_exists( 'eltdf_lms_lesson_meta_box_functions' ) ) {
	function eltdf_lms_lesson_meta_box_functions( $post_types ) {
		$post_types[] = 'lesson';
		
		return $post_types;
	}
	
	add_filter( 'esmarts_elated_filter_meta_box_post_types_save', 'eltdf_lms_lesson_meta_box_functions' );
	add_filter( 'esmarts_elated_filter_meta_box_post_types_remove', 'eltdf_lms_lesson_meta_box_functions' );
}

//Register meta boxes scope
if ( ! function_exists( 'eltdf_lms_lesson_scope_meta_box_functions' ) ) {
	function eltdf_lms_lesson_scope_meta_box_functions( $post_types ) {
		$post_types[] = 'lesson';
		
		return $post_types;
	}
	
	add_filter( 'esmarts_elated_filter_set_scope_for_meta_boxes', 'eltdf_lms_lesson_scope_meta_box_functions' );
}

//Register lesson post type
if ( ! function_exists( 'eltdf_lms_register_lesson_cpt' ) ) {
	function eltdf_lms_register_lesson_cpt( $cpt_class_name ) {
		$cpt_class = array(
			'ElatedfLMS\CPT\Lesson\LessonRegister'
		);
		
		$cpt_class_name = array_merge( $cpt_class_name, $cpt_class );
		
		return $cpt_class_name;
	}
	
	add_filter( 'eltdf_lms_filter_register_custom_post_types', 'eltdf_lms_register_lesson_cpt' );
}

//Lesson single functions
if ( ! function_exists( 'eltdf_lms_get_single_lesson' ) ) {
	function eltdf_lms_get_single_lesson() {
		$params                = array();
		$params['item_id']     = get_the_ID();
		$params['lesson_type'] = get_post_meta( get_the_ID(), 'eltdf_lesson_type_meta', true );
		
		eltdf_lms_get_cpt_single_module_template_part( 'templates/single/holder', 'lesson', '', $params );
	}
}