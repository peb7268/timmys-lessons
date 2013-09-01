<?php
/*
Plugin Name: Zero Conf Mail
Plugin URI: http://www.nkuttler.de/wordpress/zero-conf-mail/
Author: Nicolas Kuttler
Author URI: http://www.nkuttler.de/
Description: Mail form that doesn't need any configuration.
Version: 0.6.1.1
Text Domain: zero-conf-mail
*/

/**
 * This file		Functions that are always needed
 * inc/admin.php	Admin stuff
 * inc/page.php		Things only needed when the shortcode is on a page/post
 */

/**
 * Check if we run as admin and load all that is needed
 */
function zcmail_load() {
	zcmail_load_translation_file();

	if ( is_admin() ) {
		require_once( 'inc/admin.php' );
		require_once( 'inc/page.php' );

		add_action( 'admin_menu', 'zcmail_add_pages' );
	}
	else {
		require_once( 'inc/page.php' );

		$option = get_option( 'zcmail' );
		if ( $option['config']['css'] == 'Enabled' ) {
			add_action( 'wp_head', 'zcmail_include_css' );
		}

		add_shortcode( 'zcmail', 'zcmail_shortcode' );
	}
}
add_action( 'init', 'zcmail_load' );

/**
 * The shortcode.
 *
 * @return string the zero conf mail form
 */
function zcmail_shortcode() {
	add_action( 'init', 'zcmail_load_translation_file' );
	return zcmail_post2mail();
}

/**
 * Load Translations
 */
function zcmail_load_translation_file() {
	$plugin_path = plugin_basename( dirname( __FILE__ ) .'/translations' );
	load_plugin_textdomain( 'zero-conf-mail', '', $plugin_path );
}

/**
 * Hotfix
 *
 * @todo doc
 */
register_activation_hook( __FILE__, 'zcmail_pre_activate' );
register_uninstall_hook( __FILE__, 'zcmail_pre_uninstall' );

function zcmail_pre_activate() {
	require_once( 'inc/admin.php' );
	zcmail_activate();
}

function zcmail_pre_uninstall() {
	require_once( 'inc/admin.php' );
	zcmail_uninstall();
}

function widget_zcmail( $args ) {
	extract( $args );
	echo $before_widget;
	echo $before_title . $after_title;
	echo zcmail_post2mail();
	echo $after_widget;
}
/**
 * Do this later
 *
 * @todo document this, and the hotfix above... I already forgot why it was
 * needed :-/
 */
function zcmail_plugins_loaded() {
	register_sidebar_widget( __( 'Zero Conf Mail Widget', 'zero-conf-mail'), 'widget_zcmail' );
}
add_action( 'plugins_loaded', 'zcmail_plugins_loaded' );
