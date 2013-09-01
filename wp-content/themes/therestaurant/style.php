<?php global $color, $color_header;
$pattern_header = $theme_options['cp_pattern_header'];
$pattern_ribbon = $theme_options['cp_pattern_ribbon'];
$pattern_button = $theme_options['cp_pattern_button']; ?>

<style type="text/css">


/* Main color */
.title-container .title, .readmore a, #sidebar .readmore a, input[type="submit"], .selection, #mainmenu ul.menu > li > a {
	color: #<?php echo $color->fg['-2']; ?>;
}
#mainmenu ul.menu li:hover a, #mainmenu ul.menu li.current-menu-item a, #mainmenu ul.menu li.current-menu-parent a, #breadcrumbs a, .topright-meta a, .post-title a, .post-meta a, .card-cat h2, .card-item .name, .post-content h1, .post-content a, #nicepagination ul li.active, #container .rf_latest_posts_widget h4 {
	color: #<?php echo $color->bg['0']; ?>;
}
#footer .title-container .title, #footer .sidepanel a.readmore, #footer input[type="submit"] {
	color: #000;
}
#menu-container-border, .title-container .title, .readmore, input[type="submit"], .selection, #slider_arrow .arrow_bit_top, #card-next .arrow_bit_top, #card-prev .arrow_bit_top, #slider_arrow .arrow_bit_bottom, #card-next .arrow_bit_bottom, #card-prev .arrow_bit_bottom {
	background-color: #<?php echo $color->bg['0']; ?>;
}
#slider_arrow .arrow_bit_left, #card-next .arrow_bit_left, #card-prev .arrow_bit_left, #slider_arrow .arrow_bit_right, #card-next .arrow_bit_right, #card-prev .arrow_bit_right {
	background-color: #<?php echo $color->bg['-2']; ?>;
}
.title-container .title, .title-container .bar-left, .title-container .bar-right, .readmore, input[type="submit"] {
	border-bottom-color: #<?php echo $color->bg['+1']; ?>;
}
.title-container .title, #mainmenu ul.menu li:hover .dropdown_arrow, #mainmenu ul.menu li.current-menu-item .dropdown_arrow, #mainmenu ul.menu li.current-menu-parent .dropdown_arrow, .readmore, input[type="submit"] {
	border-top-color: #<?php echo $color->bg['+1']; ?>;
}
.title-container .bar-right, #menu-right {
	border-color: transparent transparent #<?php echo $color->bg['-3']; ?> #<?php echo $color->bg['-3']; ?>;
}
.title-container .bar-left, #menu-left {
	border-color: transparent #<?php echo $color->bg['-3']; ?> #<?php echo $color->bg['-3']; ?> transparent;
}


.title-container .title, .readmore, input[type="submit"], #menu-container-border {
	border-color: #<?php echo $color->bg['-3']; ?>;
}
.title-container h1, .title-container h2, .title-container h3, .title-container .post-title, #menu-container, .readmore a, input[type="submit"] {
	border-color: #<?php echo $color->bg['+1']; ?>;
}


#footer .readmore {
	background-color: #666;
	border-color: #777;
}
#footer .readmore a, #footer input[type="submit"] {
	border-color: #444;
	text-shadow: #333 0px -1px 0px;
}



/* Text selections */
::selection {
	background: #<?php echo $color->bg['0']; ?>;
	color: #<?php echo $color->fg['-2']; ?>;
}
::-moz-selection {
	background: #<?php echo $color->bg['0']; ?>;
	color: #<?php echo $color->fg['-2']; ?>;
}
::-webkit-selection {
	background: #<?php echo $color->bg['0']; ?>;
	color: #<?php echo $color->fg['-2']; ?>;
}
#footer ::selection {
	background: #ddd;
	color: #222;
}
#footer ::-moz-selection {
	background: #ddd;
	color: #222;
}
#footer ::-webkit-selection {
	background: #ddd;
	color: #222;
}


/* Header color */
#header {
	background-color: #<?php echo $color_header->bg['0']; ?>;
}


/* Patterns */
<?php if ($pattern_header) { ?>
#header_pattern {
	background-image: url('<?php echo get_template_directory_uri(); ?>/images/<?php echo $pattern_header; ?>.png');
}
<?php }
if ($pattern_ribbon) { ?>
.title-container h1, .title-container h2, .title-container h3, .title-container .post-title, #menu-container, #slider_arrow .arrow_bit_bottom, #slider_arrow .arrow_bit_top, #slider_arrow .arrow_bit_left, #slider_arrow .arrow_bit_right, #card-next .arrow_bit_bottom, #card-next .arrow_bit_top, #card-next .arrow_bit_left, #card-next .arrow_bit_right, #card-prev .arrow_bit_bottom, #card-prev .arrow_bit_top, #card-prev .arrow_bit_left, #card-prev .arrow_bit_right {
	background-image: url('<?php echo get_template_directory_uri(); ?>/images/<?php echo $pattern_ribbon; ?>.png');
}
<?php } 
if ($pattern_button) { ?>
.readmore a, input[type="submit"] {
	background-image: url('<?php echo get_template_directory_uri(); ?>/images/<?php echo $pattern_button; ?>.png');
}
<?php } ?>


/* Text shadows */
#sidebar .font, #content .post .font, #card-container .font, #frontwidgets h3, #gallery .gal_item .font, #nicepagination .font {
	text-shadow: #fff 0px 1px 0px;
}
#footer .font {
	text-shadow: #000 0px -1px 0px;
}
#content .title-container .font, #mainmenu ul.menu li a.font, .readmore a, input[type="submit"] {
	text-shadow: #<?php echo $color->bg['-4']; ?> 0px -1px 0px;
}
#mainmenu ul.menu li.current-menu-item a.font, #mainmenu ul.menu li.current-menu-parent a.font, #mainmenu ul.menu li:hover a.font {
	text-shadow: none;
}


/* Slider settings */
<?php global $post;
$pageid = $post->ID;
$sliderheight = (get_post_meta($pageid, "sliderheight", true)) ? get_post_meta($pageid, "sliderheight", true) : $theme_options['cp_sliderheight'];
if (!$sliderheight) $sliderheight = '400';
if ((is_front_page() && $theme_options['cp_slider_show'] == 'frontpage') || $theme_options['cp_slider_show'] == 'all') { ?>
#header {
	height: <?php echo $sliderheight; ?>px;
}
#slider {
	display: inline-block;
}
<?php } ?>
#slider {
	height: <?php echo $sliderheight; ?>px;
}
</style>