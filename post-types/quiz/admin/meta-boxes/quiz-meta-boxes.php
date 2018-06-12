<?php

if ( ! function_exists( 'eltdf_lms_map_quiz_meta' ) ) {
	function eltdf_lms_map_quiz_meta() {
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'quiz',
				'name'  => 'quiz_settings_meta_box',
				'title' => esc_html__( 'Quiz Settings', 'eltdf-lms' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_quiz_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Quiz Description', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for quiz', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_quiz_duration_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Quiz Duration', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for quiz', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_quiz_duration_parameter_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Quiz Duration Parameter', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose parameter for quiz duration', 'eltdf-lms' ),
				'default_value' => 'minutes',
				'parent'        => $meta_box,
				'options'       => array(
					'seconds' => esc_html__( 'Seconds', 'eltdf-lms' ),
					'minutes' => esc_html__( 'Minutes', 'eltdf-lms' ),
					'hours'   => esc_html__( 'Hours', 'eltdf-lms' )
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_quiz_number_retakes_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Number of Retakes', 'eltdf-lms' ),
				'description' => esc_html__( 'Set allowed number of quiz retakes.', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_quiz_passing_percentage_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Passing Percentage', 'eltdf-lms' ),
				'description' => esc_html__( 'Set value required to pass the quiz', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_quiz_post_message_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Quiz Post Message', 'eltdf-lms' ),
				'description' => esc_html__( 'Set message that will be displayed after the quiz is completed', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_quiz_meta', 5 );
}