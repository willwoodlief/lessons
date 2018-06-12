<?php

if ( ! function_exists( 'eltdf_lms_map_course_meta' ) ) {
	function eltdf_lms_map_course_meta() {
		
		//Get list of courses;
		$eltd_courses = array();
		$courses      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'course',
				'post_status' => 'publish'
			)
		);
		foreach ( $courses as $course ) {
			$eltd_courses[ $course->ID ] = $course->post_title;
		}
		
		//Get list of instructors;
		$eltd_instructors = array();
		$instructors      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'instructor',
				'post_status' => 'publish'
			)
		);
		foreach ( $instructors as $instructor ) {
			$eltd_instructors[ $instructor->ID ] = $instructor->post_title;
		}
		
		if ( eltdf_lms_bbpress_plugin_installed() ) {
			//Get list of forums;
			$eltd_forums = array();
			$forums      = get_posts(
				array(
					'numberposts'         => - 1,
					'post_type'           => 'forum',
					'post_status'         => 'publish',
					'posts_per_page'      => get_option( '_bbp_forums_per_page', 50 ),
					'ignore_sticky_posts' => true,
					'orderby'             => 'menu_order title',
					'order'               => 'ASC'
				)
			);
			foreach ( $forums as $forum ) {
				$eltd_forums[ $forum->ID ] = $forum->post_title;
			}
		}
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'course',
				'title' => esc_html__( 'Course Settings', 'eltdf-lms' ),
				'name'  => 'course_settings_meta_box'
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_show_title_area_course_single_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Show Title Area', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will show title area on your single course page', 'eltdf-lms' ),
				'parent'        => $meta_box,
				'options'       => esmarts_elated_get_yes_no_select_array()
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_instructor_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Course Instructor', 'eltdf-lms' ),
				'description' => esc_html__( 'Select instructor for this course', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'options'     => $eltd_instructors,
				'args'        => array(
					'select2' => true
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Course Duration', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for course', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_curriculum_desc_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'General Curriculum Description', 'eltdf-lms' ),
				'description' => esc_html__( 'Set general description of course curriculum', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_course_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Course Duration Parameter', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose parameter for course duration', 'eltdf-lms' ),
				'default_value' => 'minutes',
				'parent'        => $meta_box,
				'options'       => array(
					''        => esc_html__( 'Default', 'eltdf-lms' ),
					'minutes' => esc_html__( 'Minutes', 'eltdf-lms' ),
					'hours'   => esc_html__( 'Hours', 'eltdf-lms' ),
					'days'    => esc_html__( 'Days', 'eltdf-lms' ),
					'weeks'   => esc_html__( 'Weeks', 'eltdf-lms' ),
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_maximum_students_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Maximum Students', 'eltdf-lms' ),
				'description' => esc_html__( 'Set maximal number of students', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_retake_number_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Re-Takes', 'eltdf-lms' ),
				'description' => esc_html__( 'Set maximal number of retakes', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_course_featured_meta',
				'type'          => 'yesno',
				'default_value' => 'no',
				'label'         => esc_html__( 'Featured Course', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enable this option to set course featured', 'eltdf-lms' ),
				'parent'        => $meta_box
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_prerequired_meta',
				'type'        => 'selectblank',
				'label'       => esc_html__( 'Pre-Required Course', 'eltdf-lms' ),
				'description' => esc_html__( 'Select course that needs to be completed before attending', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'options'     => $eltd_courses,
				'args'        => array(
					'select2' => true
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_passing_percentage_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Passing Percentage', 'eltdf-lms' ),
				'description' => esc_html__( 'Set value required to pass the course', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_course_free_meta',
				'type'          => 'select',
				'default_value' => '',
				'label'         => esc_html__( 'Free Course', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will set course to be free', 'eltdf-lms' ),
				'parent'        => $meta_box,
				'options'       => esmarts_elated_get_yes_no_select_array( false ),
				'args'          => array(
					'dependence' => true,
					'hide'       => array(
						'no'  => '',
						'yes' => '#eltdf_course_price_container'
					),
					'show'       => array(
						'no'  => '#eltdf_course_price_container',
						'yes' => ''
					)
				)
			)
		);
		
		$course_price_container = esmarts_elated_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'course_price_container',
				'parent'          => $meta_box,
				'hidden_property' => 'eltdf_course_free_meta',
				'hidden_values'   => array( 'yes' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_price_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Price', 'eltdf-lms' ),
				'description' => esc_html__( 'Set price for course', 'eltdf-lms' ),
				'parent'      => $course_price_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_course_price_discount_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Discount', 'eltdf-lms' ),
				'description' => esc_html__( 'Enter discount value for course', 'eltdf-lms' ),
				'parent'      => $course_price_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_course_members_meta',
				'type'          => 'yesno',
				'default_value' => 'yes',
				'label'         => esc_html__( 'Course Members', 'eltdf-lms' ),
				'description'   => esc_html__( 'Enabling this option will show all members that buy/start this course', 'eltdf-lms' ),
				'parent'        => $meta_box
			)
		);
		
		if ( eltdf_lms_bbpress_plugin_installed() ) {
			esmarts_elated_add_meta_box_field(
				array(
					'name'        => 'eltdf_course_forum_meta',
					'type'        => 'selectblank',
					'label'       => esc_html__( 'Course Forum', 'eltdf-lms' ),
					'description' => esc_html__( 'Select forum for this course', 'eltdf-lms' ),
					'parent'      => $meta_box,
					'options'     => $eltd_forums,
					'args'        => array(
						'select2' => true
					)
				)
			);
		}
		
		$meta_box_curriculum = esmarts_elated_add_meta_box(
			array(
				'scope' => 'course',
				'title' => esc_html__( 'Course Curriculum', 'eltdf-lms' ),
				'name'  => 'course_curriculum_meta_box'
			)
		);
		
		eltdf_lms_add_meta_box_course_items_field(
			array(
				'name'        => 'eltdf_course_curriculum',
				'label'       => esc_html__( 'Curriculum', 'eltdf-lms' ),
				'description' => esc_html__( 'Organize lessons and quizzes into sections.', 'eltdf-lms' ),
				'parent'      => $meta_box_curriculum
			)
		);
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_course_meta', 5 );
}