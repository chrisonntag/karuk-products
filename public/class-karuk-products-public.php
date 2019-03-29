<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       chrisonntag.com
 * @since      1.0.0
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/public
 * @author     Christoph Sonntag <info@chrisonntag.com>
 */
class Karuk_Products_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the template for our custom post-type.
	 *
	 * @since    1.0.0
	 */
	public function load_products_template($template) {
		global $post;

    if ($post->post_type == "products" && $template !== locate_template(array("single-product.php"))){
        return plugin_dir_path( __FILE__ ) . "partials/single-product.php";
    }

    return $template;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Karuk_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Karuk_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/karuk-products-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lightslider.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Karuk_Products_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Karuk_Products_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'_lightslider', plugin_dir_url( __FILE__ ) . 'js/lightslider.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/karuk-products-public.js', array( 'jquery', $this->plugin_name.'_lightslider' ), $this->version, true );

	}

}
