<?php

namespace ElatedfLMS\CPT\Course;

use ElatedfLMS\Lib\PostTypeInterface;

/**
 * Class CourseRegister
 * @package ElatedfLMS\CPT\Course
 */
class CourseRegister implements PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	private $taxBase;
	
	public function __construct() {
		$this->base    = 'course';
		$this->taxBase = 'course-category';
		
		add_filter( 'archive_template', array( $this, 'registerArchiveTemplate' ) );
		add_filter( 'single_template', array( $this, 'registerSingleTemplate' ) );
		add_action( 'admin_menu', array( $this, 'extendLMSCourseMenu' ) );
	}
	
	/**
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}
	
	/**
	 * Registers custom post type with WordPress
	 */
	public function register() {
		$this->registerPostType();
		$this->registerTax();
		$this->registerTagTax();
	}
	
	/**
	 * Registers course archive template if one does'nt exists in theme.
	 * Hooked to archive_template filter
	 *
	 * @param $archive string current template
	 *
	 * @return string string changed template
	 */
	public function registerArchiveTemplate( $archive ) {
		global $post;
		
		if ( ! empty( $post ) && $post->post_type == $this->base ) {
			if ( ! file_exists( get_template_directory() . '/archive-' . $this->base . '.php' ) ) {
				return ELATED_LMS_CPT_PATH . '/course/templates/archive-' . $this->base . '.php';
			}
		}
		
		return $archive;
	}
	
	/**
	 * Registers course single template if one does'nt exists in theme.
	 * Hooked to single_template filter
	 *
	 * @param $single string current template
	 *
	 * @return string string changed template
	 */
	public function registerSingleTemplate( $single ) {
		global $post;
		
		if ( ! empty( $post ) && $post->post_type == $this->base ) {
			if ( ! file_exists( get_template_directory() . '/single-course-item.php' ) ) {
				return ELATED_LMS_CPT_PATH . '/course/templates/single-' . $this->base . '.php';
			}
		}
		
		return $single;
	}
	
	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		
		$slug = $this->base;
		
		if ( eltdf_lms_theme_installed() ) {
			if ( esmarts_elated_options()->getOptionValue( 'course_single_slug' ) ) {
				$slug = esmarts_elated_options()->getOptionValue( 'course_single_slug' );
			}
		}
		
		$labels = array(
			'name'          => esc_html__( 'Elated Courses', 'eltdf-lms' ),
			'singular_name' => esc_html__( 'Elated Course', 'eltdf-lms' ),
			'add_item'      => esc_html__( 'New Course', 'eltdf-lms' ),
			'add_new_item'  => esc_html__( 'Add New Course', 'eltdf-lms' ),
			'add_new'       => esc_html__( 'Add New Course', 'eltdf-lms' ),
			'edit_item'     => esc_html__( 'Edit Course', 'eltdf-lms' )
		);
		
		register_post_type( $this->base,
			array(
				'labels'            => $labels,
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => $slug ),
				'show_in_menu'      => 'eltdf_lms_menu',
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'show_ui'           => true,
				'supports'          => array(
					'author',
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'page-attributes',
					'comments'
				)
			)
		);
	}
	
	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__( 'Course Categories', 'eltdf-lms' ),
			'singular_name'     => esc_html__( 'Course Category', 'eltdf-lms' ),
			'search_items'      => esc_html__( 'Search Course Categories', 'eltdf-lms' ),
			'all_items'         => esc_html__( 'All Course Categories', 'eltdf-lms' ),
			'parent_item'       => esc_html__( 'Parent Course Category', 'eltdf-lms' ),
			'parent_item_colon' => esc_html__( 'Parent Course Category:', 'eltdf-lms' ),
			'edit_item'         => esc_html__( 'Edit Course Category', 'eltdf-lms' ),
			'update_item'       => esc_html__( 'Update Course Category', 'eltdf-lms' ),
			'add_new_item'      => esc_html__( 'Add New Course Category', 'eltdf-lms' ),
			'new_item_name'     => esc_html__( 'New Course Category Name', 'eltdf-lms' ),
			'menu_name'         => esc_html__( 'Course Categories', 'eltdf-lms' )
		);
		
		register_taxonomy(
			$this->taxBase,
			array(
				$this->base
			),
			array(
				'public'            => true,
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'query_var'         => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'course-category' )
			)
		);
	}
	
	/**
	 * Registers custom tag taxonomy with WordPress
	 */
	private function registerTagTax() {
		$labels = array(
			'name'              => esc_html__( 'Course Tags', 'eltdf-lms' ),
			'singular_name'     => esc_html__( 'Course Tag', 'eltdf-lms' ),
			'search_items'      => esc_html__( 'Search Course Tags', 'eltdf-lms' ),
			'all_items'         => esc_html__( 'All Course Tags', 'eltdf-lms' ),
			'parent_item'       => esc_html__( 'Parent Course Tag', 'eltdf-lms' ),
			'parent_item_colon' => esc_html__( 'Parent Course Tags:', 'eltdf-lms' ),
			'edit_item'         => esc_html__( 'Edit Course Tag', 'eltdf-lms' ),
			'update_item'       => esc_html__( 'Update Course Tag', 'eltdf-lms' ),
			'add_new_item'      => esc_html__( 'Add New Course Tag', 'eltdf-lms' ),
			'new_item_name'     => esc_html__( 'New Course Tag Name', 'eltdf-lms' ),
			'menu_name'         => esc_html__( 'Course Tags', 'eltdf-lms' )
		);
		
		register_taxonomy(
			'course-tag',
			array(
				$this->base
			),
			array(
				'public'            => true,
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'query_var'         => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'course-tag' )
			)
		);
	}
	
	function extendLMSCourseMenu() {
		
		add_submenu_page(
			'eltdf_lms_menu',
			esc_html__( 'New Course', 'eltdf-lms' ),
			esc_html__( 'Add New Course', 'eltdf-lms' ),
			'edit_posts',
			'post-new.php?post_type=' . $this->base
		);
		
		add_submenu_page(
			'eltdf_lms_menu',
			esc_html__( 'Course Categories', 'eltdf-lms' ),
			esc_html__( 'Course Categories', 'eltdf-lms' ),
			'edit_posts',
			'edit-tags.php?taxonomy=' . $this->taxBase
		);
		
		add_submenu_page(
			'eltdf_lms_menu',
			esc_html__( 'Course Tags', 'eltdf-lms' ),
			esc_html__( 'Course Tags', 'eltdf-lms' ),
			'edit_posts',
			'edit-tags.php?taxonomy=course-tag'
		);
	}
}