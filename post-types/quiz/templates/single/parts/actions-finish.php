<form action='' method='post' class="eltdf-lms-finish-quiz-form">
	<input type='hidden' name='eltdf_lms_questions' value='<?php echo esc_attr( $questions ); ?>'/>
	<input type='hidden' name='eltdf_lms_question_id' value='<?php echo esc_attr( $question_id ); ?>'/>
	<input type='hidden' name='eltdf_lms_quiz_id' value='<?php echo esc_attr( $quiz_id ); ?>'/>
	<input type='hidden' name='eltdf_lms_course_id' value='<?php echo esc_attr( $course_id ); ?>'/>
	<input type='hidden' name='eltdf_lms_retake_id' value='<?php echo esc_attr( $retake ); ?>'/>
	<input type='hidden' name='eltdf_lms_question_answer' value='<?php echo esc_attr( $value ); ?>'/>
	<div class="eltdf-question-actions">
		<?php
		echo esmarts_elated_get_button_html(
			array(
				'custom_class' => 'eltdf-quiz-finish',
				'html_type'    => 'input',
				'input_name'   => 'submit',
				'size'         => 'medium',
				'text'         => esc_html__( 'Finish', 'eltdf-lms' )
			)
		);
		?>
	</div>
</form>