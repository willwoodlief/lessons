<?php
$image_meta          = get_post_meta( get_the_ID(), 'eltdf_instructor_featured_image_meta', true );
$has_featured        = ! empty( $image_meta ) || get_the_post_thumbnail( $instructor_id ) !== '';
$instructor_image_id = ! empty( $image_meta ) ? esmarts_elated_get_attachment_id_from_url( $image_meta ) : '';
?>
<div class="eltdf-instructor eltdf-item-space <?php echo esc_attr( $instructor_layout ) ?>">
	<div class="eltdf-instructor-inner">
		<?php if ( $has_featured ) { ?>
			<div class="eltdf-instructor-image">
				<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>">
					<?php if ( ! empty( $instructor_image_id ) && $use_featured !== 'yes' ) {
						echo wp_get_attachment_image( $instructor_image_id, 'full' );
					} else {
						echo get_the_post_thumbnail( $instructor_id, 'full' );
					} ?>
				</a>
			</div>
		<?php } ?>
	</div>
</div>