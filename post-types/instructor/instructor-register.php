<?php

namespace ElatedfLMS\CPT\Instructor;

use ElatedfLMS\Lib\PostTypeInterface;

/**
 * Class InstructorRegister
 * @package ElatedfLMS\CPT\Instructor
 */
class InstructorRegister implements PostTypeInterface {
	/**
	 * @var string
	 */
	private $base;
	private $taxBase;
	
	public function __construct() {
		$this->base    = 'instructor';
		$this->taxBase = 'instructor-category';
		
		add_filter( 'archive_template', array( $this, 'registerArchiveTemplate' ) );
		add_filter( 'single_template', array( $this, 'registerSingleTemplate' ) );
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
	}
	
	/**
	 * Registers instructor archive template if one does'nt exists in theme.
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
				return ELATED_LMS_CPT_PATH . '/instructor/templates/archive-' . $this->base . '.php';
			}
		}
		
		return $archive;
	}
	
	/**
	 * Registers instructor single template if one does'nt exists in theme.
	 * Hooked to single_template filter
	 *
	 * @param $single string current template
	 *
	 * @return string string changed template
	 */
	public function registerSingleTemplate( $single ) {
		global $post;
		
		if ( ! empty( $post ) && $post->post_type == $this->base ) {
			if ( ! file_exists( get_template_directory() . '/single-' . $this->base . '.php' ) ) {
				return ELATED_LMS_CPT_PATH . '/instructor/templates/single-' . $this->base . '.php';
			}
		}
		
		return $single;
	}
	
	/**
	 * Registers custom post type with WordPress
	 */
	private function registerPostType() {
		$menuPosition = 19;
		$menuIcon     = 'dashicons-universal-access';
		$slug         = $this->base;
		
		register_post_type( $this->base,
			array(
				'labels'        => array(
					'name'          => esc_html__( 'Elated Instructor', 'eltdf-lms' ),
					'singular_name' => esc_html__( 'Elated Instructor', 'eltdf-lms' ),
					'add_item'      => esc_html__( 'New Instructor', 'eltdf-lms' ),
					'add_new_item'  => esc_html__( 'Add New Instructor', 'eltdf-lms' ),
					'edit_item'     => esc_html__( 'Edit Instructor', 'eltdf-lms' )
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => $slug ),
				'menu_position' => $menuPosition,
				'show_ui'       => true,
				'supports'      => array(
					'author',
					'title',
					'editor',
					'thumbnail',
					'excerpt',
					'page-attributes',
					'comments'
				),
				'menu_icon'     => $menuIcon
			)
		);
	}
	
	/**
	 * Registers custom taxonomy with WordPress
	 */
	private function registerTax() {
		$labels = array(
			'name'              => esc_html__( 'Instructor Categories', 'eltdf-lms' ),
			'singular_name'     => esc_html__( 'Instructor Category', 'eltdf-lms' ),
			'search_items'      => esc_html__( 'Search Instructor Categories', 'eltdf-lms' ),
			'all_items'         => esc_html__( 'All Instructor Categories', 'eltdf-lms' ),
			'parent_item'       => esc_html__( 'Parent Instructor Category', 'eltdf-lms' ),
			'parent_item_colon' => esc_html__( 'Parent Instructor Category:', 'eltdf-lms' ),
			'edit_item'         => esc_html__( 'Edit Instructor Category', 'eltdf-lms' ),
			'update_item'       => esc_html__( 'Update Instructor Category', 'eltdf-lms' ),
			'add_new_item'      => esc_html__( 'Add New Instructor Category', 'eltdf-lms' ),
			'new_item_name'     => esc_html__( 'New Instructor Category Name', 'eltdf-lms' ),
			'menu_name'         => esc_html__( 'Instructor Categories', 'eltdf-lms' )
		);
		
		register_taxonomy( $this->taxBase, array( $this->base ), array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'query_var'         => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => $this->taxBase )
		) );
	}
}