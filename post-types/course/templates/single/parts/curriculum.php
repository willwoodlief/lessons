<?php
$course_sections = get_post_meta(get_the_ID(), 'eltdf_course_curriculum', true);
$course_curriculum_desc = get_post_meta(get_the_ID(), 'eltdf_course_curriculum_desc_meta', true);
if(!empty($course_sections)) {
    $unlocks = ecomhub_fi_user_section_progress();
    $section_counter = 0;
    ?>
    <div class="eltdf-course-curriculum">
        <div class="eltdf-curriculum-description">
            <h4 class="eltdf-curriculum-title"><?php esc_html_e('Syllabus', 'eltdf-lms'); ?></h4>
            <p><?php echo esc_attr( $course_curriculum_desc); ?></p>
        </div>
        <div class="eltdf-course-curriculum-list">
            <?php foreach($course_sections as $course_section) {                ?>
                <div class="eltdf-curriculum-section" style="position: relative;z-index: 1">   <!--todo head of section -->
                    <?php if ( ($unlocks['last_unlocked_section'] >= 0) && ($section_counter > $unlocks['last_unlocked_section'])) { ?>
                        <div class="ecomhub-fi-locked-section" style="z-index: 999998;position: absolute;width: 100%;height: 100%; top:0;left: 0; background-color: transparent; opacity: 0.25" data-section="<?=$section_counter?>" data-oo="curriculum"></div>
                        <div class="ecomhub-fi-locked-description" style="z-index: 999999;position: absolute;width: 6em;height: 6em; top:40%;left: 40% ">
                            <div style="text-align: center;padding: 0.5em;background-color: #fbfbfb">
                                <span class="ecomhub-fi-lock-image fa fa-lock" style="color:#3A4242;font-size: 3em"></span>
                                <br>
                                <span class="ecomhub-fi-lock-human-span" style="color: black"><?= $unlocks['human'][$section_counter-1] ?></span>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                    <h4 class="eltdf-section-name">
                        <?php echo esc_html($course_section['section_name']) ?>
	                    
	                    <?php if (isset($course_section['section_elements']) && $course_section['section_elements'] !== '') {
	                        $sectionElements = $course_section['section_elements'];
	
	                        if ( ! empty( $sectionElements ) ) {
		                        $lists = eltdf_lms_get_course_curriculum_list( $sectionElements );
		                        $number_of_elements = count($lists['elements']);
		                        ?>
	                            <span class="eltdf-section-name-lessons"><?php echo esc_html_e('0/', 'eltdf-lms') . esc_attr($number_of_elements); ?></span>
	                        <?php
	                        }
                        } ?>
                    </h4>
                    <div class="eltdf-section-content">
                        <h5 class="eltdf-section-title">
                            <?php echo esc_html($course_section['section_title']) ?>
                        </h5>
                        <p class="eltdf-section-description">
                            <?php echo esc_html($course_section['section_description']) ?>
                        </p>
                        <?php
                        if (isset($course_section['section_elements']) && $course_section['section_elements'] !== ''){
                            $section_elements = $course_section['section_elements'];
                            if(!empty($section_elements)) {
                                $list = eltdf_lms_get_course_curriculum_list($section_elements);
                                $elements = $list['elements'];
                                $lessons_summary = $list['lessons_summary'];
                                ?>
                                <div class="eltdf-section-elements">
                                    <?php if(!empty($lessons_summary)) {
                                        $lesson_info = implode(', ', $lessons_summary);
                                    ?>
                                        <div class="eltdf-section-elements-summary">
                                            <i class="lnr lnr-book" aria-hidden="true"></i>
	                                        <span class="eltdf-summary-value"><?php echo esc_html($lesson_info); ?></span>
                                        </div>
                                    <?php } ?>
                                    <?php foreach ($elements as $key => $element) {	?>
                                        <div class="eltdf-section-element <?php echo esc_attr($element['class']); ?> clearfix <?php echo eltdf_lms_get_course_item_completed_class($element['id']); ?>" data-section-element-id="<?php echo esc_attr($element['id']); ?>">
                                            <div class="eltdf-element-title">
                                                <span class="eltdf-element-icon">
                                                    <?php print $element['icon']; ?>
                                                </span>
	                                            <span class="eltdf-element-label">
                                                    <?php echo esc_attr( $element['label'] ); ?>
                                                </span>

                                                <!-- todo preview course link in curriculum -->
	                                            <?php if ( eltdf_lms_course_is_preview_available( $element['id'] )  && ( ($unlocks['last_unlocked_section'] >= 0) && ($section_counter <= $unlocks['last_unlocked_section']))) { ?>
		                                            <a class="eltdf-element-name eltdf-element-link-open" itemprop="url" href="<?php echo esc_attr( $element['url'] ); ?>" title="<?php echo esc_attr( $element['title'] ); ?>" data-item-id="<?php echo esc_attr( $element['id'] ); ?>" data-course-id="<?php echo get_the_ID(); ?>">
			                                            <?php echo esc_html( $element['title'] ); ?>
			                                            <?php if ( ! eltdf_lms_user_has_course() || ! eltdf_lms_user_completed_prerequired_course() ) { ?>
				                                            <span class="eltdf-element-preview-holder"><?php esc_html_e( 'preview', 'eltdf-lms' ); ?></span>
			                                            <?php } ?>
		                                            </a>
	                                            <?php } else { ?>
		                                            <?php echo esc_html( $element['title'] ); ?>
	                                            <?php } ?>
                                            </div>
	                                        <div class="eltdf-element-info">
		                                        <?php if ( $element['class'] !== 'eltdf-section-quiz' ) { ?>
			                                        <span class="eltdf-element-clock-icon lnr lnr-clock"></span>
		                                        <?php } ?>
		                                        <span class="eltdf-element-extra-info-value">
                                                    <?php echo esc_html( $element['extra_info_value'] ); ?>
                                                </span>
		                                        <span class="eltdf-element-extra-info-unit">
                                                    <?php echo esc_html( $element['extra_info_unit'] ); ?>
                                                </span>
	                                        </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            <?php
	            $section_counter ++;
            } ?>
        </div>
    </div>
<?php } ?>
