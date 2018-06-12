<?php
$user_favorites = get_user_meta( get_current_user_id(), 'eltdf_course_wishlist', true );
?>
<div class="eltdf-lms-profile-favorites-holder">
	<?php if ( ! empty( $user_favorites ) ) { ?>
		<?php
		foreach ( $user_favorites as $user_favorite ) { ?>
			<div class="eltdf-lms-profile-favorite-item">
				<div class="eltdf-lms-profile-favorite-item-image">
					<?php
					if ( has_post_thumbnail( $user_favorite ) ) {
						$image = get_the_post_thumbnail_url( $user_favorite, 'thumbnail' );
					} else {
						$image = ELATED_LMS_CPT_URL_PATH . '/course/assets/img/course_featured_image.jpg';
					}
					?>
					<img src="<?php echo esc_attr( $image ); ?>" alt="<?php echo esc_attr( 'Course thumbnail', 'eltdf-lms' ) ?>"/>
				</div>
				<div class="eltdf-lms-profile-favorite-item-title">
					<h4>
						<a href="<?php echo get_the_permalink( $user_favorite ); ?>">
							<?php echo get_the_title( $user_favorite ); ?>
						</a>
						<?php
						$icon = eltdf_lms_is_course_in_wishlist( $user_favorite ) ? 'fa-heart' : 'fa-heart-o';
						?>
						<a href="javascript:void(0)" class="eltdf-course-whishlist eltdf-icon-only" data-course-id="<?php echo esc_attr( $user_favorite ); ?>">
							<i class="fa <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
						</a>
					</h4>
				</div>
			</div>
			<?php
		}
	} else { ?>
		<h3><?php esc_html_e( "Your favorites list is empty.", "eltdf-lms" ) ?> </h3>
	<?php } ?>
</div>