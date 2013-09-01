<?php get_header(); ?>
<div id="content-top"></div>
<div id="content-border">
    <div id="content">
        <?php the_post(); ?>
        <div class="ribbon-container">
            <div class="title-container">
                <div class="title">
                    <div class="bar-left"></div>
                    <div class="bar-right"></div>
                    <div class="post-title"><?php the_title() ?></div>
                </div>
            </div>
        </div>
        <div id="post-container">
            <div id="post-<?php the_ID() ?>" class="post">
                <?php if (has_post_thumbnail()) { ?>
                	<div class="post-img">
                    	<div class="post-img-border">
							<?php if ($theme_options['cp_sidebar_position'] != 'hidden') {
                                the_post_thumbnail('mediumwidth');
                            } else {
                                the_post_thumbnail('fullwidth');
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <h1 class="post-title"><?php the_title() ?></h1>								
                <div class="post-meta">
                    <div class="meta-content">
						<?php _e( 'Posted on', $theme_name ); ?> <?php the_time('F j, Y'); ?> <?php _e( 'in', $theme_name ); ?>: <?php the_category(', '); ?>
                        <div class="jump_to_comments"><?php if (comments_open()) { ?><a href="#comments"><?php _e( 'Jump To Comments', $theme_name ); ?></a><?php } ?></div>
                    </div>
                </div>
                <div class="meta-devider"></div>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                <?php if ($theme_options['cp_share_twitter'] || $theme_options['cp_share_fb'] || $theme_options['cp_share_gbuzz'] || $theme_options['cp_share_digg'] || $theme_options['cp_share_del'] || $theme_options['cp_share_stumble'] || $theme_options['cp_share_linkedin'] || $theme_options['cp_share_google']) { ?>
                    <div class="meta-devider"></div>
                    <div class="social-sharing">
                        <ul class="sharing">
                            <?php if ($theme_options['cp_share_twitter']) { ?>
                            <li class="tweet"><a title="Tweet this post" href="http://twitter.com/home/?status=<?php the_title(); ?>&nbsp;-&nbsp;<?php the_permalink(); ?>"></a></li>
                            <?php }
                            if ($theme_options['cp_share_fb']) { ?>
                            <li class="fb"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>?t=<?php the_title(); ?>" title="Post to Facebook"></a></li>
                            <?php }
                            if ($theme_options['cp_share_gbuzz']) { ?>
                            <li class="gbuzz"><a href="http://www.google.com/reader/link?title=<?php the_title();?>&amp;url=<?php the_permalink();?>" title="Google Buzz"></a></li>
                            <?php }
                            if ($theme_options['cp_share_digg']) { ?>
                            <li class="digg"><a href="http://digg.com/submit?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>&amp;thumbnails=1" title="Digg this!"></a></li>
                            <?php }
                            if ($theme_options['cp_share_del']) { ?>
                            <li class="del"><a href="http://del.icio.us/post?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" title="Add To Delicious"></a></li>
                            <?php }
                            if ($theme_options['cp_share_stumble']) { ?>
                            <li class="stumble"><a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Stumble this"></a></li>
                            <?php }
                            if ($theme_options['cp_share_linkedin']) { ?>
                            <li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source="  title="Share on Linkedin"></a></li>
                            <?php }
                            if ($theme_options['cp_share_google']) { ?>
                            <li class="google"><a title="Share on Google" href="https://www.google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="meta-devider"></div>
            </div><!-- .post -->
            <?php comments_template(); ?>
        </div>
        <?php get_sidebar() ?>
    </div><!-- #content -->
</div>
<div id="content-bottom"></div>
<?php get_footer() ?>