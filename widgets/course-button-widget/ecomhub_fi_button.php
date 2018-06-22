<?php

class EcomhubFiCourseButtonWidget extends eSmartsElatedClassWidget {
	public function __construct() {
		parent::__construct(
			'ecomhub_fi_course_button_widget',
			esc_html__( 'Multitask Button for Courses', 'eltdf-lms' ),
			array( 'description' => esc_html__( 'Try the amazing button !', 'eltdf-lms' ) )
		);
		
		$this->setParams();
	}
	
	/**
	 * Sets widget options
	 */
	protected function setParams() {
		$this->params = array(
			array(
				'type'  => 'textfield',
				'name'  => 'buy_text',
				'title' => esc_html__( 'Buy Button Text', 'eltdf-lms' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'retake_text',
				'title' => esc_html__( 'Retake Button Text', 'eltdf-lms' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'continue_text',
				'title' => esc_html__( 'Continue Button Text', 'eltdf-lms' )
			),
			array(
				'type'  => 'textfield',
				'name'  => 'start_text',
				'title' => esc_html__( 'Start Button Text', 'eltdf-lms' )
			),



			array(
				'type'  => 'textfield',
				'name'  => 'height',
				'title' => esc_html__( 'The Height of the Button. Needs to have unit after it (px,em etc) no spaces', 'eltdf-lms' )
			),
//			array(
//				'type'  => 'textfield',
//				'name'  => 'width',
//				'title' => esc_html__( 'The Width of the Button. Needs to have unit after it (px,em etc) no spaces', 'eltdf-lms' )
//			),
			array(
				'type'  => 'textfield',
				'name'  => 'margin_bottom',
				'title' => esc_html__( 'Space between this widget and the one below. Needs to have unit after it (px,em etc) no spaces', 'eltdf-lms' )
			)
		);
	}
	
	/**
	 * Generates widget's HTML
	 *
	 * @param array $args args from widget area
	 * @param array $instance widget's options
	 */
	public function widget( $args, $instance ) {
		if ( ! is_array( $instance ) ) {
			$instance = array();
		}

		echo
		"<style>
		@media screen and (min-width: 1025px) {
div.eltdf-sidebar-holder.sticky {
     position: fixed;
     left: 66.66667%;
     top: 100px;
     margin-top: 70px;
     margin-bottom: 500px;
  }
  }
  </style>
  <script>
  $(function() {
      var el_window = $(window),
       stickyEl = $('div.eltdf-sidebar-holder'),
      // stickyEl = $('aside.eltdf-sidebar');
       elTop = stickyEl.offset().top - 100;
       var rem_width = stickyEl.width();
       var rem_offset_left = stickyEl.offset().left;
    //   var rem_parent = $('.eltdf-sidebar-holder.eltdf-grid-col-4');
       
  //debugger;
   el_window.scroll(function() {
       // stickyEl.toggleClass('sticky', el_window.scrollTop() > elTop);
        if (el_window.scrollTop() > elTop) {
            stickyEl.addClass('sticky');
            stickyEl.width(rem_width);
            stickyEl.css( 'left', rem_offset_left );
        } else {
          //  rem_width = stickyEl.width();
          //  rem_offset_left = stickyEl.offset().left;
          //  stickyEl.css( 'left', 0 );
         //   console.log('normal');
   //         rem_parent.prepend(stickyEl);
        }
         
    });
   
   $( window ).resize(function() {
       if (stickyEl.hasClass('sticky')) {
           stickyEl.removeClass('sticky');
           stickyEl.css( 'left', 0 );
     //      rem_parent.prepend(stickyEl);
     //      elTop = stickyEl.offset().top - 100;
           rem_offset_left = stickyEl.offset().left;
       }
   });
  })
</script>
";
		
		// Filter out all empty params
		$instance = array_filter( $instance, function ( $array_value ) {
			return trim( $array_value ) != '';
		} );


		//check if user is logged in
		if (is_user_logged_in()) {
			if ( eltdf_lms_user_has_course() ) {
				$user_current_course_status = eltdf_lms_user_current_course_status();
				if ( $user_current_course_status == 'completed' ) {
					$action = 'retake';
				} else if ( $user_current_course_status == 'in-progress' ) {
					$action = 'continue';
				} else {
					$action = 'start';
				}
			} else {
				$action = 'buy';
			}

		} else {
			$action = 'buy';
		}

		$height = isset($instance['height']) ? $instance['height']: null;
		$width =  isset($instance['width']) ? $instance['width']: null;
		$course_id = get_the_ID();
		$do_this_course = $course_title = $course_url = $anchor_link =  $button_text = null;
		if ($action === 'start' || $action === 'continue') {
			$user_status_values = eltdf_lms_get_user_courses_status(null,$course_id);
			$items_completed = $user_status_values[ $course_id ]['items_completed'];
			//the last item in the array is the lesson they left off
			if (empty($items_completed)) {
				//get first lesson of course
				$course_sections = get_post_meta(get_the_ID(), 'eltdf_course_curriculum', true);
				if ($course_sections) {
					$first_section = $course_sections[0];
					$section_elements = $first_section['section_elements'];
					if ($section_elements) {
						$first_course = $section_elements[0];
						$do_this_course = $first_course['value'];
					}
				}
			} else {
				$last_completed_lesson = $items_completed[sizeof($items_completed) - 1];
				$items      = eltdf_lms_course_items_list_array( $course_id );
				$current_id = ( array_search( $last_completed_lesson, $items ) );
				$do_this_course = ( array_key_exists( $current_id + 1, $items ) ) ? $items[ $current_id + 1 ] : '';

			}

			if ($do_this_course) {
				$course_title = get_the_title( $do_this_course );
				$b_check = preg_match("/(?<name>(module|bonus)\s*#?\d*)(.*)/i", $course_title, $output_array);
				if (($b_check !== false) && isset($output_array) && isset($output_array['name'])) {
				    $da_title = $output_array['name'];
                } else {
					$da_title =  $course_title;
                }

				$course_url   = get_the_permalink( $do_this_course );
				$anchor_link = '<a class="eltdf-element-name eltdf-element-link-open" style = "display:none" itemprop="url" href="'.
				               $course_url.'" title="' . esc_attr($da_title ).
				               '" data-item-id="'.$do_this_course.'" data-course-id="'.$course_id.'" id = "ecomhub-fi-magic-link">'.
				               $da_title . '</a>';
			}

		}

		if ($action === 'start') {
			$button_text = isset($instance['start_text'])? $instance['start_text'] : 'Start';
		}

		if ($action === 'continue') {
			$button_text = isset($instance['continue_text'])? $instance['continue_text'] : 'Continue';
		}


		$margin_top = isset($instance['margin_bottom'])? $instance['margin_bottom'] : '1em';
		echo "<div style='text-align: center; margin-bottom: $margin_top'>";
		switch ($action) {
			case 'retake': {
				/** @noinspection PhpUnusedLocalVariableInspection */
				$button_text = isset($instance['retake_text'])? $instance['retake_text'] : 'Retake Course';
				include ABSPATH . "/wp-content/plugins/eltdf-lms/post-types/course/templates/single/parts/retake-form.php";
				break;
			}
			case 'continue':
			case 'start': {
				if ($width && $height) {
					$style = " style=' height:  $height ; ' ";
				} else {
					$style = 'style="width:100%"';
				}
				?>
				<button type="button" class="eltdf-btn eltdf-btn-medium eltdf-btn-solid eltdf-btn-default "
					<?= $style ?>  name="ws-add-to-cart" id="ecomhub-fi-da-button">
					<span class="eltdf-btn-text"  <?= $style ?> >  <?= $button_text ?>  <span style="font-style: italic"> <?= $da_title ?></span></span>
				</button>
				<?= $anchor_link ?>
				<script>
					$('#ecomhub-fi-da-button').click(function() {
                        $('#ecomhub-fi-magic-link').click();
					});

				</script>
				<?php

				break;
			}

			case 'buy': {

			}
			default: {
				/** @noinspection PhpUnusedLocalVariableInspection */
				$button_text = isset($instance['buy_text'])? $instance['buy_text'] : 'Buy Course';
				include realpath( dirname( __FILE__ ) ) . '/form.php';
			}
		};

		echo "</div>";




	}
}