<div class="eltdf-container">
	<div class="eltdf-container-inner clearfix">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="eltdf-course-single-holder">
				<?php if ( post_password_required() ) {
					echo get_the_password_form();
				} ?>
				<div class="eltdf-grid-row eltdf-grid-large-gutter">
					<div <?php echo esmarts_elated_get_content_sidebar_class(); ?>>
						<div class="eltdf-course-single-outer">
							<?php
							do_action( 'esmarts_elated_action_course_page_before_content' );
							
							eltdf_lms_get_cpt_single_module_template_part( 'templates/single/layout-collections/default', 'course', '', $params );
							
							do_action( 'esmarts_elated_action_course_page_after_content' );
							?>
						</div>
					</div>
					<?php if ( $sidebar_layout !== 'no-sidebar' ) { ?>
						<div <?php echo esmarts_elated_get_sidebar_holder_class(); ?>>
							<?php get_sidebar(); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
</div>
<?php do_action( 'eltdf_lms_course_popup' ); ?>