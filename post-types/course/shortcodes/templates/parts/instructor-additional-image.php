<?php
$instructor = get_post_meta( get_the_ID(), 'eltdf_course_instructor_meta', true );
$instructor_additional_image_meta = get_post_meta( $instructor, 'eltdf_instructor_featured_image_meta', true );
$instructor_additional_image_id = ! empty( $instructor_additional_image_meta ) ? esmarts_elated_get_attachment_id_from_url( $instructor_additional_image_meta ) : '';
?>
<a itemprop="url" href="<?php echo get_permalink( $instructor ); ?>" target="_self">
    <span class="eltdf-instructor-image">
	    <?php if ( ! empty( $instructor_additional_image_id ) ) {
		    echo wp_get_attachment_image( $instructor_additional_image_id, 'thumbnail' );
	    } else {
		    echo get_the_post_thumbnail( $instructor, array( 80, 80 ) );
	    } ?>
    </span>
	<span class="eltdf-instructor-name">
        <?php echo get_the_title( $instructor ); ?>
    </span>
</a>
