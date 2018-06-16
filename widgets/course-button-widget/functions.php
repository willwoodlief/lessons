<?php

if ( ! function_exists( 'ecomhub_fi_register_course_button_widget' ) ) {
	/**
	 * Function that register course features widget
	 */
	function ecomhub_fi_register_course_button_widget( $widgets ) {
		$widgets[] = 'EcomhubFiCourseButtonWidget';
		
		return $widgets;
	}
	
	add_filter( 'esmarts_elated_filter_register_widgets', 'ecomhub_fi_register_course_button_widget' );
}