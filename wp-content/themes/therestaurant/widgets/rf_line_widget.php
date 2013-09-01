<?php
/*
 * Plugin Name: Custom Line widget
 * Plugin URI: http://www.redfactory.nl
 * Description: A widget that displays a seperation line
 * Version: 1.0
 * Author: Red Factory
 * Author URI: http://www.redfactory.nl
 */



// Register widget
function rf_line_widget() {
	register_widget( 'rf_line_widget' );
}
add_action( 'widgets_init', 'rf_line_widget' );

// Widget class
class rf_line_widget extends WP_Widget {

	function rf_line_widget() {
		$widget_ops = array( 'classname' => 'rf_line_widget', 'description' => 'A widget that can be used as an horizontal seperation line.');
		$control_ops = array( 'width' => 200, 'height' => 100, 'id_base' => 'rf_line_widget' );
		$this->WP_Widget( 'rf_line_widget', 'Custom Line Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) { ?>
		<div class="widget_line"></div>
    <?php }
}
?>