<?php global $theme_options, $color; ?>

<!-- include google analytics -->
<?php if ($theme_options['cp_trackingcode']) { ?>
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	try {
		var pageTracker = _gat._getTracker("<?php echo $theme_options['cp_trackingcode']; ?>");
		pageTracker._trackPageview();
	} catch(err) {}
</script>
<?php } ?>

<!-- some jquery stuff -->
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
	//var starttime = new Date().getTime();
	
	//style all submit buttons
	$('form:not(.searchform) input[type="submit"]').each(function() {
		$(this).wrap('<div class="readmore submit"></div>');
	});
	
	// Nivo slider settings
	var header = $('#header');
	var slider = $('#slider');

	var nivocheck = false;
	function startnivo() {
		if (nivocheck == false) {
			<?php if ($theme_options['cp_slider_show'] != 'disabled') { ?>
			slider.nivoSlider({
				effect:'<?php echo $theme_options['cp_slider_effect']; ?>',
				slices: 12,
				animSpeed: 1000,
				pauseTime: <?php echo ($theme_options['cp_slider_time'] * 1000); ?>,
				directionNav:true,
				directionNavHide:true,
				controlNav:true,
				pauseOnHover:true,
				manualAdvance:false,
				captionOpacity: 0.7,
				beforeChange: function(){},
				afterChange: function(){}
			});
			<?php } ?>
			nivocheck = true;
		}
	}
	
	// Slider hide & show
	var sliderarrow = $('#slider_arrow');
	<?php if ((is_front_page() && $theme_options['cp_slider_show'] == 'frontpage') || $theme_options['cp_slider_show'] == 'all') { ?>
	startnivo();
	sliderarrow.removeClass("arrow_down").addClass("arrow_up");
	<?php }
	$pageid = $post->ID;
	$sliderheight = (get_post_meta($pageid, "sliderheight", true)) ? get_post_meta($pageid, "sliderheight", true) : $theme_options['cp_sliderheight'];
	if (!$sliderheight) $sliderheight = '400'; ?>
	sliderarrow.click(function(){
		if ($(this).hasClass('arrow_up')) {
			slider.fadeOut(1000);
			header.animate({ 
				height: '80'
			}, 1000, function(){
				sliderarrow.removeClass("arrow_up").addClass("arrow_down");
			});
		} else {
			startnivo();
			slider.fadeIn(1000);
			header.animate({ 
				height: '<?php echo $sliderheight; ?>'
			}, 1000, function(){
				sliderarrow.removeClass("arrow_down").addClass("arrow_up");
			});
		}
	});
	sliderarrow.hover(
		function () {
			$(this).animate({
				top: "-8px"
			}, 100 );
	  	},
	  	function () {
			$(this).animate({
				top: "-6px"
			}, 100 );
	  	}
	);
	
	// Mark menu items with submenus
	$('#mainmenu ul.menu li ul.sub-menu').parent().addClass("has-sub-menu").append('<div class="dropdown_arrow"></div>');

	// Add a font class to all dynamic font elements
	$('h1, h2, h3, ul.menu li a, #slider .nivo-caption p, .post-title').addClass("font");
	$('.sidepanel .post-title').removeClass("font");

	// Button hover effect
	$(".readmore, input[type='submit']").hover(
		function () {
			$(this).stop().animate({
				opacity: 0.8
			}, 200 );
	  	},
	  	function () {
			$(this).stop().animate({
				opacity: 1
			}, 100 );
	  	}
	);
	
	// Image hover effect
	$('.hoverfade').children('img').hover(
		function () {
			$(this).stop().animate({
				opacity: 0.50
			}, 200);
	  	},
	  	function () {
			$(this).stop().animate({
				opacity: 1.0
			}, 100);
	  	}
	);
	
	//center images
	$('.centerimg').children('img').imgCenter({
		centerVertical: true,
		parentSteps: 1
	});
	
	//fancybox magic
	$("a.fancybox").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	400, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});
	
	// Toggle shortcode animation
	$('div.toggle.fold').children('div.toggle-content').hide();
	$('div.toggle').children('h4.title').click(function() {
		var parent = $(this).parent();
		parent.toggleClass('fold');
		parent.children('div.toggle-content').slideToggle(300);
	});
	
	// Menu card
	window.cardcontainer = $('#card-container');
	window.cardnext = $('#card-next');
	window.cardprev = $('#card-prev');
	window.activepage = cardcontainer.attr('activepage');
	cardcontainer.animate({
		height: $('#cardpageid-' + window.activepage).height()
	}, 500 );
	if (window.activepage == 1) {
		cardprev.fadeOut(0);
	}
	var marginLeft = ((window.activepage-1)*956)*-1;
	$('#card-slider').css("left",marginLeft);
	window.totalPages = $('.card-page').size();
	if (window.activepage == window.totalPages){
		window.cardnext.fadeOut(0);
	}
	window.blockAnimation = false;
	$('#card-next, #card-prev').click(function(){
		direction = $(this).attr('id')
		if ( direction == 'card-next' ){
			cardNavigation(false)
		} else {
			cardNavigation(true)
		}
		return false
	});
	cardprev.hover(
		function () {
			$(this).animate({
				left: "-10px"
			}, 100 );
	  	},
	  	function () {
			$(this).animate({
				left: "-8px"
			}, 100 );
	  	}
	);
	cardnext.hover(
		function () {
			$(this).animate({
				right: "-10px"
			}, 100 );
	  	},
	  	function () {
			$(this).animate({
				right: "-8px"
			}, 100 );
	  	}
	);
	
	$(window).scroll(function() {
		scrollArrows();
    });
	var cardNext = $("#card-next");
	var position = cardNext.position();
	var arrowHeight = cardNext.height();
	var oldscroll = 0;
	function scrollArrows() {
		if (cardNext && position && arrowHeight) {
			var scrolltop = $(window).scrollTop();
			var scrollmoved = scrolltop - oldscroll;
			oldscroll = scrolltop;
			var topmargin = scrolltop + position.top;
			
			var mc_position = cardNext.position();
			var mc_height = $(".menucard").height();
			
			if ((topmargin + scrollmoved) > (mc_height - position.top - arrowHeight)) {
				topmargin = mc_height - position.top;
			}
	
			$("#card-next, #card-prev").stop().animate({
				top: topmargin
			}, 500);
		}
	}
	
	function cardNavigation(prev){
		marginLeft = ((window.activepage-1)*956)*-1;
		if (window.blockAnimation == false) {
			window.blockAnimation = true;
			if ( prev == true ){
				window.activepage--;
			} else {
				window.activepage++;
			}
			if (window.activepage == window.totalPages){
				window.cardnext.fadeOut(500);
			}
			if (window.activepage == (window.totalPages-1)){
				window.cardnext.fadeIn(500);
			}
			if (window.activepage == 1){
				window.cardprev.fadeOut(500);
			}
			if (window.activepage == 2){
				window.cardprev.fadeIn(500);
			}
			
			left = ( prev == true ) ? (marginLeft + 956) : (marginLeft - 956)
			$('#card-slider').animate({
				left: left
			}, 1000, function(){
				window.blockAnimation = false;
			});
			
			window.cardcontainer.attr('activepage', window.activepage).animate({
				height: $('#cardpageid-' + window.activepage).height()
			}, 1000, function(){
				scrollArrows();
			});
		}
	}
	
	//var elapsed = new Date().getTime() - starttime;
	//alert('Time elapsed: ' + elapsed + ' milliseconds');
});
/* ]]> */
</script>