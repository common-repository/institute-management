<?php
/*
 * Plugin Name: Institute Management - Learning Management System
 * Plugin URI: https://wordpress.org/plugins/institute-management/
 * Description: Institute Management is a comprehensive plugin to manage institute related activities such as courses, batches, enquirers, registrations, fees, students, staff etc.
 * Version: 5.0
 * Author: Weblizar
 * Author URI: https://weblizar.com
 * Text Domain: WL-IM
*/

defined( 'ABSPATH' ) or die();

if ( ! defined( 'WL_IM_DOMAIN' ) ) {
	define( 'WL_IM_DOMAIN', 'WL-IM' );
}

if ( ! defined( 'WL_IM_PLUGIN_URL' ) ) {
	define( 'WL_IM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WL_IM_PLUGIN_DIR_PATH' ) ) {
	define( 'WL_IM_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}


final class WL_IM_InstituteManagement {
	private static $instance = null;

	private function __construct() {
		$this->initialize_hooks();
		$this->setup_database();
	}

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function initialize_hooks() {
		if ( is_admin() ) {
			require_once 'admin/admin.php';
		}
		require_once 'public/public.php';
	}

	private function setup_database() {
		require_once 'admin/WL_IM_Database.php';
		register_activation_hook( __FILE__, array( 'WL_IM_Database', 'activation' ) );
	}
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ism_page_settings_link' );
function ism_page_settings_link( $links ) {

	$links[] = '<a href="' . esc_url( admin_url() . 'admin.php?page=institute-management-settings' ) . '">' . esc_html__( 'Settings', WL_IM_DOMAIN ) . '</a>';
	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'ism_page_pro_link' );
function ism_page_pro_link( $links ) {
	$links[] = '<a href="' . ( 'https://weblizar.com/plugins/multi-institute-management/' ) . '" style="color:green;"> ' . __( 'Get Pro' ) . '</a>';
	return $links;
}

WL_IM_InstituteManagement::get_instance();
