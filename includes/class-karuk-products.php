<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       chrisonntag.com
 * @since      1.0.0
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 * @author     Christoph Sonntag <info@chrisonntag.com>
 */
class Karuk_Products {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Karuk_Products_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The prefix used for custom fields in meta boxes.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prefix    The string used for custom fields.
	 */
	protected $prefix;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	protected $html_table;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'KARUK_PRODUCTS_VERSION' ) ) {
			$this->version = KARUK_PRODUCTS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'karuk-products';
		$this->prefix = 'kp_';

		$this->html_table = '<table class="table is-fullwidth is-hoverable"><tbody><tr><td>Feature</td><td>Name</td></tr><tr><td></td><td></td></tr></tbody></table>';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Karuk_Products_Loader. Orchestrates the hooks of the plugin.
	 * - Karuk_Products_i18n. Defines internationalization functionality.
	 * - Karuk_Products_Admin. Defines all hooks for the admin area.
	 * - Karuk_Products_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-karuk-products-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-karuk-products-public.php';

		/**
		 * Custom Taxonomy meta box
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/Tax-meta-class/Tax-meta-class.php';

		/**
		 * Custom post type meta box
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/meta-box-class/my-meta-box-class.php';

		/**
		 * The class responsible for defining the product post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-post-type.php';

		/**
		 * The class responsible for defining the custom taxonomy for product categories.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-categories-taxonomy.php';

		/**
		 * Used in order to store further information within the custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-metabox-main.php';

		/**
		 * Used in order to store further information within the custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-karuk-products-metabox-info.php';

		$this->loader = new Karuk_Products_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Karuk_Products_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Karuk_Products_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Karuk_Products_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Define custom taxonomy and post-type.
		$category_taxonomy = new Karuk_Product_Category_Taxonomy();
		$products_post_type = new Karuk_Products_Post_Type();
		$this->loader->add_action( 'init', $category_taxonomy, 'create_product_category' );
		$this->loader->add_action( 'init', $products_post_type, 'create_products' );

		// Register metabox and save function when publishing the custom post-type.
		$karuk_products_meta_config_datasheet = array(
	    'id'             => 'products_meta_box_datasheet',    // meta box id, unique per meta box
	    'title'          => 'Datasheet',          				// meta box title
	    'pages'          => array('products'),      // post types, accept custom post types as well, default is array('post'); optional
	    'context'        => 'normal',            		// where the meta box appear: normal (default), advanced, side; optional
	    'priority'       => 'high',            			// order of meta box: high (default), low; optional
	    'fields'         => array(),            		// list of meta fields (can be added by field arrays)
	    'local_images'   => false,          				// Use local or hosted images (meta box images for add/remove)
	    'use_with_theme' => false          					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	  );
	  $karuk_products_meta_config_info = array(
	    'id'             => 'products_meta_box_info',    // meta box id, unique per meta box
	    'title'          => 'Info',          				// meta box title
	    'pages'          => array('products'),      // post types, accept custom post types as well, default is array('post'); optional
	    'context'        => 'normal',            		// where the meta box appear: normal (default), advanced, side; optional
	    'priority'       => 'high',            			// order of meta box: high (default), low; optional
	    'fields'         => array(),            		// list of meta fields (can be added by field arrays)
	    'local_images'   => false,          				// Use local or hosted images (meta box images for add/remove)
	    'use_with_theme' => false          					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	  );
	  if ( is_admin() ) {
	  	// Datasheet box
	  	$karuk_products_meta_datasheet = new AT_Meta_Box($karuk_products_meta_config_datasheet);

	  	$karuk_products_meta_datasheet->addCheckbox($this->prefix.'top_product', array('name'=> 'Top Product', 'desc' => 'Check if this product should be shown among the top products.'));

	  	$repeater_fields_images[] = $karuk_products_meta_datasheet->addImage($this->prefix.'product_image_field_id',array('name'=> 'Product Image'),true);
	  	$karuk_products_meta_datasheet->addRepeaterBlock($this->prefix.'product_images',array(
		    'inline'   => true, 
		    'name'     => 'Product Images',
		    'fields'   => $repeater_fields_images, 
		    'sortable' => true
		  ));

	  	$karuk_products_meta_datasheet->addText($this->prefix.'datasheet', array('name'=> 'Datasheet Link'));
	  	$karuk_products_meta_datasheet->addText($this->prefix.'manufacturer', array('name'=> 'Manufacturer Link'));
	  	$karuk_products_meta_datasheet->addWysiwyg($this->prefix.'products_table', array(
	  		'name'=> 'Facts Table', 
	  		'std' => $this->html_table,
	  		'style' => 'width: 100%;',
	  	));

	  	$karuk_products_meta_datasheet->Finish();	

	  	//Info box
	  	$karuk_products_meta_info = new AT_Meta_Box($karuk_products_meta_config_info);

	  	$repeater_fields_downloads[] = $karuk_products_meta_info->addFile($this->prefix.'product_file_field_id',array('name'=> 'File'),true);
	  	$karuk_products_meta_info->addRepeaterBlock($this->prefix.'product_files', array(
		    'inline'   => true, 
		    'name'     => 'Files',
		    'fields'   => $repeater_fields_downloads, 
		    'sortable' => false
		  ));
		  $karuk_products_meta_info->addText($this->prefix.'info_title', array('name'=> 'Title'));
		  $karuk_products_meta_info->addWysiwyg($this->prefix.'info_content', array('name'=> 'Content'));

		  $karuk_products_meta_info->Finish();
	  }

		register_taxonomy_for_object_type( 'karuk_products_category', 'products' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Karuk_Products_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Register custom templates for post-type.
		$this->loader->add_filter( 'single_template', $plugin_public, 'load_products_template');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Karuk_Products_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
