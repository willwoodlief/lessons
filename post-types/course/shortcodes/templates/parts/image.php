<?php
$thumb_size = $this_object->getImageSize( $params );
?>
<div class="eltdf-cli-image">
	<?php if ( has_post_thumbnail() ) { ?>
		<a itemprop="url" href="<?php echo esc_url( get_the_permalink( get_the_ID() ) ); ?>">
			<?php echo get_the_post_thumbnail( get_the_ID(), $thumb_size ); ?>
		</a>
	<?php } else { ?>
		<img itemprop="image" class="eltdf-cl-original-image" width="800" height="600" src="<?php echo ELATED_LMS_CPT_URL_PATH . '/course/assets/img/course_featured_image.jpg'; ?>" alt="<?php esc_html_e( 'Course Featured Image', 'eltdf-lms' ); ?>"/>
	<?php } ?>
</div>