<?php if ( comments_open() ) { ?>
	<div class="eltdf-grid-col-4">
		<div class="eltdf-course-reviews">
			<div class="eltdf-course-reviews-label" style="font-size: 18px">
				<?php esc_html_e( 'Reviews:', 'eltdf-lms' ) ?>
			</div>
			<span class="eltdf-course-stars">
	            <?php
	            $review_rating = eltdf_lms_course_average_rating();
	            for ( $i = 1; $i <= $review_rating; $i ++ ) { ?>
		            <i class="fa fa-star" aria-hidden="true"></i>
	            <?php } ?>
			</span>
			<!-- This should change to open tab -->
			<a itemprop="url" class="eltdf-post-info-comments" href="<?php comments_link(); ?>" target="_self">
				<?php comments_number( '0 ' . esc_html__( 'Reviews', 'eltdf-lms' ), '1 ' . esc_html__( 'Review', 'eltdf-lms' ), '% ' . esc_html__( 'Reviews', 'eltdf-lms' ) ); ?>
			</a>
		</div>
	</div>
<?php } ?>