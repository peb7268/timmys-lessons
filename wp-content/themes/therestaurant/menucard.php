<?php
/*
Template Name: Menu card
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
?>
	<div id="content-top"></div>
	<div id="content-border">
        <div id="content" class="menucard">
        	<div class="ribbon-container">
                <div class="title-container">
                    <div class="title">
                        <div class="bar-left"></div>
                        <div class="bar-right"></div>
                        <h1 class="post-title"><?php echo $pagetitle; ?></h1>
                    </div>
                </div>
            </div>
            <a href="" id="card-prev">
            	<div class="arrow_bit_bottom"></div>
                <div class="arrow_bit_top"></div>
                <div class="arrow_bit_left"></div>
                <div class="arrow_bit_right"></div>
                <div class="arrow_bit_middle"></div>
            </a>
            <a href="" id="card-next">
            	<div class="arrow_bit_bottom"></div>
                <div class="arrow_bit_top"></div>
                <div class="arrow_bit_left"></div>
                <div class="arrow_bit_right"></div>
                <div class="arrow_bit_middle"></div>
            </a>
            <?php 
            if ($cat_ID > 0) {
				$card_cats = explode(',',$categories);
				$count = 1;
				for ($x=0; $x < count($card_cats); $x=$x+2) {
					for ($i=0;$i<2;$i++) { 
						$array_location = $x+$i;
						if ($cat_ID == $card_cats[$array_location]) {
							$activepage = $count;
						}
					}
					$count++;
				}
			} else {
				$activepage = 1;
			} ?>
            <div id="card-container" activepage="<?php echo $activepage; ?>">     
            
            
<div id="pdfmenu" align="right" style="vertical-align:middle">

<p id="myoutercontainer2">
	<b><a href="http://www.wingfactory.com/wp-content/uploads/2013/04/WFtogoMenu4-4-13v2.pdf" style="color:#c10000; text-decoration:none">Download a menu</a>&nbsp;</b><a href="http://www.wingfactory.com/wp-content/uploads/2013/04/WFtogoMenu4-4-13v2.pdf"><img style="vertical-align:middle" src="http://www.wingfactory.com/wp-content/uploads/2012/01/pdf-icon.png" height="36" border="0"/></a>
</p>


</div>            
            	<div id="card-slider">
					<?php $card_cats = explode(',',$categories);
					$count = 1;
                    for ($x=0; $x < count($card_cats); $x=$x+2) { ?>
						<div id="cardpageid-<?php echo $count; ?>" class="card-page">
                        	<div class="menucard-devider"></div>
                        	<?php for ($i=0;$i<2;$i++) { 
                            	$array_location = $x+$i;
								if (isset($card_cats[$array_location])) { ?>
                                    <div class="card-cat" id="cardcatid-<?php echo $card_cats[$array_location]; ?>" catid="<?php echo $card_cats[$array_location]; ?>">
                                        <h2><?php echo get_cat_name($card_cats[$array_location]); ?></h2>
                                        <?php $cat_desc = category_description( $card_cats[$array_location] );
										if ($cat_desc) { ?>
											<div class="cat-desc">
											<?php echo $cat_desc; ?>
											</div>
										<?php } ?>
                                        <?php $child_cats = get_categories('child_of='.$card_cats[$array_location]);
										$cat_array = '';
										foreach ($child_cats as $child_cat) {
											if ($cat_array != '') {
												$cat_array .= ',';
											}
											$cat_array .= '-'.$child_cat->term_id;
										}
										query_posts('cat='.$card_cats[$array_location].','.$cat_array.'&showposts=-1');
                                        if ( have_posts() ) { 
											while ( have_posts() ) { 
												the_post();
												$more = 0;
                                            	include('menuitem.php');
											}
										}
                                        wp_reset_query();
										if ($child_cats) { 
											foreach ($child_cats as $child_cat) { ?>
												<h3><?php echo __($child_cat->cat_name); ?></h3>
                                        		<div class="devider"></div>
                                                <?php $cat_desc = category_description( $child_cat->term_id );
												if ($cat_desc) { ?>
                                                	<div class="cat-desc">
													<?php echo $cat_desc; ?>
                                                    </div>
												<?php }
												query_posts('cat='.$child_cat->term_id.'&showposts=-1');
												if ( have_posts() ) { 
													while ( have_posts() ) { 
														the_post();
														$more = 0;
														include('menuitem.php');
													}
												}
												wp_reset_query();
											}
										} ?>
                                    </div>
								<?php }
							} ?>
                        </div>
                    	<?php $count++;
					} ?>
            	</div>
            </div>
        </div><!-- #content -->
	</div>
    <div id="content-bottom"></div>
<?php get_footer(); ?>