<?php if ( isset( $instructor ) & ! empty( $instructor ) ) {

	$instructors = ecomhub_fi_course_get_instructors();
	$instructors_caption = 'Instructors:';
	if (sizeof($instructors) === 1) {
		$instructors_caption = 'Instructor:';
    }


	$instructor_parts = [];
    for($i = 0; $i < sizeof($instructors); $i ++) {
	    $one_instructor = $instructors[ $i ];

	    $name = explode(' ',trim(get_the_title( $one_instructor )))[0];
	    $link = get_permalink( $one_instructor );
	    $instructor_parts[] = "<a itemprop='url' href='$link' target='_self'>$name</a>";
    }
    ?>

    <div class="eltdf-grid-col-5">



        <div class="eltdf-course-instructor">
            <div class="eltdf-instructor-image">
                <img src="<?php echo plugin_dir_url( realpath(dirname( __FILE__ ). '../..') ) . 'eltdf-lms/assets/img/instructors-image.png'; ?>">

            </div>
            <div class="eltdf-instructor-info">
	            <span class="eltdf-instructor-label">
	                <?php esc_html_e( $instructors_caption, 'eltdf-lms' ) ?>
	            </span>

	                <span class="eltdf-instructor-name">
	                    <?php echo implode(", ",$instructor_parts) ?>
	                </span>

            </div>
        </div>


    </div> <!-- eltdf-grid-col-6 -->
<?php } ?>



