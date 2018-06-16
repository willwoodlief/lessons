<?php
$boost = intval(get_post_meta( get_the_ID(), 'ecomhub_fi_membership_base', true ));

$students        = get_post_meta( get_the_ID(), 'eltdf_course_users_attended', true );
if (empty($students)) {
    $students_number = $boost;
} else {
	$students_number = count( $students ) + $boost;
}

?>
<div class="eltdf-students-number-holder">
	<span class="eltdf-student-icon"></span>
	<span class="eltdf-student-label">
		<?php echo esc_html( $students_number ); ?>
		<?php esc_html_e( 'Students', 'eltdf-lms' ) ?>
	</span>
</div>
