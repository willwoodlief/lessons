<?php

if ( ! function_exists( 'eltdf_lms_course_options_map' ) ) {
	function eltdf_lms_course_options_map() {
		
		esmarts_elated_add_admin_page(
			array(
				'slug'  => '_course',
				'title' => esc_html__( 'Course', 'eltdf-lms' ),
				'icon'  => 'fa fa-book'
			)
		);
		
		$panel_archive = esmarts_elated_add_admin_panel(
			array(
				'title' => esc_html__( 'Course Archive', 'eltdf-lms' ),
				'name'  => 'panel_course_archive',
				'page'  => '_course'
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'        => 'course_archive_number_of_items',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Items', 'eltdf-lms' ),
				'description' => esc_html__( 'Set number of items for your course list on archive pages. Default value is 12', 'eltdf-lms' ),
				'parent'      => $panel_archive,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'          => 'course_archive_number_of_columns',
				'type'          => 'select',
				'label'         => esc_html__( 'Number of Columns', 'eltdf-lms' ),
				'default_value' => '4',
				'description'   => esc_html__( 'Set number of columns for your course list on archive pages. Default value is 4 columns', 'eltdf-lms' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'2' => esc_html__( '2 Columns', 'eltdf-lms' ),
					'3' => esc_html__( '3 Columns', 'eltdf-lms' ),
					'4' => esc_html__( '4 Columns', 'eltdf-lms' ),
					'5' => esc_html__( '5 Columns', 'eltdf-lms' )
				)
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'          => 'course_archive_space_between_items',
				'type'          => 'select',
				'label'         => esc_html__( 'Space Between Items', 'eltdf-lms' ),
				'default_value' => 'normal',
				'description'   => esc_html__( 'Set space size between course items for your course list on archive pages. Default value is normal', 'eltdf-lms' ),
				'parent'        => $panel_archive,
				'options'       => esmarts_elated_get_space_between_items_array()
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'          => 'course_archive_image_size',
				'type'          => 'select',
				'label'         => esc_html__( 'Image Proportions', 'eltdf-lms' ),
				'default_value' => 'landscape',
				'description'   => esc_html__( 'Set image proportions for your course list on archive pages. Default value is landscape', 'eltdf-lms' ),
				'parent'        => $panel_archive,
				'options'       => array(
					'full'      => esc_html__( 'Original', 'eltdf-lms' ),
					'landscape' => esc_html__( 'Landscape', 'eltdf-lms' ),
					'portrait'  => esc_html__( 'Portrait', 'eltdf-lms' ),
					'square'    => esc_html__( 'Square', 'eltdf-lms' )
				)
			)
		);
		
		$panel = esmarts_elated_add_admin_panel(
			array(
				'title' => esc_html__( 'Course Single', 'eltdf-lms' ),
				'name'  => 'panel_course_single',
				'page'  => '_course'
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'type'          => 'select',
				'name'          => 'show_title_area_course_single',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will show title area on single courses', 'eltdf-lms' ),
				'parent'        => $panel,
				'options'       => esmarts_elated_get_yes_no_select_array(),
				'args'          => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'          => 'course_single_comments',
				'type'          => 'yesno',
				'label'         => esc_html__( 'Show Comments', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will show comments on your page', 'eltdf-lms' ),
				'parent'        => $panel,
				'default_value' => 'yes'
			)
		);
		
		esmarts_elated_add_admin_field(
			array(
				'name'        => 'course_single_slug',
				'type'        => 'text',
				'label'       => esc_html__( 'Course Single Slug', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter if you wish to use a different Single Course slug (Note: After entering slug, navigate to Settings -> Permalinks and click "Save" in order for changes to take effect)', 'eltdf-lms' ),
				'parent'      => $panel,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'esmarts_elated_action_options_map', 'eltdf_lms_course_options_map', 14 );
}