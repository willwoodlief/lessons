<div class="eltdf-course-reviews-main-title">
	<h4><?php esc_html_e( 'Reviews', 'eltdf-lms' ) ?></h4>
	<p><?php esc_html_e( 'Our course begins with the first step for generating great user experiences: understanding what people do, think, say, and feel. In this module, you’ll learn how to keep an open mind while learning.', 'eltdf-lms' ); ?></p>
</div>

<div class="eltdf-course-reviews-list-top">
	<div class="eltdf-grid-row">
		<div class="eltdf-grid-col-4">
			<div class="eltdf-course-reviews-number-wrapper">
				<div class="eltdf-course-reviews-number-inner">
					<span class="eltdf-course-reviews-number"><?php echo eltdf_lms_course_average_rating(); ?></span>
					<span class="eltdf-course-stars-wrapper">
						<span class="eltdf-course-stars">
							<?php
							$review_rating = eltdf_lms_course_average_rating();
							for ( $i = 1; $i <= $review_rating; $i ++ ) { ?>
								<i class="fa fa-star" aria-hidden="true"></i>
							<?php } ?>
						</span>
						<span class="eltdf-course-reviews-count">
							<?php echo esc_html__( 'Rated', 'eltdf-lms' ) . ' ' . eltdf_lms_course_average_rating() . ' ' . esc_html__( 'out of', 'eltdf-lms' ) . ' ';
							comments_number( '0 ' . esc_html__( 'Ratings', 'eltdf-lms' ), '1 ' . esc_html__( 'Rating', 'eltdf-lms' ), '% ' . esc_html__( 'Ratings', 'eltdf-lms' ) ); ?>
						</span>
					</span>
				</div>
			</div>
		</div>
		<div class="eltdf-grid-col-8">
			<div class="eltdf-course-rating-percente-wrapper">
				<?php $ratings_array = eltdf_lms_course_ratings();
				$number              = eltdf_lms_course_number_of_ratings();
				foreach ( $ratings_array as $item => $value ) {
					$percentage = $number == 0 ? 0 : round( ( $value / $number ) * 100 );
					echo do_shortcode( '[eltdf_progress_bar percent="' . $percentage . '" title="' . $item . esc_html__( ' stars', 'eltdf-lms' ) . '"]' );
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="eltdf-course-reviews-list">
	<?php comments_template( '/review-comments.php', true ); ?>
</div>