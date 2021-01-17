<?php

/**
 * The file that defines a metabox for our custom post type.
 *
 * A class definition that includes attributes and functions used for 
 * registering a metabox.
 *
 * @link       chrisonntag.com
 * @since      1.0.0
 *
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 */

/**
 * Registers a metabox for the custom post type in order to store 
 * further information within the post.
 *
 * @since      1.0.0
 * @package    Karuk_Products
 * @subpackage Karuk_Products/includes
 * @author     Christoph Sonntag <info@chrisonntag.com>
 */
class Karuk_Products_Metabox_Info {

	/**
	 * Used for the database as a prefix.
	 */
	protected $prefix;

	/**
	 * Array which holds our defined fields.
	 */
	protected $fields;

	/*
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct($pref) {
		$this->prefix = $pref;
	}

	public function add_actions() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save_product_information' ) );

		$this->fields = array(
			array(
				'name' => __('Info title 1', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_title_1',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Info content 1', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_content_1',
				'type' => 'textarea',
				'std' => ''
			),
			array(
				'name' => __('Info title 2', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_title_2',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Info content 2', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_content_2',
				'type' => 'textarea',
				'std' => ''
			),
			array(
				'name' => __('Info title 3', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_title_3',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => __('Info content 3', 'karuk-products'),
				'desc' => __('', 'karuk-products'),
				'id' => $this->prefix . 'info_content_3',
				'type' => 'textarea',
				'std' => ''
			)
		);
	}

	/*
	 * Adds the meta box container.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array('products'); //limit meta box to certain post types
		if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'products_meta_box_info'
				,__( 'Info', 'karuk-products' )
				,array( $this, 'render_meta_box_content' )
				,$post_type
				,'normal'
				,'high'
			);
		}
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_product_information( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['products_meta_box_info_nonce'] ) )
			return $post_id;

		$nonce = $_POST['products_meta_box_info_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'karuk_products_inner_meta_box_info' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
				} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		// OK, its safe for us to save the data now.
		foreach ($this->fields as $field) {
			if (isset($_POST[$field['id']])) {
				// POST field sent - update
				//$new = sanitize_text_field ( $_POST [$field[ 'id' ]] );
				$new =  $_POST [$field[ 'id' ]] ;
				update_post_meta($post_id, $field['id'], $new);
			} else {
				// POST field not sent - delete
				$old = get_post_meta($post_id, $field['id'], true);
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'karuk_products_inner_meta_box_info', 'products_meta_box_info_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, '_my_meta_value_key', true );

		// Display the form, using the current value.
		echo '<p><i>'. __('Enter title and content for the information boxes here. They accept HTML code as well.', 'karuk-products') .'</i></p>';
		echo '<table class="form-table">';
		foreach ($this->fields as $field) {
		// get current post meta data
			$meta = get_post_meta($post->ID, $field['id'], true);
			echo '<tr>',
			'<th style="width:20%"><label for="'. __($field['name'],'karuk-products'). '">', __($field['name'],'karuk-products'), '</label></th>',
			'<td>';
			switch ($field['type']) {
				case 'text':
					echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '<br />'. __($field['desc'],'karuk-products').'';
					break;
				case 'textarea':
					echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />'. __($field['desc'],'karuk-products').'';
					break;
			}
			echo '</td><td>',
			'</td></tr>';
		}
		echo '</table>';
	}
}
