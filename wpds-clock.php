<?php

/*
Plugin Name: WPDS Clock Widget
Plugin URI: http://pixelydo.com/work/wordpress-digital-signage/
Description: The clock for WPDS. Many thanks to <a href="https://twitter.com/Bluxart" target="_blank">@Bluxart</a> for <a href="http://www.alessioatzeni.com/blog/css3-digital-clock-with-jquery" target="_blank">the original clock</a>.
Author: Nate Jones
Version: 1.0
Author URI: http://pixelydo.com/
Text Domain: wpds-clock
*/

// Load text domain
function wpds_clock_load_plugin_textdomain() {
    load_plugin_textdomain( 'wpds-clock', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'wpds_clock_load_plugin_textdomain' );

class wpds_clock_widget extends WP_Widget {

	/**
	* Constructor
	*/
	function __construct() {
		parent::__construct(
			'wpds-clock-widget',
			__('The Clock', 'wpds-clock'),
			array(
				'description' => __( 'A simple digital clock for the dock.', 'wpds-clock' ), 
			)
		);
	}

	/**
	* Widget form creation
	*/
	function form($instance) {

		// Check values
		if( $instance) {
			 $select = esc_attr($instance['select']);
		} else {
		     $place = '';
		     $select = '';
		}
		?>
<p><?=__('Nothing to do here.', 'wpds-clock')?></p>
<p style="display:none;">
	<label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('12 or 24 hour', 'wpds-clock'); ?></label>
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

	/**
	* Update widget
	*/
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['select'] = strip_tags($new_instance['select']);
		return $instance;
	}

	/**
	* Display widget
	*/
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$select = $instance['select'];
		echo $before_widget;
		// Display the widget
		echo '<div class="clock"><ul><li class="clock-hours"> </li><li class="clock-point">:</li><li class="clock-minutes"> </li></ul><div class="clock-date"></div></div>';
		echo $after_widget;
	}
}

/**
* Register and load the widget
*/
function wpds_clock_load_widget() {
    register_widget( 'wpds_clock_widget' );
}
add_action( 'widgets_init', 'wpds_clock_load_widget' );

/**
* Load styles
*/
function wpds_clock_load_styles()
{
	wp_register_style( 'wpds_clock-style', plugins_url( '/clock.css', __FILE__ ) );
	wp_enqueue_style( 'wpds_clock-style' );

	wp_register_script( 'wpds-clock-script', plugins_url( '/clock.js', __FILE__ ), array('jquery'), false, true );
	wp_enqueue_script( 'wpds-clock-script' );
}
add_action( 'wp_enqueue_scripts', 'wpds_clock_load_styles' );
