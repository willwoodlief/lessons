<?php
$items      = eltdf_lms_course_items_list_array( $course_id );
$current_id = ( array_search( $item_id, $items ) );

$prev_item_id = ( array_key_exists( $current_id - 1, $items ) ) ? $items[ $current_id - 1 ] : '';
$next_item_id = ( array_key_exists( $current_id + 1, $items ) ) ? $items[ $current_id + 1 ] : '';
$section_lookup = ecomhub_fi_course_items_section_lookup($course_id);
$prev_section = $section_lookup[$prev_item_id];
$next_section = $section_lookup[$next_item_id];
$course_sections = get_post_meta( $course_id, 'eltdf_course_curriculum', true );
$unlocks = ecomhub_fi_user_section_progress(get_current_user_id(),$course_id,$course_sections);
$prev_unlock = $unlocks[$prev_section];
if ( $prev_unlock &&  $prev_unlock['is_locked']) {
	$prev_item_id = '';
}
$next_unlock = $unlocks[$next_section];
if ( $next_unlock &&   $next_unlock['is_locked'] ){
	$next_item_id = '';
}
?>
<div class="eltdf-course-popup-navigation">
	<div class="eltdf-course-popup-navigation-inner">
		<div class="eltdf-course-popup-prev">
			<?php if ( ! empty( $prev_item_id ) ) { ?>
                <!-- todo next course link -->
				<a href="<?php echo get_permalink( $prev_item_id ); ?>" class="eltdf-element-link-open" title="<?php echo get_the_title( $prev_item_id ); ?>" data-item-id="<?php echo esc_attr( $prev_item_id ); ?>" data-course-id="<?php echo esc_attr( $course_id ); ?>">
					<span class="eltdf-course-popup-nav-label"><?php esc_html_e( 'Previous', 'eltdf-lms' ); ?></span>
					<span class="eltdf-course-popup-nav-title"><?php echo get_the_title( $prev_item_id ); ?></span>
				</a>
			<?php } ?>
		</div>
		<div class="eltdf-course-popup-next">
			<?php if ( ! empty( $next_item_id ) ) { ?>
                <!-- todo prev course link , here-->
				<a href="<?php echo get_permalink( $next_item_id ); ?>" class="eltdf-element-link-open" title="<?php echo get_the_title( $next_item_id ); ?>" data-item-id="<?php echo esc_attr( $next_item_id ); ?>" data-course-id="<?php echo esc_attr( $course_id ); ?>">
					<span class="eltdf-course-popup-nav-label"><?php esc_html_e( 'Next', 'eltdf-lms' ); ?></span>
					<span class="eltdf-course-popup-nav-title"><?php echo get_the_title( $next_item_id ); ?></span>
				</a>
			<?php } ?>
		</div>
	</div>
</div>