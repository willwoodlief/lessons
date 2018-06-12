<form action='' method='post' class="eltdf-lms-start-quiz-form">
	<input type='hidden' name='eltdf_lms_questions' value='<?php echo esc_attr( $questions ); ?>'/>
	<input type='hidden' name='eltdf_lms_quiz_id' value='<?php echo esc_attr( get_the_ID() ); ?>'/>
	<input type='hidden' name='eltdf_lms_course_id' value='<?php echo esc_attr( $course_id ); ?>'/>
	<input type='hidden' name='eltdf_lms_retake_id' value='<?php echo esc_attr( $retakes_taken ); ?>'/>
	<?php if ( eltdf_lms_core_plugin_installed() ) { ?>
		<?php echo esmarts_elated_get_button_html(
			array(
				'html_type'    => 'input',
				'input_name'   => 'submit',
				'size'         => 'medium',
				'text'         => $button_text,
				'custom_attrs' => $custom_attrs
			)
		); ?>
	<?php } else { ?>
		<input name="submit" type="submit" value="<?php echo esc_html( $button_text ); ?>" <?php echo esc_attr( $disabled ); ?> />
	<?php } ?>
</form>