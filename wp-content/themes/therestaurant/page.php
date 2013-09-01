<?php get_header() ?>
<div id="content-top"></div>
<div id="content-border">
	<div id="content">
    	<div class="ribbon-container">
            <div class="title-container">
                <div class="title">
                    <div class="bar-left"></div>
                    <div class="bar-right"></div>
                    <h1 class="post-title"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
		<div id="post-container">
			<?php the_post(); ?>
			<div id="post-<?php the_ID(); ?>" class="post">
				<?php if (has_post_thumbnail()) { ?>
					<div class="post-img">
						<?php if ($theme_options['cp_sidebar_position'] != 'hidden') {
							the_post_thumbnail('mediumwidth');
						} else {
							the_post_thumbnail('fullwidth');
						} ?>
					</div>
				<?php } ?>
				<div class="post-content">
					<?php the_content() ?>
				</div>
			</div><!-- .post -->
		</div>
		<?php get_sidebar() ?>
	</div><!-- #content -->
</div>
<div id="content-bottom"></div>
<?php get_footer() ?>