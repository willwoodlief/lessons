<?php if ( isset( $instructor ) & ! empty( $instructor ) ) {

	$instructors = ecomhub_fi_course_get_instructors();
	$instructors_caption = 'Instructors:';
	if (sizeof($instructors) === 1) {
		$instructors_caption = 'Instructor:';
    }
    ?>

    <div class="eltdf-grid-col-8">

        <div class="ecomhub-fi-instructors-table" style="display: table;width: 100%; float:none" >
            <div class="" style="display: table-row;" >
                <div class="" style="display:table-cell;vertical-align: top">
                     <span class="eltdf-instructor-label" style="padding-top: 12px;font-size: 18px; ">
                            <?php esc_html_e( $instructors_caption, 'eltdf-lms' ) ?>
                        </span>
                </div>
    <?php

    for($i = 0; $i < sizeof($instructors); $i ++) {
            $one_instructor = $instructors[$i];
        ?>

            <div class="ecomhub-fi-course-instructor" style="display: table-cell;margin-right: 1em">
                <div class="ecomhub-fi-instructor-image" style="height: 80px">
                    <a itemprop="url" href="<?php echo get_permalink( $one_instructor ); ?>" target="_self">
                      <?php echo get_the_post_thumbnail( $one_instructor, array( 80, 80 ) ); ?>
                    </a>
                </div>
                <div class="ecomhub-fi-instructor-info">
                    <a itemprop="url" href="<?php echo get_permalink( $one_instructor ); ?>" target="_self">
                        <span class="eltdf-instructor-name">
                            <?php echo explode(' ',trim(get_the_title( $one_instructor )))[0] ; ?>
                        </span>
                    </a>
                </div>
            </div>
    <?php } ?>
            </div>
        </div> <!-- ecomhub-fi-instructors-table -->
    </div> <!-- eltdf-grid-col-8 -->
<?php } ?>