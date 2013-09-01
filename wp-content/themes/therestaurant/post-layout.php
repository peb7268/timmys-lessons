<?php global $theme_options, $theme_name; ?>

<div id="post-<?php the_ID() ?>" class="post">
    <h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php the_title() ?></a></h2>
    <div class="post-meta">
        <div class="meta-content">
            <?php _e( 'Posted on', $theme_name ); ?> <?php the_time('F j, Y'); ?> <?php _e( 'in', $theme_name ); ?>: <?php the_category(', '); ?>
            <div class="jump_to_comments"><?php if (comments_open()) { comments_popup_link( __( 'Post Comment', $theme_name ), '1 ' . __( 'comment', $theme_name ), '% '. __( 'comments', $theme_name ) ); } ?></div>
        </div>
    </div>
    <?php if (has_post_thumbnail()) { ?>
        <div class="post-img">
            <div class="post-img-border" <?php if ($img_height > 0) { echo 'style="height:'.$img_height.'px;"'; } ?>>
                <?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'fullwidth', false, '' ); ?>
                <a class="hoverfade fancybox <?php if ($img_height > 0) { echo 'centerimg'; } ?>" rel="fancybox" href="<?php echo $img_src[0]; ?>" title="<?php the_title() ?>" rel="bookmark">
                    <?php if ($theme_options['cp_sidebar_position'] != 'hidden') {
                        the_post_thumbnail('mediumwidth');
                    } else {
                        the_post_thumbnail('fullwidth');
                    } ?>
                </a>
            </div>
        </div>
    <?php } ?>
    <div class="post-content">
        <?php the_content(''); ?>
    </div>
    <div class="readmore">
        <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark"><?php _e( 'Read more', $theme_name ) ?></a>
    </div>
</div><!-- .post -->
<div class="post-devider"></div>