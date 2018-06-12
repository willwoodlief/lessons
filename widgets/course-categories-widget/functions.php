<?php

if ( ! function_exists( 'eltdf_lms_register_course_categories_widget' ) ) {
	/**
	 * Function that register course list widget
	 */
	function eltdf_lms_register_course_categories_widget( $widgets ) {
		$widgets[] = 'eSmartsElatedClassCourseCategoriesWidget';
		
		return $widgets;
	}
	
	add_filter( 'esmarts_elated_filter_register_widgets', 'eltdf_lms_register_course_categories_widget' );
}