<div class="eltdf-ct-item <?php echo esc_attr($item_classes); ?>">
	<div class="eltdf-ct-item-inner">
		<div class="eltdf-cti-title">
			<span class="eltdf-cfi-title-label"><?php echo esc_attr( get_the_title() ); ?></span>
			<span class="eltdf-cfi-icon icon_star"></span>
		</div>
		<div class="eltdf-cti-category">
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/category', '', array('enable_category' => 'yes') ); ?>
		</div>
		<div class="eltdf-cti-instructor">
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/instructor', 'additional-image', array('enable_instructor' => 'yes') ); ?>
		</div>
		<div class="eltdf-cti-price">
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/price', '', array('enable_price' => 'yes') ); ?>
			<?php echo eltdf_lms_get_cpt_shortcode_module_template_part( 'course', 'parts/button', '', $params ); ?>
		</div>
	</div>
</div>