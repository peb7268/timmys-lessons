<div class="card-item  <?php if (has_post_thumbnail()) { echo 'has-thumbnail'; } ?>">
	<div class="dottedline"></div>
	<?php if (has_post_thumbnail()) { ?>
		<div class="item-img">
			<div class="item-img-border">
				<?php $img_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'fullwidth', false, '' ); ?>
				<a class="hoverfade centerimg fancybox" rel="fancybox" href="<?php echo $img_src[0]; ?>" title="<?php the_title() ?>" rel="bookmark">
					<?php the_post_thumbnail('menucard_thumb'); ?>
				</a>
			</div>
		</div>
	<?php } ?>
	<div class="item-text">
		<?php $postlink = get_post_meta($post->ID, "postlink", true);
		if ($postlink) { ?>
			<a class="name" href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="bookmark">
		<?php } else { ?>
			<div class="name">
		<?php }
		the_title();
		if ($postlink) { ?>
			</a>
		<?php } else { ?>
			</div>
		<?php } 
		$description = get_post_meta($post->ID, "description", true);
		if ($description) { ?>
			<div class="description"><?php echo $description; ?></div>
		<?php } ?>
	</div>
	<?php $itemprice = get_post_meta($post->ID, "price", true);
	if ($itemprice) { ?>
		<div class="price"><?php echo $itemprice; ?></div>
	<?php } ?>
</div>