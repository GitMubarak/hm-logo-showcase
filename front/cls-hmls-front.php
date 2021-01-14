<?php
/**
*	Front Parent Class
*/
class HMLS_Front {	
	private $hmls_version;

	function __construct( $version ) {
		$this->hmls_version = $version;
		$this->hmls_assets_prefix = substr(HMLS_PRFX, 0, -1) . '-';
	}
	
	function hmls_front_assets() {
		
		wp_enqueue_style(	'hmls-front-style',
							HMLS_ASSETS . 'css/' . $this->hmls_assets_prefix . 'front-style.css',
							array(),
							$this->hmls_version,
							FALSE );
		
		if( ! wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}

		wp_enqueue_script(  'hmls-front-script',
							HMLS_ASSETS . 'js/' . $this->hmls_assets_prefix . 'front-script.js',
							array('jquery'),
							$this->hmls_version,
							TRUE );
	}

	function hmls_load_shortcode() {
		add_shortcode( 'hm_logo_showcase', array( $this, 'hmls_load_shortcode_view' ) );
	}

	function hmls_load_shortcode_view( $hmlsAttr ) {

		$output = '';
		ob_start();
		include HMLS_PATH . 'front/view/' . $this->hmls_assets_prefix . 'front-view.php';
		$output .= ob_get_clean();
		return $output;
	}
}
?>