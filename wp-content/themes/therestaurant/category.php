<?php $cat_ID = get_query_var('cat');
$category = get_category($cat_ID,false);
$cat_parent = $category->category_parent;
if ($cat_parent > 0) {
	$cat_ID = $cat_parent;
}

$sql = "SELECT DISTINCT p.ID, p.post_title, pm.meta_value AS page_template, pm2.meta_value AS mc_categories FROM " . $wpdb->posts . " AS p ";
$sql .= "LEFT JOIN (SELECT post_id, meta_value FROM " . $wpdb->postmeta . " WHERE meta_key = '_wp_page_template') ";
$sql .= "AS pm ON p.ID = pm.post_id ";
$sql .= "LEFT JOIN (SELECT post_id, meta_value FROM " . $wpdb->postmeta . " WHERE meta_key = 'categories') ";
$sql .= "AS pm2 ON p.ID = pm2.post_id ";
$sql .= "WHERE pm.meta_value = 'menucard.php' ";
$rows = $wpdb->get_results($sql,OBJECT);

$include_page = '';
foreach($rows as $row) {
	$mc_categories = explode(',', $row->mc_categories);
	if (in_array($cat_ID, $mc_categories)) {
		if ($row->page_template == 'menucard.php') {
			$include_page = 'menucard';
		}
	}
}

if ($include_page == 'menucard') {
	include('menucard.php');
}
else {
	get_header(); ?>
    <div id="content-top"></div>
    <div id="content-border">
        <div id="content">
        	<div class="ribbon-container">
                <div class="title-container">
                    <div class="title">
                        <div class="bar-left"></div>
                        <div class="bar-right"></div>
                        <h1 class="post-title"><?php echo single_cat_title() ?></h1>
                    </div>
                </div>
            </div>
            <div id="post-container">
                <?php while( have_posts() ) : the_post(); ?>
                <div id="post-<?php the_ID() ?>" class="post">
                    <?php if (has_post_thumbnail()) { ?>
                        <div class="post-img">
                            <a class="hoverfade" href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark">
                                <?php if ($theme_options['cp_sidebar_position'] != 'hidden') {
                                    the_post_thumbnail('mediumwidth');
                                } else {
                                    the_post_thumbnail('fullwidth');
                                } ?>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="topleft-meta">
                        <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>								
                        <div class="post-meta">
                            <div class="meta-content"><?php _e( 'Posted on', $theme_name ); ?> <?php the_time('F j, Y'); ?> <?php _e( 'in', $theme_name ); ?>: <?php the_category(', '); ?></div>
                        </div>
                    </div>
                    <div class="topright-meta">
                        <div class="jump_to_comments"><?php if (comments_open()) { comments_popup_link( __( 'Post Comment', $theme_name ), '1 ' . __( 'comment', $theme_name ), '% '. __( 'comments', $theme_name ) ); } ?></div>
                    </div>
                    <div class="meta-devider"></div>
                    <div class="post-content">
                        <?php the_content(''); ?>
                    </div>
                    <div class="readmore">
                        <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php _e( 'Read more', $theme_name ) ?></a>
                    </div>
                </div><!-- .post -->
                <?php endwhile ?>
                <div class="navigation">
                    <div class="navleft"><?php next_posts_link('&laquo; ' . __( 'Older Posts', $theme_name ), '0') ?></div>
                    <div class="navright"><?php previous_posts_link( __( 'Newer Posts', $theme_name ) . ' &raquo;', '0') ?></div>
                </div>
            </div>
            <?php get_sidebar() ?>
        </div><!-- #content -->
    </div>
    <div id="content-bottom"></div>
    <?php get_footer();
} ?>