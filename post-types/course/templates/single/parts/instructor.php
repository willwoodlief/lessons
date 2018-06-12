<?php if ( isset( $instructor ) & ! empty( $instructor ) ) { ?>
	<div class="eltdf-grid-col-4">
		<div class="eltdf-course-instructor">
			<div class="eltdf-instructor-image">
				<?php echo get_the_post_thumbnail( $instructor, array( 80, 80 ) ); ?>
			</div>
			<div class="eltdf-instructor-info">
	            <span class="eltdf-instructor-label">
	                <?php esc_html_e( 'Instructor:', 'eltdf-lms' ) ?>
	            </span>
				<a itemprop="url" href="<?php echo get_permalink( $instructor ); ?>" target="_self">
	                <span class="eltdf-instructor-name">
	                    <?php echo get_the_title( $instructor ); ?>
	                </span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>