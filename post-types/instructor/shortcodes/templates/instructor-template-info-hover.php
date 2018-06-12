<?php
$image_meta          = get_post_meta( get_the_ID(), 'eltdf_instructor_featured_image_meta', true );
$has_featured        = ! empty( $image_meta ) || get_the_post_thumbnail( $instructor_id ) !== '';
$instructor_image_id = ! empty( $image_meta ) ? esmarts_elated_get_attachment_id_from_url( $image_meta ) : '';
?>
<div class="eltdf-instructor eltdf-item-space <?php echo esc_attr( $instructor_layout ) ?>">
	<div class="eltdf-instructor-inner">
		<?php if ( $has_featured ) { ?>
			<div class="eltdf-instructor-image">
				<?php if ( ! empty( $instructor_image_id ) && $use_featured !== 'yes' ) {
					echo wp_get_attachment_image( $instructor_image_id, 'full' );
				} else {
					echo get_the_post_thumbnail( $instructor_id, 'full' );
				} ?>
				<div class="eltdf-instructor-info-wrapper">
					<div class="eltdf-instructor-info-tb">
						<div class="eltdf-instructor-info-tc">
							<div class="eltdf-instructor-title-holder">
								<h4 itemprop="name" class="eltdf-instructor-name entry-title">
									<a itemprop="url" href="<?php echo esc_url( get_the_permalink( $instructor_id ) ) ?>"><?php echo esc_html( $title ) ?></a>
								</h4>
								<?php if ( ! empty( $position ) ) { ?>
									<h6 class="eltdf-instructor-position"><?php echo esc_html( $position ); ?></h6>
								<?php } ?>
							</div>
							<div class="eltdf-instructor-social">
								<?php foreach ( $instructor_social_icons as $instructor_social_icon ) {
									echo wp_kses_post( $instructor_social_icon );
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>