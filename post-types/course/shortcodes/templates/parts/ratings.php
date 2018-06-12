<?php
$review_rating = eltdf_lms_course_average_rating();
?>
<div class="eltdf-course-ratings">
	<span class="eltdf-course-rating-icon"></span>
	<span class="eltdf-course-rating-label">
		<?php echo esc_html($review_rating); ?>
		<?php esc_html_e( 'Ratings', 'eltdf-lms' ) ?>
	</span>
</div>