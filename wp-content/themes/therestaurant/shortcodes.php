<?php
// [line]
function line_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[line]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>' . $html . '</span><br />';
	}
	else {
		return '<span class="devider"></span>';
	}
}
add_shortcode('line', 'line_shortcode');

// [linetop]
function line_top_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[linetop]';
   		return '<div class="sc_sample"><h5>Shortcode:</h5>' . $html . '</div><br />';
	}
	else {
		return '<div class="devider-top"><a href="#">Top</a></div>';
	}
}
add_shortcode('linetop', 'line_top_shortcode');

// [column]
function column_shortcode( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		'size' => '2x1',
		'last' => false,
		'title' => '',
		'sample' => false,
	), $atts ) );
	$html = '<div class="column' . $size;
	if ($last) $html .= ' last';
	$html .= '">';
	if ($title) $html .= '<h3>' . $title . '</h3>';
	$html .= do_shortcode($content) . '</div>';
	if ($sample) {
		$html = '[column size="' . $size . '"';
		if ($last) $html .= ' last="true"';
		if ($title) $html .= ' title="' . $title . '"';
		$html .= ']';
		$html .= '<br />Your content here<br />[/column]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>' . $html . '</span><br />';
	}
	else {
		return $html;
	}
}
add_shortcode('column', 'column_shortcode');

// [selection]
function selection_shortcode( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[selection] Your content here [/selection]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>' . $html . '</span><br />';
	}
	else {
		$html = '<span class="selection">';
		$html .= do_shortcode($content) . '</span>';
		return $html;
	}
}
add_shortcode('selection', 'selection_shortcode');

// [toggle]
function toggle_shortcode( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		'title' => '',
		'fold' => 'true',
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[toggle title="' . $title . '" fold="' . $fold . '"]<br />Your content here<br />[/toggle]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>' . $html . '</span><br />';
	}
	else {
		$html = '<div class="toggle';
		if ($fold == 'true') {
			$html .= ' fold';
		}
		$html .= '"><h4 class="title">' . $title . '</h4><div class="toggle-content">' . do_shortcode($content) . '</div></div>';
		return $html;
	}
}
add_shortcode('toggle', 'toggle_shortcode');

// [button]
function button_shortcode( $atts ) {
   	extract( shortcode_atts( array(
		'title' => 'Read more',
		'color' => 'aaaaaa',
		'url' => '#',
		'float' => 'none',
		'top' => '0',
		'bottom' => '0',
		'left' => '0',
		'right' => '0',
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[button title="'.$title.'" url="'.$url.'" color="'.$color.'" float="'.$float.'" top="'.$top.'" right="'.$right.'" bottom="'.$bottom.'" left="'.$left.'"]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>' . $html . '</span><br />';
	}
	else {
		if ($color == 'magenta') {
			$color = 'd4163f';
		} elseif ($color == 'cyan') {
			$color = '00b7eb';
		} elseif ($color == 'yellow') {
			$color = 'E6BD17';
		} elseif ($color == 'black') {
			$color = '222222';
		} elseif ($color == 'red') {
			$color = 'e00029';
		} elseif ($color == 'blue') {
			$color = '2d88cd';
		} elseif ($color == 'green') {
			$color = '6eb828';
		} elseif ($color == 'purple') {
			$color = 'b828b1';
		} elseif ($color == 'orange') {
			$color = 'f58d38';
		}
		$color2 = new CSS_Color($color);
		$html = '<span class="readmore custom_button" title="'.$title.'" rel="bookmark" style="margin:'.$top.'px '.$right.'px '.$bottom.'px '.$left.'px;float:'.$float.';background-color:#'.$color2->bg['0'].'; border-color:#'.$color2->bg['-3'].';"><a href="'.$url.'" style="color: #'.$color2->fg['-3'].';text-shadow: #'.$color2->bg['-3'].' 0px -1px 0px;border-color:#'.$color2->bg['+1'].';">'.$title.'</a></span>';
		return $html;
	}
}
add_shortcode('button', 'button_shortcode');

// [message]
function message_shortcode( $atts, $content = null ) {
   	extract( shortcode_atts( array(
		'title' => '',
		'type' => '',
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[message type="'.$type.'" title="'.$title.'"]<br />Your content here<br />[/message]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>'.$html.'</span><br />';
	}
	else {
		$html = '<div class="message '.$type.'"><h5 class="title">'.$title.'</h5>'.do_shortcode($content).'</div>';
		return $html;
	}
}
add_shortcode('message', 'message_shortcode');

// [maps]
function maps_shortcode( $atts ) {
   	extract( shortcode_atts( array(
		'location' => '',
		'zoom' => '10',
		'popup' => 'no',
		'height' => '400px',
		'width' => '100%',
		'sample' => false,
	), $atts ) );
	if ($sample) {
		$html = '[maps location="'.$location.'" zoom="'.$zoom.'" popup="'.$popup.'" width="'.$width.'" height="'.$height.'"]';
   		return '<span class="sc_sample"><h5>Shortcode:</h5>'.$html.'</span><br />';
	}
	else {
		$location = str_replace(' ','+',$location);
		if ($popup == 'yes') {
			$popup = 'A';
		} else {
			$popup = 'B';
		}
		$source = htmlentities('http://maps.google.com/maps?f=q&source=s_q&q='.$location.'&ie=UTF8&z='.$zoom.'&iwloc='.$popup.'&output=embed');
		$html = '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$source.'"></iframe><br /><br />';
		return $html;
	}
}
add_shortcode('maps', 'maps_shortcode');
?>