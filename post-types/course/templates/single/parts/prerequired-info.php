<?php if ( isset( $prerequired ) && ! empty( $prerequired ) ) { ?>
	<div class="eltdf-course-prerequired-info">
		<a itemprop="url" target="_self" href="<?php the_permalink( $prerequired ); ?>"><?php echo esc_html__( 'Course', 'eltdf-lms' ) . ' ' . get_the_title( $prerequired ) . ' ' . esc_html__( 'must be completed first', 'eltdf-lms' ); ?></a>
	</div>
<?php } ?>