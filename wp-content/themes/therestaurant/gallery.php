<?php
/*
Template Name: Gallery
*/
?>
<?php global $more, $post, $wpdb, $pageid;
get_header();
if (!$pageid) {
	$pageid = $post->ID;
}
if (is_category() ) {
	$cat_ID = get_query_var('cat');
}
$pagetitle = get_the_title($pageid);
$categories = get_post_meta($pageid, "categories", true);
$number = get_post_meta($pageid, "number", true);
$img_height = get_post_meta($pageid, "imageheight", true);
?>
<div id="gallery">
    <div id="content-top"></div>
    <div id="content-border">
        <div id="content">
        	<div class="ribbon-container">
                <div class="title-container">
                    <div class="title">
                        <div class="bar-left"></div>
                        <div class="bar-right"></div>
                        <h1 class="post-title"><?php echo $pagetitle; ?></h1>
                    </div>
                </div>
            </div>
            <div id="post-container">
				<?php $count = 1;
				$paged = intval(get_query_var('paged'));
                query_posts('&cat='.$categories.'&posts_per_page='.$number.'&paged='.$paged );
                while( have_posts() ) : the_post(); $more = 0; ?>
				<div class="gal_item">
                	<?php if (has_post_thumbnail()) { ?>
                        <div class="post-img">
                            <div class="post-img-border" <?php if ($img_height > 0) { echo 'style="height:'.$img_height.'px;"'; } ?>>
                            	<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'fullwidth', false, '' ); ?>
                                <a class="hoverfade fancybox <?php if ($img_height > 0) { echo 'centerimg'; } ?>" rel="fancybox" href="<?php echo $img_src[0]; ?>" title="<?php the_title() ?>" rel="bookmark">
                                    <?php the_post_thumbnail('gallery_thumb'); ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                	<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>
                    <div class="post-content">
                        <?php the_content(''); ?>
                    </div>
                    <div class="readmore">
                    	<a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php _e( 'Read more', $theme_name ) ?></a>
                    </div>
                </div>
                <?php if ($count % 3 == 0) { ?>
                    <div class="gal-devider"></div>
                <?php }
                $count++; ?>
                <?php endwhile ?>
                <div id="nicepagination">
					<?php nicepagination(); ?>
                </div>
        	</div>
        </div><!-- #content -->
    </div>
    <div id="content-bottom"></div>
    <?php wp_reset_query(); ?>
</div>
<?php get_footer() ?>