<?php if ( comments_open() ) { ?>

    <?php
        $divider_style = '';
        if ( eltdf_lms_is_woocommerce_installed() ) {
	        $user_has_course = eltdf_lms_user_has_course();
	        $user_completed_prerequired = eltdf_lms_user_completed_prerequired_course();
	        if ($user_has_course && $user_completed_prerequired) {
		        $divider_style = 'border-right: 1px solid #ebebeb';
            }
        }
    ?>
    <div class="eltdf-grid-col-4">
		<div class="eltdf-course-reviews" style="<?php echo $divider_style?>">
			<div class="eltdf-course-reviews-label" >
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