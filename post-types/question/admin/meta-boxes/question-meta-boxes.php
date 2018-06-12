<?php

if ( ! function_exists( 'eltdf_lms_map_question_meta' ) ) {
	function eltdf_lms_map_question_meta() {
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'question',
				'title' => esc_html__( 'Question Settings', 'eltdf-lms' ),
				'name'  => 'question_settings_meta_box'
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_question_description_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Question Description', 'eltdf-lms' ),
				'description' => esc_html__( 'Set duration for question', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'          => 'eltdf_question_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Question Type', 'eltdf-lms' ),
				'description'   => esc_html__( 'Choose type for question', 'eltdf-lms' ),
				'default_value' => 'multi_choice',
				'parent'        => $meta_box,
				'options'       => array(
					'multi_choice'  => esc_html__( 'Multi Choice', 'eltdf-lms' ),
					'single_choice' => esc_html__( 'Single Choice', 'eltdf-lms' ),
					'text'          => esc_html__( 'Text', 'eltdf-lms' ),
				),
				'args'          => array(
					'dependence'      => true,
					'hide'            => array(
						'multi_choice'  => '#eltdf_answers_holder_text_section_container',
						'single_choice' => '#eltdf_answers_holder_text_section_container',
						'text'          => '#eltdf_answers_holder_choices_section_container'
					),
					'show'            => array(
						'multi_choice'  => '#eltdf_answers_holder_choices_section_container',
						'single_choice' => '#eltdf_answers_holder_choices_section_container',
						'text'          => '#eltdf_answers_holder_text_section_container'
					),
					'use_as_switcher' => true,
					'switch_type'     => 'single_yesno',
					'switch_property' => 'eltdf_question_answer_true_meta',
					'switch_enabled'  => 'single_choice'
				)
			)
		);
		
		//Choice Type
		$question_answers_single_container = esmarts_elated_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'answers_holder_choices_section_container',
				'parent'          => $meta_box,
				'hidden_property' => 'eltdf_question_type_meta',
				'hidden_values'   => array( 'text' )
			)
		);
		
		esmarts_elated_add_table_repeater_field(
			array(
				'name'        => 'eltdf_answers_list_meta',
				'parent'      => $question_answers_single_container,
				'button_text' => '',
				'fields'      => array(
					array(
						'type'        => 'text',
						'name'        => 'eltdf_question_answer_title_meta',
						'label'       => '',
						'th'          => esc_html__( 'Answer text', 'eltdf-lms' )
					),
					array(
						'type'          => 'yesno',
						'name'          => 'eltdf_question_answer_true_meta',
						'default_value' => 'no',
						'label'         => '',
						'th'            => esc_html__( 'Correct?', 'eltdf-lms' )
					)
				)
			)
		);
		
		//Text Type
		$question_answers_text_container = esmarts_elated_add_admin_container(
			array(
				'type'            => 'container',
				'name'            => 'answers_holder_text_section_container',
				'parent'          => $meta_box,
				'hidden_property' => 'eltdf_question_type_meta',
				'hidden_values'   => array( 'single_choice', 'multi_choice' )
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_answers_text_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Answer', 'eltdf-lms' ),
				'parent'      => $question_answers_text_container,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_question_mark_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Question Mark', 'eltdf-lms' ),
				'description' => esc_html__( 'Set mark that is given for correct answer', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
		
		esmarts_elated_add_meta_box_field(
			array(
				'name'        => 'eltdf_question_hint_meta',
				'type'        => 'textarea',
				'label'       => esc_html__( 'Question Hint', 'eltdf-lms' ),
				'description' => esc_html__( 'Set Hint that can be displayed to student', 'eltdf-lms' ),
				'parent'      => $meta_box,
				'args'        => array(
					'col_width' => 3
				)
			)
		);
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_question_meta', 5 );
}