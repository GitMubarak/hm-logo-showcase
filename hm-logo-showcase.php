<?php
/**
 * Plugin Name: 	HM Logo Showcase
 * Plugin URI:		https://wordpress.org/plugins/hm-logo-showcase/
 * Description: 	This is a logo manager plugin which will display client/brand logos on your website page by using the shortcode: [hm_logo_showcase]
 * Version: 		1.3
 * Author: 			HM Plugin
 * Author URI: 		https://hmplugin.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined('ABSPATH') ) exit;

define( 'HMLS_PATH', plugin_dir_path(__FILE__) );
define( 'HMLS_ASSETS', plugins_url('/assets/', __FILE__) );
define( 'HMLS_LANG', plugins_url('/languages/', __FILE__) );
define( 'HMLS_SLUG', plugin_basename(__FILE__) );
define( 'HMLS_PRFX', 'hmls_' );
define( 'HMLS_CLS_PRFX', 'cls-hmls-' );
define( 'HMLS_TXT_DOMAIN', 'hm-logo-showcase' );
define( 'HMLS_VERSION', '1.3' );

require_once HMLS_PATH . 'inc/' . HMLS_CLS_PRFX . 'master.php';
$hmls = new HMLS_Master();
$hmls->hmls_run();

// Donate link to plugin description
function hmls_display_donation_link( $links, $file ) {

    if ( HMLS_SLUG === $file ) {
        $row_meta = array(
          'hmls_donation'  => '<a href="' . esc_url( 'https://www.paypal.me/mhmrajib/' ) . '" target="_blank" aria-label="' . esc_attr__( 'Donate us', 'hm-logo-showcase' ) . '" style="color:green; font-weight: bold;">' . esc_html__( 'Donate us', 'hm-logo-showcase' ) . '</a>'
        );
 
        return array_merge( $links, $row_meta );
    }
    return (array) $links;
}
add_filter( 'plugin_row_meta', 'hmls_display_donation_link', 10, 2 );

register_deactivation_hook( __FILE__, array( $hmls, HMLS_PRFX . 'unregister_settings' ) );