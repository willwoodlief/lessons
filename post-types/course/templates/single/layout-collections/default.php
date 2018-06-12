<div class="eltdf-course-single-wrapper">
	<div class="eltdf-course-title-wrapper">
		<div class="eltdf-course-left-section">
			<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'course', '', $params ); ?>
			<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/course-type', 'course', '', $params ); ?>
		</div>
		<div class="eltdf-course-right-section">
			<?php eltdf_lms_get_wishlist_button(); ?>
		</div>
	</div>
	<div class="eltdf-course-basic-info-wrapper">
		<div class="eltdf-grid-row">
			<div class="eltdf-grid-col-9">
				<div class="eltdf-grid-row">
					<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/instructor', 'course', '', $params ); ?>
					<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/categories', 'course', '', $params ); ?>
					<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/reviews', 'course', '', $params ); ?>
				</div>
			</div>
			<div class="eltdf-grid-col-3">
				<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/action', 'course', '', $params ); ?>
			</div>
		</div>
	</div>
	<div class="eltdf-course-image-wrapper">
		<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/image', 'course', '', $params ); ?>
	</div>
	<div class="eltdf-course-tabs-wrapper">
		<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/tabs', 'course', '', $params ); ?>
	</div>
</div>