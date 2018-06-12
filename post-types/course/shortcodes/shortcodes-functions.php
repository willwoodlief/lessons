<?php

if ( ! function_exists( 'eltdf_lms_include_portfolio_shortcodes' ) ) {
	function eltdf_lms_include_portfolio_shortcodes() {
		include_once ELATED_LMS_CPT_PATH . '/course/shortcodes/course-features.php';
		include_once ELATED_LMS_CPT_PATH . '/course/shortcodes/course-list.php';
		include_once ELATED_LMS_CPT_PATH . '/course/shortcodes/course-search.php';
		include_once ELATED_LMS_CPT_PATH . '/course/shortcodes/course-slider.php';
		include_once ELATED_LMS_CPT_PATH . '/course/shortcodes/course-table.php';
	}
	
	add_action( 'eltdf_lms_action_include_shortcodes_file', 'eltdf_lms_include_portfolio_shortcodes' );
}

if ( ! function_exists( 'eltdf_lms_add_portfolio_shortcodes' ) ) {
	function eltdf_lms_add_portfolio_shortcodes( $shortcodes_class_name ) {
		$shortcodes = array(
			'ElatedfLMS\CPT\Shortcodes\Course\CourseFeatures',
			'ElatedfLMS\CPT\Shortcodes\Course\CourseList',
			'ElatedfLMS\CPT\Shortcodes\Course\CourseSearch',
			'ElatedfLMS\CPT\Shortcodes\Course\CourseSlider',
			'ElatedfLMS\CPT\Shortcodes\Course\CourseTable'
		);
		
		$shortcodes_class_name = array_merge( $shortcodes_class_name, $shortcodes );
		
		return $shortcodes_class_name;
	}
	
	add_filter( 'eltdf_lms_filter_add_vc_shortcode', 'eltdf_lms_add_portfolio_shortcodes' );
}

if ( ! function_exists( 'eltdf_lms_set_course_icon_class_name_for_vc_shortcodes' ) ) {
	/**
	 * Function that set custom icon class name for portfolio list shortcodes to set our icon for Visual Composer shortcodes panel
	 */
	function eltdf_lms_set_course_icon_class_name_for_vc_shortcodes( $shortcodes_icon_class_array ) {
		$shortcodes_icon_class_array[] = '.icon-wpb-course-features';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-list';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-search';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-slider';
		$shortcodes_icon_class_array[] = '.icon-wpb-course-table';
		
		return $shortcodes_icon_class_array;
	}
	
	add_filter( 'eltdf_lms_filter_add_vc_shortcodes_custom_icon_class', 'eltdf_lms_set_course_icon_class_name_for_vc_shortcodes' );
}