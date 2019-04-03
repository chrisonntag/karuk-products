<?php

/**
 * Custom Product Post Type
 *
 * @link       chrisonntag.com
 * @since      1.0.0
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 */

/**
 * Custom Product Post Type.
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 * @author     Christoph Sonntag <info@chrisonntag.com>
 */
class Karuk_Products_Post_Type {

	private $slug;

	public function __construct() {
		$this->slug = 'products';
	}

	public function create_products() {

			register_post_type('products', array(
				'labels' => array(
					'name' => __('Products', 'karuk-products'),
					'singular_name' => __('Product', 'karuk-products'),
					'add_new' => __('Add', 'karuk-products'),
					'add_new_item' => __('Add new product', 'karuk-products'),
					'edit' => __('Edit', 'karuk-products'),
					'edit_item' => __('Edit product', 'karuk-products'),
					'new_item' => __('New product', 'karuk-products'),
					'view' => __('View', 'karuk-products'),
					'view_item' => __('View product', 'karuk-products'),
					'search_items' => __('Search products', 'karuk-products'),
					'not_found' => __('Product not found', 'karuk-products'),
					'not_found_in_trash' => __('Product is not found in trash', 'karuk-products'),
					'menu_name'     => __('Products', 'karuk-products'),
				),
				'public' => true,
				'menu_position' => 30,
				'show_in_nav_menus' => true,
				'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
				'taxonomies' => array('karuk_products_category', 'post_tag'),
				'has_archive' => true,
				'rewrite' => array('slug' => $this->slug, 'with_front' => false),
				'show_in_rest' => true,
				'can_export' => true
			)
		);

	}

}
