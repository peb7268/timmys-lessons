<?php global $more;
get_header(); ?>
<div id="content-top"></div>
<div id="content-border">
    <div id="content">
    	<div class="ribbon-container">
            <div class="title-container">
                <div class="title">
                    <div class="bar-left"></div>
                    <div class="bar-right"></div>
                    <h1 class="post-title"><?php _e( 'Search results for', $theme_name ); ?>: <?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></h1>
                </div>
            </div>
        </div>
        <div id="post-container">
            <?php if (have_posts()) : ?>
                <?php while( have_posts() ) : the_post(); $more = 0;
					include('post-layout.php');
                endwhile; ?>
                <div id="nicepagination">
					<?php nicepagination(); ?>
                </div>
            <?php else : ?>
                <div id="post-0" class="post">
                    <h2 class="post-title"><?php _e( 'Nothing Found', $theme_name ); ?></h2>
                    <div class="post-content">
                        <p><?php echo __( $theme_options['cp_search_error'], $theme_name ); ?></p>
                    </div>
                    <form id="searchform" method="get" action="<?php bloginfo('home') ?>">
                        <div>
                            <input id="s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="40" />
                            <input id="searchsubmit" name="searchsubmit" type="submit" value="<?php _e( 'Search', $theme_name ); ?>" />
                        </div>
                    </form>
                </div><!-- .post -->
            <?php endif; ?>
        </div>
        <?php get_sidebar() ?>
    </div><!-- #content -->
</div>
<div id="content-bottom"></div>
<?php get_footer() ?>