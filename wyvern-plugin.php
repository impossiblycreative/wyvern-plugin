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

/* Include all of the custom post type classes in the folder */
function wyvern_plugin_include_CPTs() {

    // Set our glob path.
    $glob_path = plugin_dir_path( __FILE__ ) . 'post-types/post-type-classes/*.php';

    // Get all the possible CPT classes
    $classes = glob( $glob_path );
    
    // Require the base class first
    require_once plugin_dir_path( __FILE__ ) . 'post-types/class-wyvern-cpt-base.php';

    // Load the remaining CPTs
    foreach ( $classes as $class ) {
        require_once $class;
    }
}
add_action( 'init', 'wyvern_plugin_include_CPTs' );

/* Register all of the custom post types - MUST BE DONE MANUALLY */
function wyvern_plugin_register_CPTs() {

    // Get an instance of each post type
    $faqs = new Wyvern_FAQs();

    // Call the registration function
    $faqs->register_post_type();

    // Call the taxonomy setup functions if needed here
    $faqs->register_taxonomy();
}
add_action( 'init', 'wyvern_plugin_register_CPTs' );

/* Define the activation hooks */
function wyvern_plugin_activate() {

    // Create our custom post types
    wyvern_plugin_include_CPTs();
    wyvern_plugin_register_CPTs();

    // Reset the permalinks
    flush_rewrite_rules();

    // Need to do other stuff on activation? It goes here.
}

function wyvern_plugin_deactivate() {
    
    // Destroy our custom post types using unregister_post_type()
    unregister_post_type( 'wyvern_faqs' );

    // Reset the permalinks
    flush_rewrite_rules();

    // Need to do other stuff on deactivation? It goes here.
}

/* Set the activation hooks */
register_activation_hook( __FILE__, 'wyvern_plugin_activate' );
register_deactivation_hook( __FILE__, 'wyvern_plugin_deactivate' );

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