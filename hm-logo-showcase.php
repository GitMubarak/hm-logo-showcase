<?php
/**
 * Plugin Name: 	HM Logo Showcase
 * Plugin URI:		http://wordpress.org/plugins/hm-logo-showcase/
 * Description: 	This Plugin will display Logos in your page by using the shortcode: [hm_logo_showcase]
 * Version: 		1.0
 * Author: 			Hossni Mubarak
 * Author URI: 		http://www.hossnimubarak.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
*/

if (!defined('ABSPATH')) exit;

define('HMLS_PATH', plugin_dir_path(__FILE__));
define('HMLS_ASSETS', plugins_url('/assets/', __FILE__));
define('HMLS_SLUG', plugin_basename(__FILE__));
define('HMLS_PRFX', 'hmls_');
define('HMLS_CLS_PRFX', 'cls-hmls-');
define('HMLS_TXT_DOMAIN', 'hm-logo-showcase');
define('HMLS_VERSION', '1.0');

require_once HMLS_PATH . 'inc/' . HMLS_CLS_PRFX . 'master.php';
$hmls = new HMLS_Master();
$hmls->hmls_run();

register_deactivation_hook( __FILE__, array( $hmls, HMLS_PRFX . 'unregister_settings' ) );