<?php
/*
Plugin Name: Elated LMS
Description: Plugin that adds post types for LMS extension
Author: Elated Themes
Version: 1.0.1
*/

require_once 'load.php';

add_action( 'after_setup_theme', array( ElatedfLMS\CPT\PostTypesRegister::getInstance(), 'register' ) );

if ( ! function_exists( 'eltdf_lms_activation' ) ) {
	/**
	 * Triggers when plugin is activated. It calls flush_rewrite_rules
	 * and defines esmarts_elated_action_lms_on_activate action
	 */
	function eltdf_lms_activation() {
		do_action( 'esmarts_elated_action_lms_on_activate' );
		
		ElatedfLMS\CPT\PostTypesRegister::getInstance()->register();
		flush_rewrite_rules();
	}
	
	register_activation_hook( __FILE__, 'eltdf_lms_activation' );
}

if ( ! function_exists( 'eltdf_lms_text_domain' ) ) {
	/**
	 * Loads plugin text domain so it can be used in translation
	 */
	function eltdf_lms_text_domain() {
		load_plugin_textdomain( 'eltdf-lms', false, ELATED_LMS_REL_PATH . '/languages' );
	}
	
	add_action( 'plugins_loaded', 'eltdf_lms_text_domain' );
}

if ( ! function_exists( 'eltdf_lms_admin_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function eltdf_lms_admin_scripts() {
		$screen = get_current_screen();
		
		if ( isset( $screen->id ) && ! empty( $screen->id ) && $screen->id === 'course' ) {
			wp_enqueue_script( 'eltdf_admin_course_script', plugins_url( ELATED_LMS_REL_PATH . '/assets/js/admin/course-sections-admin.js' ), array( 'jquery', 'underscore' ), false, true );
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'eltdf_lms_admin_scripts' );
}

if ( ! function_exists( 'eltdf_lms_scripts' ) ) {
	/**
	 * Loads plugin scripts
	 */
	function eltdf_lms_scripts() {
		$array_deps_css            = array();
		$array_deps_css_responsive = array();
		$array_deps_js             = array();
		
		if ( eltdf_lms_theme_installed() ) {
			$array_deps_css[]            = 'esmarts_elated_modules';
			$array_deps_css_responsive[] = 'esmarts_elated_modules_responsive';
			$array_deps_js[]             = 'esmarts_elated_js_modules';
		}
		
		wp_enqueue_style( 'eltdf_lms_style', plugins_url( ELATED_LMS_REL_PATH . '/assets/css/lms.min.css' ), $array_deps_css,'wills.changes.0.1' );
		if ( esmarts_elated_is_responsive_on() ) {
			wp_enqueue_style( 'eltdf_lms_responsive_style', plugins_url( ELATED_LMS_REL_PATH . '/assets/css/lms-responsive.min.css' ), $array_deps_css_responsive );
		}
		
		wp_enqueue_script( 'eltdf_lms_script', plugins_url( ELATED_LMS_REL_PATH . '/assets/js/lms.min.js' ), $array_deps_js, false, true );
	}
	
	add_action( 'wp_enqueue_scripts', 'eltdf_lms_scripts' );
}

if ( ! function_exists( 'eltdf_lms_style_dynamics_deps' ) ) {
	function eltdf_lms_style_dynamics_deps( $deps ) {
		$style_dynamic_deps_array   = array();
		$style_dynamic_deps_array[] = 'eltdf_lms_style';
		
		if ( esmarts_elated_is_responsive_on() ) {
			$style_dynamic_deps_array[] = 'eltdf_lms_responsive_style';
		}
		
		return array_merge( $deps, $style_dynamic_deps_array );
	}
	
	add_filter( 'esmarts_elated_filter_style_dynamic_deps', 'eltdf_lms_style_dynamics_deps' );
}

if ( ! function_exists( 'eltdf_lms_version_class' ) ) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function eltdf_lms_version_class( $classes ) {
		$classes[] = 'eltd-lms-' . ELATED_LMS_VERSION;
		
		return $classes;
	}
	
	add_filter( 'body_class', 'eltdf_lms_version_class' );
}

if ( ! function_exists( 'eltdf_lms_theme_installed' ) ) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function eltdf_lms_theme_installed() {
		return defined( 'ELATED_ROOT' );
	}
}

if ( ! function_exists( 'eltdf_lms_is_woocommerce_installed' ) ) {
	/**
	 * Function that checks if woocommerce is installed
	 * @return bool
	 */
	function eltdf_lms_is_woocommerce_installed() {
		return function_exists( 'is_woocommerce' );
	}
}

if ( ! function_exists( 'eltdf_lms_is_revolution_slider_installed' ) ) {
	function eltdf_lms_is_revolution_slider_installed() {
		return class_exists( 'RevSliderFront' );
	}
}

if ( ! function_exists( 'eltdf_lms_core_plugin_installed' ) ) {
	//is Elated CPT installed?
	function eltdf_lms_core_plugin_installed() {
		return defined( 'ELATED_CORE_VERSION' );
	}
}

if(!function_exists('eltdf_lms_is_wpml_installed')) {
	function eltdf_lms_is_wpml_installed() {
		return defined('ICL_SITEPRESS_VERSION');
	}
}

if ( ! function_exists( 'eltdf_lms_bbpress_plugin_installed' ) ) {
	//is BBPress installed?
	function eltdf_lms_bbpress_plugin_installed() {
		return class_exists( 'bbPress' ) && function_exists( 'is_plugin_active' ) && is_plugin_active( 'bbpress/bbpress.php' );
	}
}

if ( ! function_exists( 'eltdf_lms_theme_menu' ) ) {
	/**
	 * Function that generates admin menu for lms post types.
	 */
	function eltdf_lms_theme_menu() {
		if ( eltdf_lms_theme_installed() ) {
			global $theme_name_php_global_Framework;
			
			$page_hook_suffix = add_menu_page(
				'Elated LMS',       // The value used to populate the browser's title bar when the menu page is active
				'Elated LMS',       // The text of the menu in the administrator's sidebar
				'administrator',  // What roles are able to access the menu
				'eltdf_lms_menu', // The ID used to bind submenu items to this menu
				'',               // The callback function used to render this menu
				$theme_name_php_global_Framework->getSkin()->getSkinURI() . '/assets/img/admin-logo-icon.png', // Icon For menu Item
				10                // Position
			);
			
			add_action( 'admin_print_scripts-' . $page_hook_suffix, 'esmarts_elated_enqueue_admin_scripts' );
			add_action( 'admin_print_styles-' . $page_hook_suffix, 'esmarts_elated_enqueue_admin_styles' );
		}
	}
	
	add_action( 'admin_menu', 'eltdf_lms_theme_menu' );
}