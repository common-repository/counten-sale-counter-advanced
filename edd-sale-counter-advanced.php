<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://teconce.com/about/
 * @since             1.0.0
 * @package           Edd_Sale_Counter_Advanced
 *
 * @wordpress-plugin
 * Plugin Name:       EDD Sale Counter Advanced
 * Plugin URI:        https://teconce.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1
 * Author:            Nazmus Shadhat
 * Author URI:        https://teconce.com/about/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       edd-sale-counter-advanced
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'EDD_SALE_COUNTER_ADVANCED_VERSION', '1.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-edd-sale-counter-advanced-activator.php
 */
function activate_edd_sale_counter_advanced() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-edd-sale-counter-advanced-activator.php';
	Edd_Sale_Counter_Advanced_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-edd-sale-counter-advanced-deactivator.php
 */
function deactivate_edd_sale_counter_advanced() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-edd-sale-counter-advanced-deactivator.php';
	Edd_Sale_Counter_Advanced_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_edd_sale_counter_advanced' );
register_deactivation_hook( __FILE__, 'deactivate_edd_sale_counter_advanced' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-edd-sale-counter-advanced.php';
require plugin_dir_path( __FILE__ ) . 'admin/vendors/codestar-framework/codestar-framework.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_edd_sale_counter_advanced() {

	$plugin = new Edd_Sale_Counter_Advanced();
	$plugin->run();

}
run_edd_sale_counter_advanced();
