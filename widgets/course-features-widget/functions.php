<?php

if ( ! function_exists( 'eltdf_lms_register_course_features_widget' ) ) {
	/**
	 * Function that register course features widget
	 */
	function eltdf_lms_register_course_features_widget( $widgets ) {
		$widgets[] = 'eSmartsElatedClassCourseFeaturesWidget';
		
		return $widgets;
	}
	
	add_filter( 'esmarts_elated_filter_register_widgets', 'eltdf_lms_register_course_features_widget' );
}