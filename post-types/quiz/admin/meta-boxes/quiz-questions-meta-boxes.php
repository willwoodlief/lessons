<?php

if ( ! function_exists( 'eltdf_lms_map_quiz_questions_meta' ) ) {
	function eltdf_lms_map_quiz_questions_meta() {
		
		$eltd_questions = array();
		$questions      = get_posts(
			array(
				'numberposts' => - 1,
				'post_type'   => 'question',
				'post_status' => 'publish'
			)
		);
		foreach ( $questions as $question ) {
			$eltd_questions[ $question->ID ] = $question->post_title;
		}
		
		$meta_box = esmarts_elated_add_meta_box(
			array(
				'scope' => 'quiz',
				'title' => esc_html__( 'Quiz Questions', 'eltdf-lms' ),
				'name'  => 'quiz_questions_meta_box'
			)
		);
		
		esmarts_elated_add_table_repeater_field( array(
				'name'        => 'eltdf_quiz_question_list_meta',
				'parent'      => $meta_box,
				'button_text' => esc_html__( 'Add Question', 'eltdf-lms' ),
				'fields'      => array(
					array(
						'name'        => 'eltdf_quiz_question_meta',
						'type'        => 'select',
						'label'       => '',
						'description' => '',
						'parent'      => $meta_box,
						'options'     => $eltd_questions,
						'args'        => array(
							'select2'  => true,
							'colWidth' => 12
						),
						'th'          => esc_html__( 'Question', 'eltdf-lms' )
					)
				)
			)
		);
	}
	
	add_action( 'esmarts_elated_action_meta_boxes_map', 'eltdf_lms_map_quiz_questions_meta', 4 );
}