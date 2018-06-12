<?php
if ( eltdf_lms_user_has_course() ) {
	$user_current_course_status = eltdf_lms_user_current_course_status();
	if ( $user_current_course_status == 'completed' ) {
		$button_text = esc_html__( 'Retake', 'eltdf-lms' );
	} else if ( $user_current_course_status == 'in-progress' ) {
		$button_text = esc_html__( 'Resume', 'eltdf-lms' );
	} else {
		$button_text = esc_html__( 'Start ', 'eltdf-lms' );
	}
} else {
	$button_text = esc_html__( 'Enroll', 'eltdf-lms' );
}
?>
<?php if ( eltdf_lms_core_plugin_installed() ) {
	?>
	<?php echo esmarts_elated_get_button_html( array(
		'text'              => $button_text,
		'link'              => get_the_permalink(),
		'type'              => 'solid',
		'size'              => 'small',
        'hover_animation'   => 'yes',
	) ); ?>
<?php } else { ?>
	<a href="<?php echo get_the_permalink(); ?>" class="eltdf-btn eltdf-btn-small eltdf-btn-solid"><?php echo esc_html( $button_text ); ?></a>
<?php } ?>