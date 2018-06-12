<?php

if ( ! function_exists( 'eltdf_lms_register_course_list_widget' ) ) {
	/**
	 * Function that register course list widget
	 */
	function eltdf_lms_register_course_list_widget( $widgets ) {
		$widgets[] = 'eSmartsElatedClassCourseListWidget';
		
		return $widgets;
	}
	
	add_filter( 'esmarts_elated_filter_register_widgets', 'eltdf_lms_register_course_list_widget' );
}