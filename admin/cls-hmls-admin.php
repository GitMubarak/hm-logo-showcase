<?php

/**
 *	Admin Parent Class
 */
class HMLS_Admin
{
	private $hmls_version;
	private $hmls_assets_prefix;

	function __construct($version) {
		$this->hmls_version = $version;
		$this->hmls_assets_prefix = substr( HMLS_PRFX, 0, -1 ) . '-';
	}

	/**
	 *	Flush Rewrite on Plugin initialization
	 */
	function hmls_flush_rewrite() {
		if( get_option('hmls_plugin_settings_have_changed') == true ) {
			flush_rewrite_rules();
			update_option('hmls_plugin_settings_have_changed', false);
		}
	}

	/**
	 *	Loading admin menu
	 */
	function hmls_admin_menu()
	{
		$hmls_cpt_menu = 'edit.php?post_type=hmls_logo';
		add_submenu_page(
			$hmls_cpt_menu,
			esc_html__('General Settings', HMLS_TXT_DOMAIN),
			esc_html__('General Settings', HMLS_TXT_DOMAIN),
			'manage_options',
			'hmls-general-settings',
			array($this, HMLS_PRFX . 'general_settings')
		);
	}

	/**
	 *	Loading admin panel assets
	 */
	function hmls_enqueue_assets() {

		wp_enqueue_style( 'wp-color-picker');

		wp_enqueue_style(
			$this->hmls_assets_prefix . 'admin-style',
			HMLS_ASSETS . 'css/' . $this->hmls_assets_prefix . 'admin-style.css',
			array(),
			$this->hmls_version,
			FALSE
		);

		if( ! wp_script_is('jquery') ) {
			wp_enqueue_script('jquery');
		}
		
		wp_enqueue_script( 'wp-color-picker');
		
		wp_enqueue_script(
			$this->hmls_assets_prefix . 'admin-script',
			HMLS_ASSETS . 'js/' . $this->hmls_assets_prefix . 'admin-script.js',
			array('jquery'),
			$this->hmls_version,
			TRUE
		);
	}

	function hmls_custom_post_type() {
		$labels = array(
							'name'                => __('HM Logos'),
							'singular_name'       => __('HM Logos'),
							'menu_name'           => __('HM Logos'),
							'parent_item_colon'   => __('Parent Logo'),
							'all_items'           => __('All Logos'),
							'view_item'           => __('View Logo'),
							'add_new_item'        => __('Add New Logo'),
							'add_new'             => __('Add New'),
							'edit_item'           => __('Edit Logo'),
							'update_item'         => __('Update Logo'),
							'search_items'        => __('Search Logo'),
							'not_found'           => __('Not Found'),
							'not_found_in_trash'  => __('Not found in Trash')
						);
		$args = array(
						'label'               => __('hmls_logo'),
						'description'         => __('Description For Logo'),
						'labels'              => $labels,
						'supports'            => array('title', 'editor', 'thumbnail'),
						'public'              => true,
						'hierarchical'        => false,
						'show_ui'             => true,
						'show_in_menu'        => true,
						'show_in_nav_menus'   => true,
						'show_in_admin_bar'   => true,
						'has_archive'         => false,
						'can_export'          => true,
						'exclude_from_search' => false,
						'yarpp_support'       => true,
						//'taxonomies' 	      => array('post_tag'),
						'publicly_queryable'  => true,
						'capability_type'     => 'page',
						'menu_icon'           => 'dashicons-screenoptions'
					);
		register_post_type('hmls_logo', $args);
	}

	function hmls_taxonomy_for_logo() {
		$labels = array(
			'name' 				=> _x('Logo Categories', 'taxonomy general name'),
			'singular_name' 	=> _x('Logo Category', 'taxonomy singular name'),
			'search_items' 		=>  __('Search Logo Categories'),
			'all_items' 		=> __('All Logo Categories'),
			'parent_item' 		=> __('Parent Logo Category'),
			'parent_item_colon'	=> __('Parent Logo Category:'),
			'edit_item' 		=> __('Edit Logo Category'),
			'update_item' 		=> __('Update Logo Category'),
			'add_new_item' 		=> __('Add New Logo Category'),
			'new_item_name' 	=> __('New Logo Category Name'),
			'menu_name' 		=> __('Logo Categories'),
		);

		register_taxonomy('logo_category', array('hmls_logo'), array(
			'hierarchical' 		=> true,
			'labels' 			=> $labels,
			'show_ui' 			=> true,
			'show_admin_column' => true,
			'query_var' 		=> true,
			'rewrite' 			=> array('slug' => 'logo-category'),
		));
	}

	function hmls_metaboxes() {
		add_meta_box(
			'hmls_metaboxes',
			'HM Logo Details',
			array( $this, HMLS_PRFX . 'metabox_content' ),
			'hmls_logo',
			'normal',
			'high'
		);
	}

	function hmls_metabox_content() {
		
		global $post;
		wp_nonce_field( basename(__FILE__), 'hmls_fields' );
		$hmls_status	= get_post_meta( $post->ID, 'hmls_status', true );
		?>
		<table class="form-table">
			<tr class="hmls_status">
				<th scope="row">
					<label for="hmls_status"><?php esc_html_e('Status:', HMLS_TXT_DOMAIN); ?></label>
				</th>
				<td>
					<select name="hmls_status" class="small-text">
						<option value="active" <?php if ( 'inactive' != esc_attr( $hmls_status ) ) echo 'selected'; ?> ><?php esc_html_e('Active', HMLS_TXT_DOMAIN); ?></option>
						<option value="inactive" <?php if ( 'inactive' == esc_attr( $hmls_status ) ) echo 'selected'; ?> ><?php esc_html_e('Inactive', HMLS_TXT_DOMAIN); ?></option>
					</select>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Save the metabox data
	 */
	function hmls_save_meta_value( $post_id ) {
		
		global $post;

		if( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if( ! isset( $_POST['hmls_status'] ) || ! wp_verify_nonce( $_POST['hmls_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}

		$hmls_meta['hmls_status']	= ( sanitize_text_field( $_POST['hmls_status'] ) != '' ) ? sanitize_text_field( $_POST['hmls_status'] ) : '';

		foreach( $hmls_meta as $key => $value ) {
			if ('revision' === $post->post_type) {
				return;
			}
			if (get_post_meta($post_id, $key, false)) {
				update_post_meta($post_id, $key, $value);
			} else {
				add_post_meta($post_id, $key, $value);
			}
			if (!$value) {
				delete_post_meta($post_id, $key);
			}
		}
	}

	function hmls_general_settings() {
		require_once HMLS_PATH . 'admin/view/' . $this->hmls_assets_prefix . 'general-settings.php';
	}

	function hmls_display_notification($type, $msg) { 
		?>
		<div class="hmls-alert <?php printf('%s', $type); ?>">
			<span class="hmls-closebtn">&times;</span>
			<strong><?php esc_html_e(ucfirst($type), HMLS_TXT_DOMAIN); ?>!</strong>
			<?php esc_html_e($msg, HMLS_TXT_DOMAIN); ?>
		</div>
		<?php 
	}
}
?>