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

        // Load any dependency files here

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

        // Register our custom Gutenberg blocks
        add_filter( 'block_categories', array( $this, 'create_block_categories' ) );
        add_action( 'init', array( $this, 'register_custom_blocks' ) );

        // Register any post meta & associated scripts created by the plugin
        add_action( 'init', array( $this, 'register_post_meta' ) );
        add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_sidebar_assets' ) );
    }

    /**
     * Set the textdomain.
     */
    public function set_textdomain() {
        load_plugin_textdomain( 'wyvern-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Registers any post meta created by the custom post types
     */
    public function register_post_meta() {
        register_post_meta( 'post', 'feature_post', array(
            'type'          => 'boolean',
            'default'       => true,
            'single'        => true,
            'show_in_rest'  => true,
            'auth_callback' => function() { 
                return current_user_can( 'edit_posts' );
            },
        ) );
    }

    /**
     * Enqueues any assets needed in the editor for the plugin
     */
    public function block_editor_sidebar_assets() {
        $screen = get_current_screen();

        if ( $screen->post_type === 'post' ) {
            wp_enqueue_script(
                'wyvern-plugin-post-meta',
                plugins_url( 'assets/js/build/post-meta.js', __DIR__ ),
                array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
                $this->$plugin_version,
            );
        }
    }

    /** 
     * Register a custom block.
     * 
     * @since   1.0.0
     * @access  private
     * @var     string      $block_name The namespace friendly name of the block
     */
    private function register_custom_block( $block_name, $block_attributes = '' ) {
        $plugin_path        = plugin_dir_path( __DIR__ ) . 'blocks/' . $block_name;
        $render_file        = plugin_dir_path( __DIR__ ) . 'blocks/' . $block_name . '/src/render.php';
        $render_callback    = '';
        $styles             = plugins_url( 'blocks/' . $block_name . '/css/style.css', __DIR__ );
        $editor_styles      = plugins_url( 'blocks/' . $block_name . '/css/editor.css', __DIR__ );

        // Clear the stat cache so that file_exists behaves properly
        clearstatcache();

        // Include the render callback file
        if ( file_exists( $render_file ) ) {
            include_once( $render_file );
            $render_callback = str_replace( '-', '_', $block_name ) . '_render_callback';
        }

        // Automatically load dependencies and version
        $asset_file = include( $plugin_path . '/build/index.asset.php' );


        // Make the script available to WordPress
        wp_register_script( 
            $block_name, 
            plugins_url( 'blocks/' . $block_name . '/build/index.js', __DIR__ ), 
            $asset_file['dependencies'], 
            $asset_file['version'] 
        );

        // Register the front-end and editor stylesheets IF the file size is > 0.
        $block_styles_name  = NULL;
        $editor_styles_name = NULL;

        if ( file_get_contents( $editor_styles ) ) {
            wp_register_style(
                $block_name . '-editor',
                $editor_styles,
                array( 'wp-edit-blocks' ), 
                $asset_file['version']
            );

            $editor_styles_name = $block_name . '-editor';
        }

        if ( file_get_contents( $styles ) ) {
            wp_register_style(
                $block_name,
                $styles,
                array(), 
                $asset_file['version']
            );

            $block_styles_name = $block_name;
        }

        // Register the block
        register_block_type( 'wyvern-plugin/' . $block_name, array(
            'attributes'        => $block_attributes,
            'editor_style'      => $editor_styles_name,
            'editor_script'     => $block_name,
            'render_callback'   => $render_callback,
            'style'             => $block_styles_name,
        ) );
    }

    /**
     * Register our blocks.
     */
    public function register_custom_blocks() {

        // Set each block's attributes
        $featured_carousel = array(
            'className' => array(
                'type'      => 'string',
                'default'   => '',
            ),
        );

        // FAQs container
        $faqs = array(
            'className' => array(
                'type'      => 'string',
                'default'   => '',
            ),
            'faqCategory' => array(
                'type'      => 'string',
            ),
        );

        // Register each block we need
        $this->register_custom_block( 'featured-carousel', $featured_carousel );
        $this->register_custom_block( 'faqs', $faqs );
    }

    /**
     * Create our custom block categories.
     */
    public function create_block_categories( $categories ) {

        // Create our categories
        $new_category = array(
            'slug'  => 'wyvern-blocks',
            'title' => __( 'Wyvern Blocks', 'wyvern-plugin' ),
            'icon'  => null,
        );

        // Get all of our current block categories
        $slugs = wp_list_pluck( $categories, 'slug' );

        // If the category exists, exit. Otherwise, add the category we want
        return in_array( 'wyvern-blocks', $slugs, true ) ? $categories : array_merge( $categories, array( $new_category ) );
    }

    /**
     * Add columns to the appropriate post screens
     */
    public function custom_posts_columns( $columns ) {
        $columns = array(
            'cb'            => $columns['cb'],
            'title'         => __( 'Title', 'wyvern-plugin' ),
            'author'        => __( 'Written By', 'wyvern-plugin' ),
            'categories'    => __( 'Categories', 'wyvern-plugin' ),
            'tags'          => __( 'Tagged With', 'wyvern-plugin' ),
            'featured'      => __( 'Featured?', 'wyvern-plugin' ),
            'likes'         => __( 'Likes', 'wyvern-plugin' ),
            'comments'      => __( 'Comments', 'wyvern-plugin' ),
            'date'          => __( 'Posted On', 'wyvern-plugin' ),
        );
    
        return $columns;
    }

    public function custom_posts_columns_content( $column, $post_id ) {
        // Featured Post flag
        if ( 'featured' === $column ) {
            $is_featured = get_post_meta( $post_id, 'feature_post', true );
            echo ( $is_featured ) ? __( 'Featured', 'wyvern-plugin' ) : __( 'No', 'wyvern-plugin' );
        }

        // Post Likes
        if ( 'likes' === $column ) {
            $like_count = get_post_meta( $post_id, '_wyvern_likes', true ) ? get_post_meta( $post_id, '_wyvern_likes', true ) : 0;
            echo $like_count;
        }
    }

    public function custom_wyvern_faqs_columns( $columns ) {
        $columns = array(
            'cb'                => $columns['cb'],
            'title'             => __( 'Title', 'wyvern-plugin' ),
            'faq-categories'    => __( 'FAQ Categories', 'wyvern-plugin' ),
        );

        return $columns;
    }

    public function custom_wyvern_faqs_columns_content( $column, $post_id ) {
        // Categories - use the custom taxonomy
        if ( 'faq-categories' === $column ) {
            $categories = get_the_terms( $post_id, 'wyvern_faq_categories' );

            for ( $i = 0; $i < count( $categories ); $i++ ) {
                $name = $categories[$i]->name;

                if ( $i !== 0 ) {
                    echo ', ';
                }

                echo '<a href="/wp-admin/edit.php?wyvern_faq_categories=' . sanitize_title( $name ) . '&post_type=wyvern_faqs">' . $name . '</a>'; 
            }
        }
    }

    /**
     * Declare any admin-facing hooks.
     */
    private function declare_admin_hooks() {
        $this->add_admin_hook( 'filter', 'manage_posts_columns', $this, 'custom_posts_columns' );
        $this->add_admin_hook( 'action', 'manage_posts_custom_column', $this, 'custom_posts_columns_content', 10, 2 );

        $this->add_admin_hook( 'filter', 'manage_wyvern_faqs_posts_columns', $this, 'custom_wyvern_faqs_columns' );
        $this->add_admin_hook( 'action', 'manage_wyvern_faqs_posts_custom_column', $this, 'custom_wyvern_faqs_columns_content', 10, 2 );
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
            add_filter( $filter['hook'], array( $filter['instance'], $filter['callback'] ), $filter['priority'], $filter['num_args'] );
        }

        // Add our public actions
        $actions = $this->public_hooks['actions'];

        foreach ( $actions as $action ) {
            add_action( $action['hook'], array( $action['instance'], $action['callback'] ), $action['priority'], $action['num_args'] );
        }

        // Add our public filters
        $filters = $this->public_hooks['filters'];

        foreach ( $filters as $filter ) {
            add_filter( $filter['hook'], array( $filter['instance'], $filter['callback'] ), $filter['priority'], $filter['num_args'] );
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