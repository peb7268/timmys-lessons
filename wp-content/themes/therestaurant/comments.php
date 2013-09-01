<div id="comments">

<?php if ( post_password_required() ) { ?>
        <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'therestaurant' ); ?></p>
    </div><!-- #comments -->
	<?php return;
}

if ( have_comments() ) { ?>
    <h3 id="comments-title">
    	<?php printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'therestaurant' ), number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' ); ?>
    </h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
        <div class="navigation">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'therestaurant' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'therestaurant' ) ); ?></div>
        </div> <!-- .navigation -->
    <?php } ?>
    
    <ol class="commentlist">
        <?php wp_list_comments( array( 'callback' => 'therestaurant_comment' ) ); ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
        <div class="navigation">
            <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'therestaurant' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'therestaurant' ) ); ?></div>
        </div><!-- .navigation -->
    <?php } else {
        if ( !comments_open() ) { ?>
        	<p class="nocomments"><?php _e( 'Comments are closed.', 'therestaurant' ); ?></p>
    	<?php }
	} ?>

<?php }
comment_form(); ?>


<?php function therestaurant_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-single">
		<div class="comment-gravatar vcard">
			<?php echo get_avatar( $comment, 60 ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'therestaurant' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
        	<cite class="fn"><?php comment_author_link() ?></cite>
        	<!--<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">-->
				<?php printf( __( '%1$s at %2$s', 'therestaurant' ), get_comment_date(),  get_comment_time() ); ?>
            <!--</a>-->
			<?php edit_comment_link( __( '(Edit)', 'therestaurant' ), ' ' ); ?>
            <div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

	</div><!-- #comment-##  -->

	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'therestaurant' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'therestaurant'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
} ?>

</div><!-- #comments -->