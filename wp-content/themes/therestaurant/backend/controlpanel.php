<?php
class ControlPanel {
  var $themename = 'therestaurant';
  var $default_settings = Array(
	'cp_color' => 'c10000',
	'cp_color_header' => '2f2720',
	'cp_font' => 'Junction',
	'cp_pattern_header' => 'patern_sharp',
	'cp_pattern_ribbon' => 'patern_sharp',
	'cp_pattern_button' => 'patern_sharp',
	'cp_stars' => '4',
	'cp_sidebar_position' => 'right',
	'cp_breadcrumbs' => '1',
	'cp_tagline' => 'Truely the best restaurant in town - The New York Times',
	'cp_error' => 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.',
	'cp_search_error' => 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.',
	'cp_slider_show' => 'frontpage',
	'cp_slider_effect' => 'random',
	'cp_slider_time' => '10',
	'cp_slider_number' => '5',
	'cp_sliderheight' => '400',
	'cp_img_quality' => '1'
  );
  function ControlPanel() {
	//add_action('admin_init', array(&$this, 'admin_init'));
	add_action('admin_menu', array(&$this, 'admin_menu'));
	//add_action('admin_head', array(&$this, 'admin_head'));
	if (!is_array(get_option($this->themename))) {
		add_option($this->themename, $this->default_settings);
		$this->options = get_option($this->themename);
	}
	$this->options = get_option($this->themename);
  }
  function admin_menu() {
    add_theme_page('Theme Control Panel', 'Theme settings', 'edit_themes', $this->themename, array(&$this, 'optionsmenu'));
  }
  function admin_init() {}
  function admin_head() {}
  function optionsmenu() {
	  ?>
	  <script type="text/javascript">
	  jQuery(document).ready(function($){
		  $(".colorpickertool").ColorPicker({
			  onSubmit: function(hsb, hex, rgb, el) {
				  $(el).val(hex);
				  $(el).ColorPickerHide();
			  },
			  onBeforeShow: function () {
				  $(this).ColorPickerSetColor(this.value);
			  }
		  })
		  .bind("keyup", function(){
			  $(this).ColorPickerSetColor(this.value);
		  });
		  $(".item-general").css("display","block");
		  $(".menu-item").click(function(){
			  $(".menu-item").removeClass("current-item");
			  $(this).addClass("current-item");
			  var item = $(this).attr("item");
			  $(".rm_section").css("display","none");
			  $("."+item).css("display","block");
			  return false;
		  });

		  $('#add_sidebar_button').click(function(){
			  var content = '<div class="rm_input rm_select"><label for="cp_sidebar_name[]">New sidebar name</label><input type="text" name="cp_sidebar_name[]" id="cp_sidebar_name[]" value="" /><small>The nickname of the sidebar. Please dont use special characters!</small><div class="clearfix"></div></div>';
			  $('#customsidebars').append(content);
			  return false;
		  });
	  });
	  </script>
	  <?php
	  
	  if ($_POST['ss_action'] == 'save') {
		$this->options["cp_bloglogo"] = $_POST['cp_bloglogo'];
		$this->options["cp_favicon"] = $_POST['cp_favicon'];
		$this->options["cp_trackingcode"] = $_POST['cp_trackingcode'];
		$this->options["cp_sidebar_position"] = $_POST['cp_sidebar_position'];
		$this->options["cp_tagline"] = $_POST['cp_tagline'];
		$this->options["cp_img_quality"] = $_POST['cp_img_quality'];
		$this->options["cp_error"] = $_POST['cp_error'];
		$this->options["cp_search_error"] = $_POST['cp_error'];
		$this->options["cp_color"] = $_POST['cp_color'];
		$this->options["cp_color_header"] = $_POST['cp_color_header'];
		$this->options["cp_pattern_header"] = $_POST['cp_pattern_header'];
		$this->options["cp_pattern_ribbon"] = $_POST['cp_pattern_ribbon'];
		$this->options["cp_pattern_button"] = $_POST['cp_pattern_button'];
		$this->options["cp_font"] = $_POST['cp_font'];
		$this->options["cp_stars"] = $_POST['cp_stars'];
		$this->options["cp_breadcrumbs"] = $_POST['cp_breadcrumbs'];
		$this->options["cp_slider_show"] = $_POST['cp_slider_show'];
		$this->options["cp_slider_effect"] = $_POST['cp_slider_effect'];
		$this->options["cp_slider_time"] = $_POST['cp_slider_time'];
		$this->options["cp_sliderheight"] = $_POST['cp_sliderheight'];
		$this->options["cp_sidebar_name[]"] = $_POST['cp_sidebar_name'];
		$this->options["cp_share_twitter"] = $_POST['cp_share_twitter'];
		$this->options["cp_share_fb"] = $_POST['cp_share_fb'];
		$this->options["cp_share_gbuzz"] = $_POST['cp_share_gbuzz'];
		$this->options["cp_share_digg"] = $_POST['cp_share_digg'];
		$this->options["cp_share_del"] = $_POST['cp_share_del'];
		$this->options["cp_share_stumble"] = $_POST['cp_share_stumble'];
		$this->options["cp_share_linkedin"] = $_POST['cp_share_linkedin'];
		$this->options["cp_share_google"] = $_POST['cp_share_google'];
		update_option($this->themename, $this->options);
		echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 300px; margin-left: 20px"><p>Settings <strong>saved</strong>.</p></div>';
	  }
	  ?>
      <div class="wrap rm_wrap">
          <h2>Theme settings</h2>
          <p>To easily use the theme, use the options below.</p>
          <div id="theme-menu">
              <div class="menu-item current-item" item="item-general">General</div>
              <div class="menu-item" item="item-design">Design</div>
              <div class="menu-item" item="item-frontpage">Slider</div>
              <div class="menu-item" item="item-sidebars">Custom sidebars</div>
              <div class="menu-item" item="item-social">Social sharing</div>
          </div>
          <div class="rm_opts">
              <form action="" method="post" class="themeform">
                  <input type="hidden" id="ss_action" name="ss_action" value="save">
                  <div class="rm_section item-general">
                      <div class="rm_title">
                          <h3>General</h3>
                          <span class="submit">
                              <input type="submit" value="Save Changes" name="cp_save"/>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_bloglogo">Blog logo</label>
                          <input type="text" name="cp_bloglogo" id="cp_bloglogo" class="upload_field" value="<?php echo $this->options["cp_bloglogo"]; ?>" />
                          <small><input class="upload_button" type="button" value="Browse" /></small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_favicon">Favicon</label>
                          <input type="text" name="cp_favicon" id="cp_favicon" class="upload_field" value="<?php echo $this->options["cp_favicon"]; ?>" />
                          <small><input class="upload_button" type="button" value="Browse" /></small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_trackingcode">Google analytics</label>
                          <input type="text" name="cp_trackingcode" id="cp_trackingcode" value="<?php echo $this->options["cp_trackingcode"]; ?>" />
                          <small>Insert your google analytics tracking number</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_select">
                          <label for="cp_sidebar_position">Sidebar position</label>
                          <select name="cp_sidebar_position" id="cp_sidebar_position">
                          	  <option <?php if ($this->options["cp_sidebar_position"] == 'left') { ?>selected="selected"<?php } ?> value="left">Left</option>
                              <option <?php if ($this->options["cp_sidebar_position"] == 'right') { ?>selected="selected"<?php } ?> value="right">Right</option>
                              <option <?php if ($this->options["cp_sidebar_position"] == 'hidden') { ?>selected="selected"<?php } ?> value="hidden">Hidden (full width content)</option>
                          </select>
                          <small>The position of the sidebar</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_breadcrumbs">Display breadcrumbs</label>
                          <input type="checkbox" <?php if ($this->options["cp_breadcrumbs"] == '1') { echo 'checked'; } ?>  name="cp_breadcrumbs" id="cp_breadcrumbs" value="1" />
                          <small>Displays breadcrumbs at the top of every page</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_img_quality">Maximum image quality</label>
                          <input type="checkbox" <?php if ($this->options["cp_img_quality"] == '1') { echo 'checked'; } ?>  name="cp_img_quality" id="cp_img_quality" value="1" />
                          <small>Disables the default wordpress image (jpeg) compression. This will result in higher quality images, but will sacrifice on page loading speed. Only applies to newly uploaded images.</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_tagline">Header tagline</label>
                          <textarea rows="5" cols="50" name="cp_tagline" id="cp_tagline"><?php echo stripslashes(htmlspecialchars($this->options["cp_tagline"])); ?></textarea>
                          <small>The tagline found in the top right corner of the website</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_search_error">Search error</label>
                          <textarea rows="5" cols="50" name="cp_search_error" id="cp_search_error"><?php echo stripslashes(htmlspecialchars($this->options["cp_search_error"])); ?></textarea>
                          <small>The text displayed on a 'No search results found' page</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_error">404 error message</label>
                          <textarea rows="5" cols="50" name="cp_error" id="cp_error"><?php echo stripslashes(htmlspecialchars($this->options["cp_error"])); ?></textarea>
                          <small>The text displayed on a 404 error page</small><div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="rm_section item-design">
                      <div class="rm_title">
                          <h3>Design</h3>
                          <span class="submit">
                              <input type="submit" value="Save Changes" name="cp_save"/>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_color">Website main color</label>
                          <input type="text" name="cp_color" id="cp_color" class="colorpickertool" value="<?php echo $this->options["cp_color"]; ?>" />
                          <small>This is the color of the ribbons and links used on this website</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_color_header">Header background color</label>
                          <input type="text" name="cp_color_header" id="cp_color_header" class="colorpickertool" value="<?php echo $this->options["cp_color_header"]; ?>" />
                          <small>This is the color of the header background</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_select">
                          <label for="cp_font">Title font</label>
                          <select name="cp_font" id="cp_font">
                          	  <option <?php if ($this->options["cp_font"] == 'Junction') { ?>selected="selected"<?php } ?> value="Junction">Junction (cufon)</option>
                          	  <option <?php if ($this->options["cp_font"] == 'Georgia') { ?>selected="selected"<?php } ?> value="Georgia">Georgia</option>
                              <option <?php if ($this->options["cp_font"] == 'Terminal Dosis Light') { ?>selected="selected"<?php } ?> value="Terminal Dosis Light">Terminal Dosis Light</option>
                              <option <?php if ($this->options["cp_font"] == 'EB Garamond') { ?>selected="selected"<?php } ?> value="EB Garamond">EB Garamond</option>
                              <option <?php if ($this->options["cp_font"] == 'Quattrocento') { ?>selected="selected"<?php } ?> value="Quattrocento">Quattrocento</option>
                              <option <?php if ($this->options["cp_font"] == 'PT Sans') { ?>selected="selected"<?php } ?> value="PT Sans">PT Sans</option>
                              <option <?php if ($this->options["cp_font"] == 'Cuprum') { ?>selected="selected"<?php } ?> value="Cuprum">Cuprum</option>
                              <option <?php if ($this->options["cp_font"] == 'Goudy Bookletter 1911') { ?>selected="selected"<?php } ?> value="Goudy Bookletter 1911">Goudy Bookletter 1911</option>
                              <option <?php if ($this->options["cp_font"] == 'Droid Serif') { ?>selected="selected"<?php } ?> value="Droid Serif">Droid Serif</option>
                              <option <?php if ($this->options["cp_font"] == 'Josefin Sans') { ?>selected="selected"<?php } ?> value="Josefin Sans">Josefin Sans</option>
                              <option <?php if ($this->options["cp_font"] == 'Arimo') { ?>selected="selected"<?php } ?> value="Arimo">Arimo</option>
                              <option <?php if ($this->options["cp_font"] == 'Raleway') { ?>selected="selected"<?php } ?> value="Raleway">Raleway</option>
                              <option <?php if ($this->options["cp_font"] == 'Neuton') { ?>selected="selected"<?php } ?> value="Neuton">Neuton</option>
                              <option <?php if ($this->options["cp_font"] == 'Allerta') { ?>selected="selected"<?php } ?> value="Allerta">Allerta</option>
                              <option <?php if ($this->options["cp_font"] == 'Lato') { ?>selected="selected"<?php } ?> value="Lato">Lato</option>
                              <option <?php if ($this->options["cp_font"] == 'Ubuntu') { ?>selected="selected"<?php } ?> value="Ubuntu">Ubuntu</option>
                              <option <?php if ($this->options["cp_font"] == 'Yanone Kaffeesatz') { ?>selected="selected"<?php } ?> value="Yanone Kaffeesatz">Yanone Kaffeesatz</option>
                              <option <?php if ($this->options["cp_font"] == 'Tinos') { ?>selected="selected"<?php } ?> value="Tinos">Tinos</option>
                              <option <?php if ($this->options["cp_font"] == 'Puritan') { ?>selected="selected"<?php } ?> value="Puritan">Puritan</option>
                              <option <?php if ($this->options["cp_font"] == 'Cousine') { ?>selected="selected"<?php } ?> value="Cousine">Cousine</option>
                              <option <?php if ($this->options["cp_font"] == 'Droid Sans') { ?>selected="selected"<?php } ?> value="Droid Sans">Droid Sans</option>
                              <option <?php if ($this->options["cp_font"] == 'Vollkorn') { ?>selected="selected"<?php } ?> value="Vollkorn">Vollkorn</option>
                              <option <?php if ($this->options["cp_font"] == 'Anonymous Pro') { ?>selected="selected"<?php } ?> value="Anonymous Pro">Anonymous Pro</option>
                              <option <?php if ($this->options["cp_font"] == 'Droid Sans Mono') { ?>selected="selected"<?php } ?> value="Droid Sans Mono">Droid Sans Mono</option>
                              <option <?php if ($this->options["cp_font"] == 'Cantarell') { ?>selected="selected"<?php } ?> value="Cantarell">Cantarell</option>
                              <option <?php if ($this->options["cp_font"] == 'Nobile') { ?>selected="selected"<?php } ?> value="Nobile">Nobile</option>
                              <option <?php if ($this->options["cp_font"] == 'Inconsolata') { ?>selected="selected"<?php } ?> value="Inconsolata">Inconsolata</option>
                              <option <?php if ($this->options["cp_font"] == 'OFL Sorts Mill Goudy TT') { ?>selected="selected"<?php } ?> value="OFL Sorts Mill Goudy TT">OFL Sorts Mill Goudy TT</option>
                              <option <?php if ($this->options["cp_font"] == 'Molengo') { ?>selected="selected"<?php } ?> value="Molengo">Molengo</option>
                              <option <?php if ($this->options["cp_font"] == 'Crimson Text') { ?>selected="selected"<?php } ?> value="Crimson Text">Crimson Text</option>
                              <option <?php if ($this->options["cp_font"] == 'Cardo') { ?>selected="selected"<?php } ?> value="Cardo">Cardo</option>
                              <option <?php if ($this->options["cp_font"] == 'Josefin Slab') { ?>selected="selected"<?php } ?> value="Josefin Slab">Josefin Slab</option>
                              <option <?php if ($this->options["cp_font"] == 'Kreon') { ?>selected="selected"<?php } ?> value="Kreon">Kreon</option>
                          </select>
                          <small>The font used for titles</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_select">
                          <label for="cp_stars">Amount of stars</label>
                          <select name="cp_stars" id="cp_stars">
                          	  <option <?php if ($this->options["cp_stars"] == '0') { ?>selected="selected"<?php } ?> value="0">None</option>
                              <option <?php if ($this->options["cp_stars"] == '1') { ?>selected="selected"<?php } ?> value="1">One</option>
                              <option <?php if ($this->options["cp_stars"] == '2') { ?>selected="selected"<?php } ?> value="2">Two</option>
                              <option <?php if ($this->options["cp_stars"] == '3') { ?>selected="selected"<?php } ?> value="3">Three</option>
                              <option <?php if ($this->options["cp_stars"] == '4') { ?>selected="selected"<?php } ?> value="4">Four</option>
                              <option <?php if ($this->options["cp_stars"] == '5') { ?>selected="selected"<?php } ?> value="5">Five</option>
                          </select>
                          <small>Select the amount of stars you want to display in the top menubar</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_pattern_header">Header pattern:</label>
                          <div style="display:inline-block;width:280px;position:relative;">
                          	  <?php $patterns = array("patern","pattern_diag_lr","pattern_diag_rl","pattern_dots","pattern_grid","pattern_horizontal","pattern_vertical","pattern2","pattern2i","pattern3","pattern4","pattern5","pattern5i","pattern6","pattern7","pattern8");
							  foreach ($patterns as $pattern) { ?>
                              	  <div style="display:inline-block;background:#eee;padding:5px;margin:0 5px 5px 0;vertical-align:middle;float:left;position:relative;">
                                    <div class="pattern_preview" style="background:url('<?php bloginfo('template_directory') ?>/images/<?php echo $pattern; ?>.png');height:50px;width:50px;display:inline-block;vertical-align:middle;"></div>
                                    <input style="vertical-align:middle;" type="radio" <?php if ($this->options["cp_pattern_header"] == $pattern) { echo 'CHECKED'; } ?> name="cp_pattern_header" value="<?php echo $pattern; ?>">
                              	  </div>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_pattern_ribbon">Ribbon pattern:</label>
                          <div style="display:inline-block;width:280px;position:relative;">
                          	  <?php //$patterns = array("patern","pattern_diag_lr","pattern_diag_rl","pattern_dots","pattern_grid","pattern_horizontal","pattern_vertical","pattern2","pattern2i","pattern3","pattern4","pattern5","pattern5i","pattern6");
							  foreach ($patterns as $pattern) { ?>
                              	  <div style="display:inline-block;background:#eee;padding:5px;margin:0 5px 5px 0;vertical-align:middle;float:left;position:relative;">
                                    <div class="pattern_preview" style="background:url('<?php bloginfo('template_directory') ?>/images/<?php echo $pattern; ?>.png');height:50px;width:50px;display:inline-block;vertical-align:middle;"></div>
                                    <input style="vertical-align:middle;" type="radio" <?php if ($this->options["cp_pattern_ribbon"] == $pattern) { echo 'CHECKED'; } ?> name="cp_pattern_ribbon" value="<?php echo $pattern; ?>">
                              	  </div>
                              <?php } ?>
                          </div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_pattern_button">Button pattern:</label>
                          <div style="display:inline-block;width:280px;position:relative;">
                          	  <?php //$patterns = array("patern","pattern_diag_lr","pattern_diag_rl","pattern_dots","pattern_grid","pattern_horizontal","pattern_vertical","pattern2","pattern2i","pattern3","pattern4","pattern5","pattern5i","pattern6");
							  foreach ($patterns as $pattern) { ?>
                              	  <div style="display:inline-block;background:#eee;padding:5px;margin:0 5px 5px 0;vertical-align:middle;float:left;position:relative;">
                                    <div class="pattern_preview" style="background:url('<?php bloginfo('template_directory') ?>/images/<?php echo $pattern; ?>.png');height:50px;width:50px;display:inline-block;vertical-align:middle;"></div>
                                    <input style="vertical-align:middle;" type="radio" <?php if ($this->options["cp_pattern_button"] == $pattern) { echo 'CHECKED'; } ?> name="cp_pattern_button" value="<?php echo $pattern; ?>">
                              	  </div>
                              <?php } ?>
                          </div>
                      </div>
                  </div>
                  <div class="rm_section item-frontpage">
                      <div class="rm_title">
                          <h3>Content slider</h3>
                          <span class="submit">
                              <input type="submit" value="Save Changes" name="cp_save"/>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_select">
                          <label for="cp_slider_show">Slider display option</label>
                          <select name="cp_slider_show" id="cp_slider_show">
                          	  <option <?php if ($this->options["cp_slider_show"] == 'frontpage') { ?>selected="selected"<?php } ?> value="frontpage">Only on frontpage</option>
                              <option <?php if ($this->options["cp_slider_show"] == 'all') { ?>selected="selected"<?php } ?> value="all">On all pages</option>
                              <option <?php if ($this->options["cp_slider_show"] == 'hidden') { ?>selected="selected"<?php } ?> value="hidden">Hidden</option>
                              <option <?php if ($this->options["cp_slider_show"] == 'disabled') { ?>selected="selected"<?php } ?> value="disabled">Disabled</option>
                          </select>
                          <small>Auto hide the slider on pages other then the frontpage</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_select">
                          <label for="cp_slider_effect">Transition effect</label>
                          <select name="cp_slider_effect" id="cp_slider_effect">
                          	  <option <?php if ($this->options["cp_slider_effect"] == 'random') { ?>selected="selected"<?php } ?> value="random">Random</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceDown') { ?>selected="selected"<?php } ?> value="sliceDown">Slice down</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceDownLeft') { ?>selected="selected"<?php } ?> value="sliceDownLeft">Slice down left</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceUp') { ?>selected="selected"<?php } ?> value="sliceUp">Slice up</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceUpLeft') { ?>selected="selected"<?php } ?> value="sliceUpLeft">Slice up left</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceUpDown') { ?>selected="selected"<?php } ?> value="sliceUpDown">Slice up down</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'sliceUpDownLeft') { ?>selected="selected"<?php } ?> value="sliceUpDownLeft">Slice up down left</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'fold') { ?>selected="selected"<?php } ?> value="fold">Fold</option>
                              <option <?php if ($this->options["cp_slider_effect"] == 'fade') { ?>selected="selected"<?php } ?> value="fade">Fade</option>
                          </select>
                          <small>The effect of the slider transition</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_slider_time">Rotation interval</label>
                          <input type="text" name="cp_slider_time" id="cp_slider_time" value="<?php echo $this->options["cp_slider_time"]; ?>" />
                          <small>Number of seconds each item should be displayed</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_sliderheight">Slider height (in pixels)</label>
                          <input type="text" name="cp_sliderheight" id="cp_sliderheight" value="<?php echo $this->options["cp_sliderheight"]; ?>" />
                          <small>The default height of the slider</small><div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="rm_section item-sidebars">
                      <div class="rm_title">
                          <h3>Custom sidebars (will be added to the widget page)</h3>
                          <span class="submit">
                              <input type="submit" value="Save Changes" name="cp_save"/>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                      <div id="customsidebars">
					  <?php 
					  if ($this->options["cp_sidebar_name[]"]) {
						  $count = 1;
					  	  foreach ($this->options["cp_sidebar_name[]"] as $i=>$value) {
							  if ($value) { ?>
                                  <div class="rm_input rm_select">
                                      <label for="cp_sidebar_name[<?php echo $i; ?>]">Sidebar #<?php echo $count; ?> name</label>
                                      <input type="text" name="cp_sidebar_name[<?php echo $i; ?>]" id="cp_sidebar_name[<?php echo $i; ?>]" value="<?php echo $this->options["cp_sidebar_name[]"][$i]; ?>" />
                                      <small>The nickname of the sidebar. Please don't use special characters!</small><div class="clearfix"></div>
                                  </div>
					  	  	  <?php $count++;
							  }
						  }
					  } ?>
                      </div>
                      <div class="rm_input rm_select">
                          <input id="add_sidebar_button" type="button" value="Add new sidebar" />
                          <small></small><div class="clearfix"></div>
              		  </div>
              	  </div>
                  <div class="rm_section item-social">
                      <div class="rm_title">
                          <h3>Social sharing</h3>
                          <span class="submit">
                              <input type="submit" value="Save Changes" name="cp_save"/>
                          </span>
                          <div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_twitter">Enable sharing on twitter</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_twitter"] == '1') { echo 'checked'; } ?>  name="cp_share_twitter" id="cp_share_twitter" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on twitter</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_fb">Enable sharing on facebook</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_fb"] == '1') { echo 'checked'; } ?>  name="cp_share_fb" id="cp_share_fb" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on facebook</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_gbuzz">Enable sharing on google buzz</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_gbuzz"] == '1') { echo 'checked'; } ?>  name="cp_share_gbuzz" id="cp_share_gbuzz" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on google buzz</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_digg">Enable sharing on digg</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_digg"] == '1') { echo 'checked'; } ?>  name="cp_share_digg" id="cp_share_digg" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on digg</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_del">Enable sharing on delicious</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_del"] == '1') { echo 'checked'; } ?>  name="cp_share_del" id="cp_share_del" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on delicious</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_stumble">Enable sharing on stumble upon</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_stumble"] == '1') { echo 'checked'; } ?>  name="cp_share_stumble" id="cp_share_stumble" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on stumble upon</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_linkedin">Enable sharing on linkedin</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_linkedin"] == '1') { echo 'checked'; } ?>  name="cp_share_linkedin" id="cp_share_linkedin" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on linkedin</small><div class="clearfix"></div>
                      </div>
                      <div class="rm_input rm_text">
                          <label for="cp_share_google">Enable sharing on google</label>
                          <input type="checkbox" <?php if ($this->options["cp_share_google"] == '1') { echo 'checked'; } ?>  name="cp_share_google" id="cp_share_google" value="1" />
                          <small>This will display a link under your posts to let visitors share the post on google</small><div class="clearfix"></div>
                      </div>
              	  </div>
              </form>
          </div>
      </div>
      <?php	 
  }
}
?>