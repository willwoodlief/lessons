<?php
$course_sections = get_post_meta( get_the_ID(), 'eltdf_course_curriculum', true );
if ( ! empty( $course_sections ) ) {
	$unlocks = ecomhub_fi_user_section_progress(get_current_user_id(),null,$course_sections);
	$section_counter = 0;
    ?>
	<div class="eltdf-course-popup-items">
		<div class="eltdf-course-popup-items-list">
			<?php foreach ( $course_sections as $course_section ) {
			    $section_lock = $unlocks[$section_counter];?>
				<!--suppress XmlUnboundNsPrefix -->
            <div class="eltdf-popup-items-section" style="
					<?php if ( $section_lock['is_readable'] && $section_lock['is_locked']) { ?>
                         background-color: transparent"
                    <?php } ?>
                    clear: both"> <!--todo  head of section -->

					<h4 class="eltdf-section-name">
						<?php echo esc_html( $course_section['section_name'] ) ?>
					</h4>
					<h5 class="eltdf-section-title">
						<?php echo esc_html( $course_section['section_title'] ) ?>
					</h5>

					<div class="eltdf-section-content">
						<?php
						if ( isset( $course_section['section_elements'] ) && $course_section['section_elements'] !== '' ) {
							$section_elements = $course_section['section_elements'];
							if ( ! empty( $section_elements ) ) {
								$list            = eltdf_lms_get_course_curriculum_list( $section_elements );
								$elements        = $list['elements'];
								$lessons_summary = $list['lessons_summary'];
								?>
								<div class="eltdf-section-elements">
									<?php if ( ! empty( $lessons_summary ) ) {
										$lesson_info = implode( ', ', $lessons_summary );
										?>
										<div class="eltdf-section-elements-summary">
											<i class="lnr lnr-book" aria-hidden="true"></i>
											<span class="eltdf-summary-value"><?php echo esc_html( $lesson_info ); ?></span>
										</div>
									<?php } ?>
									<?php if ( $section_lock['is_readable'] && $section_lock['is_locked']) { ?>

                                        <div class="ecomhub-fi-locked-description" style="z-index: 999999;width: 18em;height: 6em; margin: 2.5em;  float:right ">
                                            <div style="text-align: center;padding: 0.5em;background-color: #fbfbfb">
                                                <span class="ecomhub-fi-lock-image fa fa-lock" style="color:#3A4242;font-size: 3em"></span>
                                                <br>
                                                <span class="ecomhub-fi-lock-human-span" style="color: black"><?= $section_lock['human'] ?></span>
                                            </div>
                                        </div>
										<?php
									}

									?>
									<?php foreach ( $elements as $key => $element ) { ?>
										<div class="eltdf-section-element <?php echo esc_attr( $element['class'] ); ?> clearfix <?php echo eltdf_lms_get_course_item_completed_class( $element['id'] ); ?>" data-section-element-id="<?php echo esc_attr( $element['id'] ); ?>">
											<div class="eltdf-element-title">
                                                <span class="eltdf-element-icon">
                                                    <?php print $element['icon']; ?>
                                                </span>
												<span class="eltdf-element-label">
                                                    <?php echo esc_attr( $element['label'] ); ?>
                                                </span>
                                                <!-- todo preview course link in popup -->
												<?php if ( eltdf_lms_course_is_preview_available( $element['id'] )  &&  ($section_lock['is_readable']) && (!$section_lock['is_locked']) ) { ?>
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
