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
			 $locale = esc_attr($instance['locale']);
			 $timezone = esc_attr($instance['timezone']);
			 $animate = esc_attr($instance['animate']) == "true";
		} else {
			$locale = '';
			$timezone = '';
			$animate = false;
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('locale'); ?>"><?php _e('Locale', 'wpds-clock'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('locale'); ?>" name="<?php echo $this->get_field_name('locale'); ?>">
				<option value=""><?=__('(Use client default)')?></option>
			</select>
			<script>
				jQuery(function(){
					moment.locales().forEach(function(entry) {
						jQuery('#<?php echo $this->get_field_id('locale'); ?>').append(jQuery('<option>', {
							value: entry,
							text: entry,
							selected: '<?=$locale?>' == entry
						}));
					});
				});
			</script>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('timezone'); ?>"><?php _e('Timezone', 'wpds-clock'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('timezone'); ?>" name="<?php echo $this->get_field_name('timezone'); ?>">
				<option value=""><?=__('(Use client default)')?></option>
			</select>
			<script>
				jQuery(function(){
					moment.tz.names().forEach(function(entry) {
						jQuery('#<?php echo $this->get_field_id('timezone'); ?>').append(jQuery('<option>', {
							value: entry,
							text: entry,
							selected: '<?=$timezone?>' == entry
						}));
					});
				});
			</script>
		</p>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('animate'); ?>" name="<?php echo $this->get_field_name('animate'); ?>" value="true" <?php echo $animate ? ' checked="checked"' : '';?>>
			<label for="<?php echo $this->get_field_id('animate'); ?>"><?php _e('Animate', 'wpds-clock'); ?></label>
		</p>
		<?php
	}

	/**
	* Update widget
	*/
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		// Fields
		$instance['locale'] = strip_tags($new_instance['locale']);
		$instance['timezone'] = strip_tags($new_instance['timezone']);
		$instance['animate'] = strip_tags($new_instance['animate']);
		return $instance;
	}

	/**
	* Display widget
	*/
	function widget($args, $instance) {
		extract( $args );
		// these are the widget options
		$locale = $instance['locale'];
		$timezone = $instance['timezone'];
		$animate = $instance['animate'] == "true";
		echo $before_widget;
		// Display the widget
		echo '<div class="clock"';
		if (!empty($locale)) {
			echo ' data-locale="' . $locale . '"';
		}	
		if (!empty($timezone)) {
			echo ' data-timezone="' . $timezone . '"';
		}	
		echo '><ul>',
		'<li class="clock-hours"> </li>',
		'<li class="clock-point' . ( $animate ? ' clock-point-animated' : '' ) . '">:</li>',
		'<li class="clock-minutes"> </li>',
		'</ul><div class="clock-date"></div></div>';
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

	wp_register_script( 'moment-js', plugins_url( '/moment-with-locales.min.js', __FILE__ ), array(), false, true );
	wp_register_script( 'moment-timezone-js', plugins_url( '/moment-timezone-with-data.min.js', __FILE__ ), array('moment-js'), false, true );
	wp_register_script( 'wpds-clock-script', plugins_url( '/clock.js', __FILE__ ), array('jquery', 'moment-timezone-js'), false, true );
	wp_enqueue_script( 'wpds-clock-script' );
}
add_action( 'wp_enqueue_scripts', 'wpds_clock_load_styles' );

function wpds_clock_selectively_enqueue_admin_script( $hook ) {
	if ( 'widgets.php' == $hook ) {
		wp_enqueue_script( 'moment-js', plugin_dir_url( __FILE__ ) . 'moment-with-locales.min.js' );
		wp_enqueue_script( 'moment-timezone-js', plugin_dir_url( __FILE__ ) . 'moment-timezone-with-data.min.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'wpds_clock_selectively_enqueue_admin_script' );
