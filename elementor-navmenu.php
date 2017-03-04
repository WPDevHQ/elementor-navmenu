<?php
/**
 * Plugin Name: NavMenu Addon For Elementor
 * Description: A custom navbar addon for Elementor - any theme and template.
 * Plugin URI:  https://wpdevhq.com/
 * Version:     1.0.0
 * Author:      WPDevHQ
 * Author URI:  https://wpdevhq.com/plugins/navmenu-addon-elementor
 * Text Domain: elementor-navmenu
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Load Elementor Navbar
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function elementor_navmenu_load() {
	// Load localization file
	load_plugin_textdomain( 'elementor-navmenu' );

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'elementor_navmenu_fail_load' );
		return;
	}

	// Check version required
	$elementor_version_required = '1.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'elementor_navmenu_fail_load_out_of_date' );
		return;
	}

	// Require the main plugin file
	require( __DIR__ . '/plugin.php' );
}
add_action( 'plugins_loaded', 'elementor_navmenu_load' );

function ele_navbar_menu_choices() {
    $menus = wp_get_nav_menus();
	$items = array();
	$i = 0;
	foreach( $menus as $menu ){
		if($i==0){
			$default = $menu->slug;
			$i++;
		}
	$items[$menu->slug] = $menu->name;
	}
	return $items;
}