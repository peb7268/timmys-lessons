<?php global $wp_query, $sidebar_pos;
$pageid = $wp_query->post->ID;
$sidebar_id = strtolower(get_post_meta($pageid, "sidebar", true));
if (!$sidebar_id) {
	$sidebar_id = 'sidebar';
}
if ($sidebar_pos != 'fullwidthpage' && is_active_sidebar($sidebar_id)) { ?>
	<div id="sidebar">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar_id) ) : 
        endif; ?>
	</div><!-- #sidebar -->
<?php } ?>