<?php get_header(); ?>
<div id="content-top"></div>
<div id="content-border">
    <div id="content">
    	<div class="ribbon-container">
            <div class="title-container">
                <div class="title">
                    <div class="bar-left"></div>
                    <div class="bar-right"></div>
                    <h1 class="post-title"><?php _e( 'Not found', $theme_name ); ?></h1>
                </div>
            </div>
        </div>
        <div id="post-container">
            <div id="post-0" class="post error404">
                <div class="post-content">
                    <p><?php echo stripslashes( __($theme_options['cp_error'], $theme_name)); ?></p>
                </div>
                <form id="error404-searchform" method="get" action="<?php bloginfo('home') ?>">
                    <div>
                        <input id="error404-s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="40" />
                        <input id="error404-searchsubmit" name="searchsubmit" type="submit" value="<?php _e( 'Search', $theme_name ); ?>" />
                    </div>
                </form>
            </div><!-- .post -->
        </div>
        <?php get_sidebar() ?>
    </div><!-- #content -->
</div>
<div id="content-bottom"></div>
<?php get_footer() ?>