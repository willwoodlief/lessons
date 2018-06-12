<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/image', $item_layout, $params ); ?>

<div class="eltdf-cli-text-holder">
	<div class="eltdf-cli-text-inner">
		<div class="eltdf-cli-text-inner-2">
			<?php if ( $course_slider_on === 'yes' && $enable_category == 'yes' ) {
				echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/category', $item_layout, $params );
			} ?>
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/title', $item_layout, $params ); ?>
			<div class="eltdf-cli-top-info">
				<?php if ( $enable_instructor == 'yes' ) {
					echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/instructor-simple', $item_layout, $params );
				} ?>
				<?php if ( $course_slider_on !== 'yes' && $enable_category == 'yes' ) {
					echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/category', $item_layout, $params );
				} ?>
			</div>
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/excerpt', $item_layout, $params ); ?>
			<div class="eltdf-cli-bottom-info">
				<?php if ( $enable_students == 'yes' ) {
					echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/students', $item_layout, $params );
				} ?>
				<?php if ( $enable_ratings == 'yes' ) {
					echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/ratings', $item_layout, $params );
				} ?>
				<?php if ( $enable_price == 'yes' ) {
					echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/price', $item_layout, $params );
				} ?>
			</div>
		</div>
	</div>
</div>