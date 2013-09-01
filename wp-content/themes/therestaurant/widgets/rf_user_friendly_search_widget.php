<?php
/*
 * Plugin Name: User Friendly Search Widget
 * Plugin URI: http://www.groupofmedia.com
 * Description: A widget that displays a userfriendly searchfield.
 * Version: 1.0
 * Author: Group of Media
 * Author URI: http://www.groupofmedia.com
 */



// Register widget
function gom_user_friendly_search_widget() {
	register_widget( 'gom_user_friendly_search_widget' );
}
add_action( 'widgets_init', 'gom_user_friendly_search_widget' );

// Widget class
class gom_user_friendly_search_widget extends WP_Widget {

	function gom_user_friendly_search_widget() {
		$widget_ops = array( 'classname' => 'gom_user_friendly_search_widget', 'description' => 'A widget that displays a userfriendly searchfield.');
		$control_ops = array( 'width' => 370, 'height' => 250, 'id_base' => 'gom_user_friendly_search_widget' );
		$this->WP_Widget( 'gom_user_friendly_search_widget', 'User Friendly Search Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		// Our variables from the widget settings
		$title_markup = apply_filters('widget_title', $instance['title'] );
		$title = $instance['title'];
		$content = nl2br($instance['content']);


		// Before widget (defined by themes)
		if($title) { echo $before_widget; }
		else	{ echo $before_widget_no_title; }

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) echo $before_title . $title_markup . $after_title;
		?>
        
		<style type="text/css">
        .gom_user_friendly_search_widget .searchform {
            display: block;
            position:relative;
            width:auto;
            text-align:left;
        }
        .gom_user_friendly_search_widget .searchform .reset	{
            display:none;
            font-weight:bold;
            cursor:pointer;
            color:#ccc;
            z-index:1;
            position:absolute; 
            top:8px;
            right:5px;
			text-shadow: none;
        }
        .gom_user_friendly_search_widget .searchform .search_button  {
            background: url('<?php bloginfo('template_directory') ?>/images/sprite_search.png') -2px -50px no-repeat;
            height:20px;
            width:20px;
            z-index:1;
            position:absolute; 
            top:5px;
            left:5px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
        }
        .gom_user_friendly_search_widget .searchform .search_button input[type="submit"] {
            background: none repeat scroll 0 0 transparent;
            border: 0 none;
            left: 0;
            margin-right: 0;
            padding-right: 0;
            position: absolute;
            top: 0;
            width: 20px;
            height:20px;
            cursor:default;    
        }
        .gom_user_friendly_search_widget .searchform input[type="text"] {
            width:205px;
            padding-left:30px;
            padding-right:20px;
            position:relative;
            display:inline-block;
        }
		#footer .gom_user_friendly_search_widget .searchform input[type="text"] {
            width: 146px;
        }
        </style>
        
        <script type="text/javascript">
		jQuery(document).ready(function($){
			$('.searchform').find('input:text').bind('focus keyup change click', function(){
				var searchform = $(this).parents('.searchform');
				if( $(this).val().length == 0 ) {
					searchform.find('input:submit').attr('disabled', 'true').css('cursor','default');
					searchform.children('.reset').fadeOut(1000);
					searchform.children('.search_button').css('background-position', '-2px -50px');
				} else {
					searchform.find('input:submit').removeAttr('disabled').css('cursor','pointer');
					searchform.children('.reset').fadeIn(1000).css('display','inline-block');
					searchform.children('.search_button').css('background-position', '-2px -26px');
				}
			});
			$('.searchform').find('input:text').focusout(function() {
				var searchform = $(this).parents('.searchform');
				if($(this).val().length > 0 ) {
					searchform.children('.search_button').hide();
					searchform.children('.search_button').css('background-position', '-2px -2px');
					searchform.children('.search_button').fadeIn(1500);
				}
			});
			$('.reset').click(function() {
				var searchform = $(this).parents('.searchform');
				$(this).fadeOut(500);
				searchform.children('input:text').val('');
				searchform.children('.search_button').css('background-position', '-2px -50px');
				searchform.find('input:submit').attr('disabled', 'true').css('cursor','default');
			}); 
		});
		</script>
        
		<?php	
		// Display a containing div
		echo '<div class="gom_user_friendly_search_widget">';
        echo '<form method="get" class="searchform"  action="'. get_bloginfo('home') .'/"> 
            <div class="search_button no-value"><input type="submit" value="" disabled=""></div>
            <input type="text" name="s" class="s" placeholder="'.$content.'" /><div class="reset">✖</div>
        </form> ';
		echo '</div>';

		// After widget (defined by themes)
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* No need to strip tags */		
		$instance['content'] = $new_instance['content'];

		return $instance;
	}
	
	
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
			'content' => 'To search, click and type'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>">Search text:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo $instance['content']; ?>" />
		</p>		
	<?php
	}
}
?>