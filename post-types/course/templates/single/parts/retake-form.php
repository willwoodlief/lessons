<form action="" method="post" class="eltdf-lms-retake-course-form">
	<input type="hidden" name="eltdf_lms_course_id" value="<?php echo get_the_ID(); ?>"/>
	<?php if ( eltdf_lms_core_plugin_installed() ) { ?>
		<?php echo esmarts_elated_get_button_html( array(
			'html_type'  => 'input',
			'text'       => esc_html__( 'Retake', 'eltdf-lms' ),
			'input_name' => 'submit'
		) ); ?>
	<?php } else { ?>
		<input name="submit" type="submit" value="<?php echo esc_html__( 'Retake', 'eltdf-lms' ); ?>"/>
	<?php } ?>
</form>
