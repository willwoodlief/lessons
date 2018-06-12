<?php
$students        = get_post_meta( get_the_ID(), 'eltdf_course_users_attended', true );
$students_number = count( $students );
?>
<div class="eltdf-students-number-holder">
	<span class="eltdf-student-icon"></span>
	<span class="eltdf-student-label">
		<?php echo esc_html( $students_number ); ?>
		<?php esc_html_e( 'Students', 'eltdf-lms' ) ?>
	</span>
</div>
