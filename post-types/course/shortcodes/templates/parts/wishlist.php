<?php
$icon = eltdf_lms_is_course_in_wishlist() ? 'fa-heart-o' : 'fa-heart';
?>
<a href="javascript:void(0)" class="eltdf-course-wishlist eltdf-icon-only" data-course-id="<?php echo esc_attr( get_the_ID() ); ?>">
	<i class="fa <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
</a>