<?php
/*
 * Plugin Name: Custom Maps widget
 * Plugin URI: http://www.redfactory.nl
 * Description: A widget that displays a google maps
 * Version: 1.0
 * Author: Red Factory
 * Author URI: http://www.redfactory.nl
 */



// Register widget
function gom_maps_widget() {
	register_widget( 'gom_maps_widget' );
}
add_action( 'widgets_init', 'gom_maps_widget' );

// Widget class
class gom_maps_widget extends WP_Widget {

	function gom_maps_widget() {
		$widget_ops = array( 'classname' => 'gom_maps_widget', 'description' => 'A widget that displays a google map.');
		$control_ops = array( 'width' => 300, 'height' => 250, 'id_base' => 'gom_maps_widget' );
		$this->WP_Widget( 'gom_maps_widget', 'Custom Maps Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		// Our variables from the widget settings
		$title_markup = apply_filters('widget_title', $instance['title'] );
		$title = $instance['title'];
		$location_value = str_replace(' ','+',$instance['location_value']);
		$geocode = $instance['geocode'];
		$location_title = $instance['location_title'];
		$zoom = $instance['zoom'];
		$map_type = $instance['map_type'];
		$zoom_ctrl = ($instance['zoom_ctrl']) ? 'true' : 'false'; 
		$drag_ctrl = ($instance['drag_ctrl']) ? 'true' : 'false'; 
		$map_typ_ctrl = ($instance['map_typ_ctrl']) ? 'true' : 'false';
		$scale_ctrl = ($instance['scale_ctrl']) ? 'true' : 'false';
		$streetview_ctrl = ($instance['streetview_ctrl']) ? 'true' : 'false';
		$overview_ctrl = ($instance['overview_ctrl']) ? 'true' : 'false';
		$in_map_scroll = ($instance['in_map_scroll']) ? 'false' : 'true';
		$in_map_drag = ($instance['in_map_drag']) ? 'false' : 'true';
		$marker_icon = ($instance['marker_icon']) ? '"'.$instance['marker_icon'].'"' : 'marker ';
		
		$unique_code = str_replace(',','_',$geocode);
		?>
        
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
		jQuery(document).ready(function($){              
			var myLatlng = new google.maps.LatLng(<?php echo $geocode; ?>);
			var myOptions = {
				zoom: <?php echo $zoom; ?>,
				panControl: <?php echo $drag_ctrl; ?>,
				zoomControl: <?php echo $zoom_ctrl; ?>,
				mapTypeControl: <?php echo $map_typ_ctrl; ?>,
				scaleControl: <?php echo $scale_ctrl; ?>,
				streetViewControl: <?php echo $streetview_ctrl; ?>,
				overviewMapControl: <?php echo $overview_ctrl; ?>,
			    scrollwheel: <?php echo $in_map_scroll; ?>,
			    draggable: <?php echo $in_map_drag; ?>,
				disableDefaultUI: true,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.<?php echo $map_type; ?>
			}
			var map = new google.maps.Map(document.getElementById("map_canvas_<?php echo $unique_code; ?>"), myOptions);
			
			var marker = new google.maps.Marker({
				icon: <?php echo $marker_icon; ?>,
				position: myLatlng, 
				map: map,
				animation: google.maps.Animation.DROP, 
				title:"<?php echo $location_title; ?>"
			});
			google.maps.event.addListener(marker, 'click', toggleBounce);
					
			function toggleBounce() {
				if (marker.getAnimation() != null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}
		});
		</script>
        
		<style type="text/css">
		.rf_maps_widget_border {
			border: #dedede 1px solid;
			display: inline-block;
			padding: 1px;
			background: #fff;
			position: relative;
		}
		#footer .rf_maps_widget_border {
			border-color: #2a2a2a;
			background: #000;
		}
		.rf_maps_widget {
			border: #f0f0f0 4px solid;
			display: inline-block;
			padding: 0;
			position: relative;
		}
		#footer .rf_maps_widget {
			border-color: #131313;
		}
		.map_canvas	{
			height: 190px;
			width: 266px;
			display: inline-block;
			border: none;
		}
		#footer .map_canvas {
			width: 186px;
		}
		</style>
        
