<div class="eltdf-lms-lesson-content-wrapper">
	<div class="eltdf-lms-lesson-title">
		<?php eltdf_lms_get_cpt_single_module_template_part( 'templates/single/parts/title', 'lesson', '', $params ); ?>
	</div>
	<div class="eltdf-lms-lesson-content">
		<?php the_content(); ?>
	</div>
	<div class="eltdf-lms-lesson-complete">
		<?php echo eltdf_lms_complete_button( $params ); ?>
	</div>
</div>