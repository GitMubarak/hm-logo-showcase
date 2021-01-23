<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * Our main plugin class
 */
class HMLS_Master {

	protected $hmls_loader;
	protected $hmls_version;

	/**
	 * Class Constructor
	 */
	function __construct() {
		$this->hmls_version = HMLS_VERSION;
		$this->hmls_load_dependencies();
		$this->hmls_trigger_admin_hooks();
		$this->hmls_trigger_front_hooks();
	}

	private function hmls_load_dependencies() {
		require_once HMLS_PATH . 'admin/' . HMLS_CLS_PRFX . 'admin.php';
		require_once HMLS_PATH . 'front/' . HMLS_CLS_PRFX . 'front.php';
		require_once HMLS_PATH . 'inc/' . HMLS_CLS_PRFX . 'loader.php';
		$this->hmls_loader = new HMLS_Loader();
	}

	private function hmls_trigger_admin_hooks() {
		$hmls_admin = new HMLS_Admin($this->hmls_version());
		$this->hmls_loader->add_action('admin_enqueue_scripts', $hmls_admin, HMLS_PRFX . 'enqueue_assets');
		$this->hmls_loader->add_action('init', $hmls_admin, HMLS_PRFX . 'custom_post_type', 0);
		$this->hmls_loader->add_action('init', $hmls_admin, HMLS_PRFX . 'taxonomy_for_logo', 0);
		$this->hmls_loader->add_action('add_meta_boxes', $hmls_admin, HMLS_PRFX . 'metaboxes');
		$this->hmls_loader->add_action('save_post', $hmls_admin, HMLS_PRFX . 'save_meta_value', 1, 1);
		$this->hmls_loader->add_action('admin_menu', $hmls_admin, HMLS_PRFX . 'admin_menu', 0);
		$this->hmls_loader->add_action('admin_init', $hmls_admin, HMLS_PRFX . 'flush_rewrite');
		// Change the featured image metabox link text
		$this->hmls_loader->add_filter('admin_post_thumbnail_html', $hmls_admin, HMLS_PRFX . 'change_featured_image_link_text');
	}

	function hmls_trigger_front_hooks() {
		$hmls_front = new HMLS_Front($this->hmls_version());
		$this->hmls_loader->add_action('wp_enqueue_scripts', $hmls_front, HMLS_PRFX . 'front_assets');
		$hmls_front->hmls_load_shortcode();
	}

	function hmls_run() {
		$this->hmls_loader->hmls_run();
	}

	function hmls_version() {
		return $this->hmls_version;
	}

	function hmls_unregister_settings() {
		global $wpdb;

		$tbl = $wpdb->prefix . 'options';
		$search_string = HMLS_PRFX . '%';

		$sql = $wpdb->prepare("SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string);
		$options = $wpdb->get_results($sql, OBJECT);

		if (is_array($options) && count($options)) {
			foreach ($options as $option) {
				delete_option($option->option_name);
				delete_site_option($option->option_name);
			}
		}
	}
}