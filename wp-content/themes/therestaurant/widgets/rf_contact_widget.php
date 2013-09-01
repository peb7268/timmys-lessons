<?php
/*
 * Plugin Name: Custom Contact widget
 * Plugin URI: http://www.redfactory.nl
 * Description: A widget that displays social icons and contact info
 * Version: 1.0
 * Author: Red Factory
 * Author URI: http://www.redfactory.nl
 */



// Register widget
function rf_contact_widgets() {
	register_widget( 'rf_contact_widget' );
}
add_action( 'widgets_init', 'rf_contact_widgets' );

// Widget class
class rf_contact_widget extends WP_Widget {

	function rf_contact_widget() {
		$widget_ops = array( 'classname' => 'rf_contact_widget', 'description' => 'A widget that displays social icons and contact info.');
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'rf_contact_widget' );
		$this->WP_Widget( 'rf_contact_widget', 'Custom Contact Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		// Our variables from the widget settings
		$title = apply_filters('widget_title', $instance['title'] );
		$rss = $instance['rss'];
		$twitter = $instance['twitter'];
		$facebook = $instance['facebook'];
		$flickr = $instance['flickr'];
		$linkedin = $instance['linkedin'];
		$phone = nl2br($instance['phone']);
		$email = nl2br($instance['email']);
		$location = nl2br($instance['location']);

		// Before widget (defined by themes)
		echo $before_widget;

		// Display the widget title if one was input (before and after defined by themes)
		echo $before_title . $title . $after_title;

		//Randomize tab order in a new array
		$tab = array();
			
		// Display a containing div
		echo '<div class="rf_contact_widget">';
			echo '<div class="social-buttons">';
				if ($rss) { echo '<a href="'.get_bloginfo('rss2_url').'" target="_BLANK"><img src="'.get_template_directory_uri().'/images/rss.png" alt="RSS button" /></a>'; }
				if ($twitter) { echo '<a href="http://www.twitter.com/'.$twitter.'" target="_BLANK"><img src="'.get_template_directory_uri().'/images/twitter.png" alt="Twitter button" /></a>'; }
				if ($facebook) { echo '<a href="'.$facebook.'" target="_BLANK"><img src="'.get_template_directory_uri().'/images/facebook.png" alt="Facebook button" /></a>'; }
				if ($flickr) { echo '<a href="'.$flickr.'" target="_BLANK"><img src="'.get_template_directory_uri().'/images/flickr.png" alt="Flickr button" /></a>'; }
				if ($linkedin) { echo '<a href="'.$linkedin.'" target="_BLANK"><img src="'.get_template_directory_uri().'/images/linkedin.png" alt="LinkedIn button" /></a>'; }
			echo '</div>';
			if ($phone) {
				echo '<div class="phone">
					<div class="icon"></div>
					<div class="text">
						<p>'.$phone.'</p>
					</div>
				</div>';
			}
			if ($email) {
				echo '<div class="email">
					<div class="icon"></div>
					<div class="text">
						<p>'.$email.'</p>
					</div>
				</div>';
			}
			if ($location) {
				echo '<div class="location">
					<div class="icon"></div>
					<div class="text">
						<p>'.$location.'</p>
					</div>
				</div>';
			}
		echo '</div>';

		// After widget (defined by themes)
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['rss'] = $new_instance['rss'];
		$instance['twitter'] = $new_instance['twitter'];
		$instance['facebook'] = $new_instance['facebook'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['linkedin'] = $new_instance['linkedin'];
		$instance['phone'] = $new_instance['phone'];
		$instance['email'] = $new_instance['email'];
		$instance['location'] = $new_instance['location'];
		
		return $instance;
	}
	
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Get in touch',
		'rss' => '1',
		'twitter' => 'redfactory',
		'facebook' => 'http://www.facebook.com',
		'flickr' => 'http://www.flickr.com',
		'linkedin' => 'http://www.linkedin.com',
		'phone' => '+31 070 3123456',
		'email' => 'info@redfactory.nl',
		'location' => 'The hague, The Netherlands'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
        	<label for="<?php echo $this->get_field_id( 'rss' ); ?>">Display rss button:</label>
        	<input class="widefat" type="checkbox" <?php if ($instance['rss'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="1" />
        </p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Twitter username:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $instance['twitter']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Facebook url:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $instance['facebook']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>">Flickr url:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo $instance['flickr']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>">Linkedin url:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $instance['linkedin']; ?>" />
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id( 'phone' ); ?>">Phone number:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" value="<?php echo stripslashes(htmlspecialchars($instance['phone'])); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>">Email:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo stripslashes(htmlspecialchars($instance['email'])); ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'location' ); ?>">Location:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>" value="<?php echo stripslashes(htmlspecialchars($instance['location'])); ?>" />
		</p>
	<?php
	}
}
?>