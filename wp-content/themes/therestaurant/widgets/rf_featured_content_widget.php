<?php
/*
 * Plugin Name: Custom Featured Content widget
 * Plugin URI: http://www.redfactory.nl
 * Description: A widget that displays an image, text and a read-more button
 * Version: 1.0
 * Author: Red Factory
 * Author URI: http://www.redfactory.nl
 */



// Register widget
function rf_fronttext_widget() {
	register_widget( 'rf_fronttext_widget' );
}
add_action( 'widgets_init', 'rf_fronttext_widget' );

// Widget class
class rf_fronttext_widget extends WP_Widget {

	function rf_fronttext_widget() {
		$widget_ops = array( 'classname' => 'rf_fronttext_widget', 'description' => 'A widget that displays an image, text and a read-more button.');
		$control_ops = array( 'width' => 400, 'height' => 250, 'id_base' => 'rf_fronttext_widget' );
		$this->WP_Widget( 'rf_fronttext_widget', 'Custom Featured Content widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb, $theme_name;
		extract( $args );

		// Our variables from the widget settings
		$title_markup = apply_filters('widget_title', $instance['title'] );
		$title = $instance['title'];
		$image = $instance['image'];
		$imageheight = $instance['imageheight'];
		$content = nl2br($instance['content']);
		$url = $instance['link'];

		// Before widget (defined by themes)
		echo $before_widget;
		
		echo $before_title . $title_markup . $after_title;
			
		// Display a containing div ?>
		<div class="rf_fronttext_widget">
			<?php if ($image) { ?>
                <div class="postimage-container">
                	<div class="postimage-border" <?php if ($imageheight) echo 'style="height:'.$imageheight.'px;"'; ?>>
                        <a class="postimage hoverfade fancybox <?php if ($imageheight) { echo 'centerimg'; } ?>" rel="fancybox" href="<?php echo $image; ?>" title="<?php echo $title; ?>" rel="bookmark">
                            <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
                        </a>
                    </div>
				</div>
            <?php } ?>
           <p><?php echo $content; ?></p>
           <?php if ($url) { ?>
				<div class="readmore">
					<a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php _e( 'Read more', $theme_name ); ?></a>
				</div>
            <?php } ?>
		</div>

		<?php // After widget (defined by themes)
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['image'] = $new_instance['image'];
		$instance['imageheight'] = $new_instance['imageheight'];
		$instance['content'] = $new_instance['content'];
		$instance['link'] = $new_instance['link'];
		
		return $instance;
	}
	
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>">Image:</label>
			<input class="widefat upload_field" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo $instance['image']; ?>" />
            <small><input class="upload_button" type="button" value="Browse" /></small><div class="clearfix"></div>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'imageheight' ); ?>">Image height (in pixels):</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'imageheight' ); ?>" name="<?php echo $this->get_field_name( 'imageheight' ); ?>" value="<?php echo $instance['imageheight']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>">Content:</label>
            <textarea rows="5" cols="50" name="<?php echo $this->get_field_name( 'content' ); ?>" id="<?php echo $this->get_field_id( 'content' ); ?>"><?php echo stripslashes(htmlspecialchars($instance['content'])); ?></textarea>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>">Link:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" />
		</p>
	<?php
	}
}
?>