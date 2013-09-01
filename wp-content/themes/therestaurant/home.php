<?php global $more;
get_header(); ?>
    <!--<div id="content-top"></div>-->
	<?php if (is_active_sidebar('frontpage')) { ?>
	<div id="content-border">
        <div id="content" class="home">
        	<div class="widget-container">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('frontpage') ) :
                endif; ?>
            </div>
        </div><!-- #content -->
	</div>
    <div id="content-bottom"></div>
    <?php }
    if (is_active_sidebar('frontpage2')) { ?>
    <div id="widget-border">
        <div id="frontwidgets_home">
        	<div class="widget-container">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('frontpage2') ) :
                endif; ?>
            </div>
        </div><!-- #content -->
	</div>
    <div id="widget-bottom"></div>
    <?php } ?>
<?php get_footer() ?>