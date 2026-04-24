<?php
/**
 * Plugin Name: Student Manager
 * Plugin URI: https://example.com/
 * Description: Plugin quản lý sinh viên với Custom Post Type và Shortcode.
 * Version: 1.0.0
 * Author: Cấn Đức Điệp
 * Author URI: https://example.com/
 * Text Domain: student-manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Định nghĩa hằng số cho plugin
define( 'STUDENT_MANAGER_VERSION', '1.0.0' );
define( 'STUDENT_MANAGER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'STUDENT_MANAGER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load các class cần thiết
require_once STUDENT_MANAGER_PLUGIN_DIR . 'includes/class-student-manager-cpt.php';
require_once STUDENT_MANAGER_PLUGIN_DIR . 'includes/class-student-manager-shortcode.php';

// Khởi tạo plugin
function student_manager_init() {
	$cpt = new Student_Manager_CPT();
	$cpt->init();

	$shortcode = new Student_Manager_Shortcode();
	$shortcode->init();
}
add_action( 'plugins_loaded', 'student_manager_init' );

// Load CSS ở frontend
function student_manager_enqueue_scripts() {
	wp_enqueue_style( 'student-manager-style', STUDENT_MANAGER_PLUGIN_URL . 'assets/css/style.css', array(), STUDENT_MANAGER_VERSION );
}
add_action( 'wp_enqueue_scripts', 'student_manager_enqueue_scripts' );
