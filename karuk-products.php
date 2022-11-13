<?php
error_reporting(E_ERROR | E_PARSE);

/**
 * The main Karuk Products file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              christophsonntag.com
 * @since             1.0.0
 * @package           Karuk_Products
 *
 * @wordpress-plugin
 * Plugin Name:       Karuk Products
 * Plugin URI:        github.com/chrisonntag/karuk-products
 * Description:       This plugin adds a products management area to WordPress.
 * Version:           1.0.1
 * Author:            Christoph Sonntag
 * Author URI:        christophsonntag.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       karuk-products
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
define( 'KARUK_PRODUCTS_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-karuk-products-activator.php
 */
function activate_karuk_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-karuk-products-activator.php';
	Karuk_Products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-karuk-products-deactivator.php
 */
function deactivate_karuk_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-karuk-products-deactivator.php';
	Karuk_Products_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_karuk_products' );
register_deactivation_hook( __FILE__, 'deactivate_karuk_products' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-karuk-products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_karuk_products() {

	$plugin = new Karuk_Products();
	$plugin->run();

}
run_karuk_products();
