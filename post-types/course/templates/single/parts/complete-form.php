<form action="" method="post" class="eltdf-lms-complete-item-form">
	<input type="hidden" name="eltdf_lms_course_id" value="<?php echo esc_attr( $course_id ) ?>"/>
	<input type="hidden" name="eltdf_lms_item_id" value="<?php echo esc_attr( $item_id ) ?>"/>
	<?php if ( eltdf_lms_core_plugin_installed() ) { ?>
		<?php echo esmarts_elated_get_button_html( array(
			'html_type'  => 'input',
			'text'       => esc_html__( 'Complete', 'eltdf-lms' ),
			'input_name' => 'submit'
		) ); ?>
	<?php } else { ?>
		<input name="submit" type="submit" value="<?php echo esc_html__( 'Complete', 'eltdf-lms' ); ?>"/>
	<?php } ?>
</form>
