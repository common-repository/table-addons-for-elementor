<?php
/**
 * Plugin Name:	Table Addons for Elementor
 * Description: Table Widget for elementor page builder. Effortlessly create stunning and functional tables on Elementor.
 * Plugin URI:  https://fusionplugin.com/plugins/table-addons-for-elementor/
 * Version:     2.1.3
 * Elementor tested up to: 3.22.1
 * Elementor Pro tested up to: 3.22.1
 * Author:      FusionPlugin
 * Author URI:  https://fusionplugin.com/
 * License:		GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:	table-addons-for-elementor
 * Domain Path:	/languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'TABLE_ADDONS_FOR_ELEMENTOR_VERSION', '2.1.3' );
define( 'TABLE_ADDONS_FOR_ELEMENTOR__BASE', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-table-addons-for-elementor-activator.php
 */
function activate_table_addons_for_elementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-table-addons-for-elementor-activator.php';
	Table_Addons_For_Elementor_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-table-addons-for-elementor-deactivator.php
 */
function deactivate_table_addons_for_elementor() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-table-addons-for-elementor-deactivator.php';
	Table_Addons_For_Elementor_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_table_addons_for_elementor' );
register_deactivation_hook( __FILE__, 'deactivate_table_addons_for_elementor' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-table-addons-for-elementor.php';

/**
 * Begins execution of the plugin.
 * @since    1.0.0
 */
function run_table_addons_for_elementor() {

	$plugin = new Table_Addons_For_Elementor();
	$plugin->run();

}
run_table_addons_for_elementor();
