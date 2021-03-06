<?php

/**
 * Custom Taxonomy for Product Category
 *
 * @link       chrisonntag.com
 * @since      1.0.0
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 */

/**
 * Custom Taxonomy for Product Category.
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 * @author     Christoph Sonntag <info@chrisonntag.com>
 */
class Karuk_Product_Category_Taxonomy {

	private $slug;

	public function __construct() {
		$this->slug = 'karuk_products_category';
	}

	public function create_product_category() {

			// Second attribute $object_type is custom post-type products
			register_taxonomy(
				$this->slug, 'products', array(
					'labels' => array(
						'name' => __('Product Category', 'karuk-products'),
						'add_new_item' => __('Add category', 'karuk-products'),
						'new_item_name' => __('New category', 'karuk-products'),
						'menu_name' => __('Product Categories', 'karuk-products'),
					),
					'show_ui' => true,
					'show_admin_column' => true,
					'show_in_nav_menus' => true,
					'show_tagcloud' => false,
					'hierarchical' => true,
					'rewrite' => array('slug' => 'categories', 'hierarchical' => true, 'with_front' => false)
				)
			);

	}

}
