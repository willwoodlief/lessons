<?php

namespace ElatedfLMS\CPT\Shortcodes\Course;

use ElatedfLMS\Lib;

class CourseSearch implements Lib\ShortcodeInterface {
	private $base;
	
	public function __construct() {
		$this->base = 'eltdf_course_search';
		
		add_action( 'vc_before_init', array( $this, 'vcMap' ) );
	}
	
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if ( function_exists( 'vc_map' ) ) {
			vc_map( array(
					'name'                      => esc_html__( 'Elated Advanced Course Search', 'eltdf-lms' ),
					'base'                      => $this->getBase(),
					'category'                  => esc_html__( 'by ELATED LMS', 'eltdf-lms' ),
					'icon'                      => 'icon-wpb-course-search extended-custom-lms-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array(
						array(
							'type'        => 'textfield',
							'param_name'  => 'button_text',
							'heading'     => esc_html__( 'Button Text', 'eltdf-lms' ),
							'value'       => esc_html__( 'Search', 'eltdf-lms' ),
							'save_always' => true
						)
					)
				)
			);
		}
	}
	
	public function render( $atts, $content = null ) {
		$args   = array(
			'button_text' => 'Search'
		);
		$params = shortcode_atts( $args, $atts );
		
		$params['button_parameters'] = $this->getButtonParameters( $params );
		
		$html = '<form role="search" method="get" class="searchform eltdf-advanced-course-search" action="' . esc_url( home_url( "/" ) ) . '">';
			$html .= '<div class="input-holder clearfix">';
				$html .= '<input type="hidden" name="s" value="" />';
				$html .= '<input type="hidden" name="eltdf-course-search" value="yes" />';
				$html .= '<select name="eltdf-course-category">';
				$html .= $this->getCourseCategories( $params );
				$html .= '</select>';
				$html .= '<select name="eltdf-course-instructor">';
				$html .= $this->getCourseInstructors( $params );
				$html .= '</select>';
				$html .= '<select name="eltdf-course-price">';
				$html .= $this->getCoursePrice( $params );
				$html .= '</select>';
				$html .= esmarts_elated_get_button_html( $params['button_parameters'] );
			$html .= '</div>';
		$html .= '</form>';
		
		return $html;
	}
	
	private function getCourseCategories( $params ) {
		$terms_args               = array();
		$terms_args['taxonomy']   = 'course-category';
		$terms_args['hide_empty'] = true;
		$terms                    = get_terms( $terms_args );
		
		$html = '<option value="all">' . esc_html__( "All", "eltdf-lms" ) . '</option>';
		foreach ( $terms as $term ) {
			if ( isset( $params['selected_category'] ) && $params['selected_category'] == $term->slug ) {
				$html .= '<option selected value="' . $term->slug . '">';
			} else {
				$html .= '<option value="' . $term->slug . '">';
			}
			$html .= $term->name;
			$html .= '</option>';
		}
		
		return $html;
	}
	
	private function getCourseInstructors( $params ) {
		$html              = '';
		$instructors_array = array();
		
		//Get unique instructors IDs that are set for courses
		$instructors_from_meta_array = array();
		global $wpdb;
		$instructors_from_meta = $wpdb->get_results( "SELECT DISTINCT meta_value FROM $wpdb->postmeta pm WHERE meta_key  = 'eltdf_course_instructor_meta'", ARRAY_A );
		foreach ( $instructors_from_meta as $instructor ) {
			$instructors_from_meta_array[] = $instructor['meta_value'];
		}
		
		//Get all instructors and store only the ones that are set for some course
		$instructors_query_array = array(
			'post_status'    => 'publish',
			'post_type'      => 'instructor',
			'posts_per_page' => '-1',
			'orderby'        => 'name',
			'order'          => 'ASC'
		);
		
		$instructors_query       = new \WP_Query( $instructors_query_array );
		$instructors             = $instructors_query->posts;
		if ( ! empty( $instructors ) ) {
			foreach ( $instructors as $instructor ) {
				if ( in_array( $instructor->ID, $instructors_from_meta_array ) ) {
					$instructors_array[] = $instructor;
				}
			}
		}
		
		wp_reset_postdata();
		
		$html .= '<option value="all">' . esc_html__( "All", "eltdf-lms" ) . '</option>';
		foreach ( $instructors_array as $instructor ) {
			if ( isset( $params['selected_instructor'] ) && $params['selected_instructor'] == $instructor->ID ) {
				$html .= '<option selected value="' . $instructor->ID . '">';
			} else {
				$html .= '<option value="' . $instructor->ID . '">';
			}
			$html .= $instructor->post_title;
			$html .= '</option>';
		}
		
		return $html;
	}
	
	private function getCoursePrice( $params ) {
		$prices = array(
			'all'  => esc_html__( "All", "eltdf-lms" ),
			'free' => esc_html__( "Free", "eltdf-lms" ),
			'paid' => esc_html__( "Paid", "eltdf-lms" )
		);
		
		$html = '';
		foreach ( $prices as $key => $value ) {
			if ( isset( $params['selected_price'] ) && $params['selected_price'] == $key ) {
				$html .= '<option selected value="' . $key . '">';
			} else {
				$html .= '<option value="' . $key . '">';
			}
			$html .= $value;
			$html .= '</option>';
		}
		
		return $html;
	}
	
	private function getButtonParameters( $params ) {
		$button_params_array = array();
		
		$button_params_array['html_type'] = 'button';
		$button_params_array['type'] = 'solid';
		$button_params_array['size'] = 'large';
        $button_params_array['hover_animation'] = 'yes';
		$button_params_array['link'] = '#';
		
		if ( ! empty( $params['button_text'] ) ) {
			$button_params_array['text'] = $params['button_text'];
		}
		
		return $button_params_array;
	}
}