<?php
/**
 * Wyvern Plugin (change me)
 *
 * @package           Wyvern_Plugin
 * @since             1.0.0
 * @author            Adam Soucie, Impossibly Creative
 * @copyright         2020 Impossibly Creative
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Wyvern Plugin (change me)
 * Plugin URI:        https://example.com/plugin-name
 * Description:       Description of the plugin.
 * 
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * 
 * Author:            Adam Soucie
 * Author URI:        https://adamsoucie.com
 * Text Domain:       wyvern-plugin
 * 
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/* Plugin Version - UPDATE THIS */
define( 'WYVERN_PLUGIN_VERSION', '1.0.0' );

/* Define the activation hooks */
function activate_wyvern_plugin() {
    // Need to do stuff on activation? It goes here.
}

function deactivate_wyvern_plugin() {
    // Need to do stuff on deactivation? It goes here.
}

/* Set the activation hooks */
register_activation_hook( __FILE__, 'activate_wyvern_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_wyvern_plugin' );

/**
 * Include our main plugin class, where we'll connect all the other pieces.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wyvern-plugin.php';

/**
 * Kick off the plugin.
 */
function wyvern_plugin_start() {
    $plugin = new Wyvern_Plugin();
    $plugin->start();
}

/* Start the engines! */
wyvern_plugin_start();