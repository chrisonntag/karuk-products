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

		$this->$slug = 'products';
		add_action('init', array ($this, 'create_products'));

	}

	private function create_products() {

			register_post_type('products', array(
				'labels' => array(
					'name' => __('Products', 'karuk-products'),
					'singular_name' => __('Item', 'karuk-products'),
					'add_new' => __('Add', 'karuk-products'),
					'add_new_item' => __('Add new item', 'karuk-products'),
					'edit' => __('Edit', 'karuk-products'),
					'edit_item' => __('Edit item', 'karuk-products'),
					'new_item' => __('New item', 'karuk-products'),
					'view' => __('View', 'karuk-products'),
					'view_item' => __('View of items', 'karuk-products'),
					'search_items' => __('Search items', 'karuk-products'),
					'not_found' => __('Items not found', 'karuk-products'),
					'not_found_in_trash' => __('Item is not found in trash', 'karuk-products'),
				),
				'public' => true,
				'menu_position' => 30,
				'supports' => array('title', 'editor', 'thumbnail'),
				'taxonomies' => array('products_category'),
				'has_archive' => true,
				'rewrite' => array('slug' => $this->$slug, 'with_front' => false)
			)
		);

	}

}
