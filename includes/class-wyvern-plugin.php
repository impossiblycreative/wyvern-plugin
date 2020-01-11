<?php

/**
 * Define the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Wyvern_Plugin/includes
 */

/**
 * The core plugin class.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wyvern_Plugin/includes
 * @author     Adam Soucie <adam@impossiblycreative.com>
 */
class Wyvern_Plugin {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_version    The current version of the plugin.
	 */
	protected $plugin_version;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
    protected $plugin_name;

    /**
     * The admin hooks for the plugin.
     * 
     * @since   1.0.0
     * @access  protected
     * @var     array       $admin_hooks    Dual array of actions and filters used for the admin side of the plugin.
     */
    protected $admin_hooks;

    /**
     * The public hooks for the plugin.
     * 
     * @since   1.0.0
     * @access  protected
     * @var     array       $public_hooks    Dual array of actions and filters used for the public side of the plugin.
     */
    protected $public_hooks;
    
	/**
     * Set all our defaults and get the plugin ready for action.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        
        // Make sure we have a minimum version set
        if ( defined( 'WYVERN_PLUGIN_VERSION' ) ) {
			$this->version = WYVERN_PLUGIN_VERSION;
		} else {
			$this->plugin_version = '1.0.0';
        }
        
        // Set our plugin's internal name
        $this->plugin_name = 'wyvern-plugin';

        // Set our plugin's textdomain
        add_action( 'init', array( $this, 'set_textdomain' ) );

        // Set up our admin hook arrays
        $this->admin_hooks['actions'] = array();
        $this->admin_hooks['filters'] = array();

        // Set up our public hook arrays
        $this->public_hooks['actions'] = array();
        $this->public_hooks['filters'] = array();

        // Make sure all of our custom hooks are declared
        $this->declare_admin_hooks();
        $this->declare_public_hooks();
    }

    /**
     * Set the textdomain.
     */
    public function set_textdomain() {
        load_plugin_textdomain( 'wyvern-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Declare any admin-facing hooks.
     */
    private function declare_admin_hooks() {
    }

    /**
     * Declare any public-facing hooks.
     */
    private function declare_public_hooks() {
    }
        
    /**
     * Start the plugin.
     *
     * @since    1.0.0
     */
    public function start() {

        // Add our admin actions
        $actions = $this->admin_hooks['actions'];

        foreach ( $actions as $action ) {
            add_action( $action['hook'], array( $action['instance'], $action['callback'] ), $action['priority'], $action['num_args'] );
        }

        // Add our admin filters
        $filters = $this->admin_hooks['filters'];

        foreach ( $filters as $filter ) {
            add_action( $filter['hook'], array( $filter['instance'], $filter['callback'] ), $filter['priority'], $filter['num_args'] );
        }

        // Add our public actions
        $actions = $this->public_hooks['actions'];

        foreach ( $actions as $action ) {
            add_action( $action['hook'], array( $action['instance'], $action['callback'] ), $action['priority'], $action['num_args'] );
        }

        // Add our public filters
        $filters = $this->public_hooks['filters'];

        foreach ( $filters as $filter ) {
            add_action( $filter['hook'], array( $filter['instance'], $filter['callback'] ), $filter['priority'], $filter['num_args'] );
        }
    }

    /**
     * Utility function to add an admin hook to the appropriate admin hooks array.
     */
    private function add_admin_hook( $type, $hook, $instance, $callback, $priority = 10, $num_args = 1 ) {
        $new_hook = array(
            'hook'      => $hook,
            'instance'  => $instance,
            'callback'  => $callback,
            'priority'  => $priority,
            'num_args'  => $num_args
        );

        switch ( $type ) {
            case 'action':
                $this->admin_hooks['actions'][] = $new_hook;
                break;
    
            case 'filter':
                $this->admin_hooks['filters'][] = $new_hook;
                break;
            
            default:
                break;
        }
    }

    /**
     * Utility function to add a public hook to the appropriate public hooks array.
     */
    private function add_public_hook( $type, $hook, $instance, $callback, $priority = 10, $num_args = 1 ) {
        $new_hook = array(
            'hook'      => $hook,
            'instance'  => $instance,
            'callback'  => $callback,
            'priority'  => $priority,
            'num_args'  => $num_args
        );

        switch ( $type ) {
            case 'action':
                $this->public_hooks['actions'][] = $new_hook;
                break;
    
            case 'filter':
                $this->public_hooks['filters'][] = $new_hook;
                break;
            
            default:
                break;
        }
    }
}