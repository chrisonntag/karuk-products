<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Karuk
 * @since 	1.0.0
 */

class Karuk_Categories_Menu_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'karuk_categories_menu_widget',
			'Karuk Categories',
			array(
				'description' => __('Product Categories List', 'karuk-products')
			)
		);
		add_action('widgets_init', array($this, 'karuk_categories_menu_load_widget'));
	}

	public function karuk_categories_menu_load_widget() {
		register_widget('karuk_categories_menu_widget');
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);

		$c = ! empty( $instance['count'] ) ? '1' : '0';

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// This is where the code displays the output
		$taxonomy = 'karuk_products_category';
		$orderby = 'name';
		$show_count = $c;      // 1 for yes, 0 for no
		$pad_counts = 0;      // do not count products in subcategories
		$hierarchical = 1;      // 1 for yes, 0 for no

		$cat_args = array(
			'taxonomy' => $taxonomy,
			'orderby' => $orderby,
			'show_count' => $show_count,
			'pad_counts' => $pad_counts,
			'hierarchical' => $hierarchical,
			'title_li' => ''
		);
		echo '<ul>';
		wp_list_categories($cat_args);
		echo '</ul>';

		echo $args['after_widget'];
	}

	// Widget Backend
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Products Categories', 'karuk-products');
		}
		$count = isset($instance['count']) ? (bool) $instance['count'] : false;
		?>

		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts', 'karuk-products' ); ?></label></p><br />
	<?php
	}

	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		return $instance;
	}
}
?>
