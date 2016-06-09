<?php

/*
Plugin Name: WPDS Clock Widget
Plugin URI: http://pixelydo.com/work/wordpress-digital-signage/
Description: The clock for WPDS
Author: Nate Jones
Version: 1.0
Author URI: http://pixelydo.com/
*/


class clock_plugin extends WP_Widget {

// constructor
		function clock_plugin() {
				parent::WP_Widget(false, $name = __('The Clock', 'wp_widget_plugin') );
		}

// widget form creation
function form($instance) {

// Check values
if( $instance) {
	 $select = esc_attr($instance['select']);
} else {
     $place = '';
     $select = '';
}
?>
<p>Nothing to do here. <em>Many thanks to <a href="https://twitter.com/Bluxart" target="_blank">@Bluxart</a> for <a href="http://www.alessioatzeni.com/blog/css3-digital-clock-with-jquery" target="_blank">the original clock</a></em></p>
<p style="display:none;">
	<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('12 or 24 hour', 'wp_widget_plugin'); ?></label>
	<select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
	<?php
	$options = array('12', '24');
	foreach ($options as $option) {
	echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
	}
	?>
	</select>
</p>
<?php
}
// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['select'] = strip_tags($new_instance['select']);
     return $instance;
}
// display widget
			function widget($args, $instance) {
				extract( $args );
				// these are the widget options
				$select = $instance['select'];
				echo $before_widget;
				// Display the widget
				echo '<script src="'. plugins_url( 'clock.js' , __FILE__ ) .'"></script>';
				echo '<div class="clock"><ul><li id="hours"> </li><li id="point">:</li><li id="min"> </li></ul><div id="Date"></div></div>';
				echo $after_widget;
			}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("clock_plugin");'));