		<?php 		
		// Before widget (defined by themes)
		echo $before_widget;

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) echo $before_title . $title_markup . $after_title;
		
		// Display a containing div ?>
        <div class="rf_maps_widget_border">
            <div class="rf_maps_widget">
                <div id="map_canvas_<?php echo $unique_code; ?>" class="map_canvas"></div>
            </div>
        </div>

		<?php // After widget (defined by themes)
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */
		$instance['zoom'] = $new_instance['zoom'];
		$instance['zoom_ctrl'] = $new_instance['zoom_ctrl'];
		$instance['drag_ctrl'] = $new_instance['drag_ctrl'];
		$instance['map_typ_ctrl'] = $new_instance['map_typ_ctrl'];
		$instance['scale_ctrl'] = $new_instance['scale_ctrl'];
		$instance['streetview_ctrl'] = $new_instance['streetview_ctrl'];
		$instance['overview_ctrl'] = $new_instance['overview_ctrl'];
		$instance['in_map_scroll'] = $new_instance['in_map_scroll'];
		$instance['in_map_drag'] = $new_instance['in_map_drag'];
		$instance['marker_icon'] = $new_instance['marker_icon'];
		$instance['map_type'] = $new_instance['map_type'];
		$instance['location_title'] = $new_instance['location_title'];
		
		//Get Latitude and Longitude
		if ($instance['location_value'] != $new_instance['location_value']) {
			$instance['location_value'] = $new_instance['location_value'];
			
			$location_value = str_replace(' ','+',$instance['location_value']);
			
			$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$location_value.'&sensor=false');
			$output = json_decode($geocode);
			$lat = $output->results[0]->geometry->location->lat;
			$lng = $output->results[0]->geometry->location->lng;
			
			if ($lat && $lng) {
				$instance['geocode'] = $lat . ',' . $lng;
			} else {
				$instance['geocode'] = 'Location was NOT found! Remember: Google limits the search for geocodes, so you could try again in a couple of minutes.';
			}
		}
		
		return $instance;
	}
	
	
	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array(
			'map_type' => 'ROADMAP'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'location_value' ); ?>">Location:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'location_value' ); ?>" name="<?php echo $this->get_field_name( 'location_value' ); ?>" value="<?php echo $instance['location_value']; ?>" />
            <small>Geocode: <?php echo $instance['geocode']; ?></small>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'location_title' ); ?>">Give a title to your location:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'location_title' ); ?>" name="<?php echo $this->get_field_name( 'location_title' ); ?>" value="<?php echo $instance['location_title']; ?>" />
            <small>e.g. 'Our HQ', 'This is where I live' or 'Here you can find us'</small>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'zoom' ); ?>">Zoom level (1 to 22):</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>" value="<?php echo $instance['zoom']; ?>" />
		</p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'zoom_ctrl' ); ?>">Show zoom control:</label>
        	<input class="" type="checkbox" <?php if ($instance['zoom_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'zoom_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'zoom_ctrl' ); ?>" value="1" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'drag_ctrl' ); ?>">Show drag control:</label>
        	<input class="" type="checkbox" <?php if ($instance['drag_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'drag_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'drag_ctrl' ); ?>" value="1" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'map_typ_ctrl' ); ?>">Show map typ control:</label>
        	<input class="" type="checkbox" <?php if ($instance['map_typ_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'map_typ_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'map_typ_ctrl' ); ?>" value="1" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'scale_ctrl' ); ?>">Show scale control:</label>
        	<input class="" type="checkbox" <?php if ($instance['scale_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'scale_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'scale_ctrl' ); ?>" value="1" />
        </p>     
        <p>
        	<label for="<?php echo $this->get_field_id( 'streetview_ctrl' ); ?>">Show streetview control:</label>
        	<input class="" type="checkbox" <?php if ($instance['streetview_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'streetview_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'streetview_ctrl' ); ?>" value="1" />
        </p>              
        <p>
        	<label for="<?php echo $this->get_field_id( 'overview_ctrl' ); ?>">Show overview control:</label>
        	<input class="" type="checkbox" <?php if ($instance['overview_ctrl'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'overview_ctrl' ); ?>" name="<?php echo $this->get_field_name( 'overview_ctrl' ); ?>" value="1" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'in_map_scroll' ); ?>">Disable in-map scrolling:</label>
        	<input class="" type="checkbox" <?php if ($instance['in_map_scroll'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'in_map_scroll' ); ?>" name="<?php echo $this->get_field_name( 'in_map_scroll' ); ?>" value="1" />
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id( 'in_map_drag' ); ?>">Disable in-map dragging:</label>
        	<input class="" type="checkbox" <?php if ($instance['in_map_drag'] == '1') { echo 'checked'; } ?> id="<?php echo $this->get_field_id( 'in_map_drag' ); ?>" name="<?php echo $this->get_field_name( 'in_map_drag' ); ?>" value="1" />
        </p>        
		<p>
			<label for="<?php echo $this->get_field_id( 'marker_icon' ); ?>">Upload own marker icon:</label>
			<input class="widefat upload_field" id="<?php echo $this->get_field_id( 'marker_icon' ); ?>" name="<?php echo $this->get_field_name( 'marker_icon' ); ?>" value="<?php echo $instance['marker_icon']; ?>" />
            <small><input class="upload_button" type="button" value="Browse" /></small><div class="clearfix"></div>
		</p>       
        <p>
			<label for="<?php echo $this->get_field_id( 'map_type' ); ?>">Map type:</label>
            <select name="<?php echo $this->get_field_name( 'map_type' ); ?>" id="<?php echo $this->get_field_id( 'map_type' ); ?>">
                <option <?php if ($instance['map_type']  == 'ROADMAP') { ?>selected="selected"<?php } ?> value="ROADMAP">Roadmap</option>
              	<option <?php if ($instance['map_type'] == 'TERRAIN') { ?>selected="selected"<?php } ?> value="TERRAIN">Terrain</option>
                <option <?php if ($instance['map_type']  == 'SATELLITE') { ?>selected="selected"<?php } ?> value="SATELLITE">Satellite</option>
                <option <?php if ($instance['map_type']  == 'HYBRID') { ?>selected="selected"<?php } ?> value="HYBRID">Hybrid</option>
			</select>        
        </p>
	<?php
	}
}
?>