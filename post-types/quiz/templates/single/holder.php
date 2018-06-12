<?php
$args = array(
	'p'         => $item_id,
	'post_type' => 'quiz'
);

$quiz_query = new WP_Query( $args ); ?>
<?php if ( $quiz_query->have_posts() ) : while ( $quiz_query->have_posts() ) : $quiz_query->the_post(); ?>
	<div class="eltdf-quiz-single-holder">
		<?php if ( post_password_required() ) {
			echo get_the_password_form();
		} else {
			do_action( 'esmarts_elated_action_quiz_page_before_content' );
			
			eltdf_lms_get_cpt_single_module_template_part( 'templates/single/layout-collections/default', 'quiz', '', $params );
			
			do_action( 'esmarts_elated_action_quiz_page_after_content' );
		} ?>
	</div>
<?php endwhile; endif;

wp_reset_postdata(); ?>
