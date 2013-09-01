<?php

/**
 * Add entry in admin menu and an icon to the admin drop down menu
 */
function zcmail_add_pages() {
	$page = add_options_page( __( 'Zero Conf Mail', 'zero-conf-mail' ), __( 'Zero Conf Mail', 'zero-conf-mail' ), 10, 'zero-conf-mail', 'zcmail_options_page' );
	add_action( 'admin_head-' . $page, 'zcmail_css_admin' );

	// Add icon
	add_filter( 'ozh_adminmenu_icon_zero-conf-mail', 'zcmail_icon' );
}

/**
 * Return admin menu icon
 *
 * @return string path to icon
 *
 * @since 0.3.2.1
 */
function zcmail_icon() {
	return get_bloginfo( 'home' ) . '/' . PLUGINDIR . '/zero-conf-mail/pic/email.png';
}

/**
 * Load admin CSS style
 *
 * @since 0.1.10
 *
 * @todo check if this is correct
 */
function zcmail_css_admin() { ?>
	<link rel="stylesheet" href="<?php echo get_bloginfo( 'home' ) . '/' . PLUGINDIR . '/zero-conf-mail/css/admin.css?v=0.2.2' ?>" type="text/css" media="all" /> <?php
}

/**
 * Plugin activation hook
 */
function zcmail_activate() {
	if ( !get_option( 'zcmail' ) ) {
		// fresh install
		zcmail_reset();
		return;
	}

	$old_option = get_option( 'zcmail' );

	// migrate to 0.1.0 data structure
	if ( version_compare( $old_option['version'] , '0.1.0') == -1 ) {
		zcmail_reset();
		$new_option = get_option( 'zcmail' );

		$new_option['config']['to'] = $old_option['recipient'];
		$new_option['config']['js'] = 'Enabled';

		$new_option['fields']['name']['label']		= $old_option['name'];
		$new_option['fields']['subject']['label']	= $old_option['subject'];
		$new_option['fields']['from']['label']		= $old_option['mail'];
		$new_option['fields']['body']['label']		= $old_option['message'];
		$new_option['fields']['submit']['label']	= $old_option['submit'];

		update_option( 'zcmail', $new_option );
	}

	// migrate to 0.3.1 data structure
	if ( version_compare( $old_option['version'] , '0.3.1') == -1 ) {
		$option = get_option( 'zcmail' );
		// Enable CSS as it's the new default
		$option['version'] = '0.3.1';
		$option['config']['css'] = 'Enabled';

		update_option( 'zcmail', $option );
	}

	// migrate to 0.4.0 data structure
	if ( version_compare( $old_option['version'] , '0.4.0') == -1 ) {
		$option = get_option( 'zcmail' );
		// Bumb version
		$option['version'] = '0.4.0';
		// Add log field
		$option['log'] = array();
		// Add flood config
		$option['config']['flood'] =  array(
			'maxmails'	=> 10,
			'minhours'	=> '1',
		);
		update_option( 'zcmail', $option );
	}

	// todo don't autoload values, only needed in admin and on form page!
}

/**
 * Clean up when uninstalled, delete settings from db
 */
function zcmail_uninstall() {
	delete_option( 'zcmail' );
}

/**
 * Reset the configuration. Used for default configuration as well.
 * Get sane, localized defaults and get current user's email address.
 *
 * @since 0.1.0
 * @todo should return the values, not update the options...
 */
function zcmail_reset() {
	// wtf... plugin activation hook runs before init?!
	//zcmail_load_translation_file();
	global $user_email;
	$default = array(
		'version'	=> '0.4.0',
		// 'create new field' label
		'blueprints' => array(
			'new' => array(
				'label' => __('Your new field', 'zero-conf-mail'),
				'type'	=> 'text',
				'must'	=> false,
				'pos'	=> 0,
			),
		),
		'fields'	=> array(
			'name'	=> array(
				'pos'	=> 10,
				'label' => __('Your name', 'zero-conf-mail'),
				'type'	=> 'text',
				'must'	=> true,
			),
			'from'	=> array(
				'pos'	=> 20,
				'label' => __('Your email', 'zero-conf-mail'),
				'type'	=> 'email',
				'must'	=> true,
			),
			'subject'	=> array(
				'pos'	=> 30,
				'label' => __('Subject', 'zero-conf-mail'),
				'type'	=> 'text',
				'must'	=> false,
			),
			'body'		=> array(
				'pos'	=> 40,
				'label' => __('Your message', 'zero-conf-mail'),
				'type'	=> 'textarea',
				'must'	=> true,
			),
			'submit'	=> array(
				'pos'	=> 50,
				'label' => __('Send message', 'zero-conf-mail'),
				'type'	=> 'submit',
				'must'	=> false,
			),
		),
		// fixed config shouldn't be localized, breaks on language switch
		// FIXME now we need to move from strings to consts
		'config'		=> array(
			'to'		=> $user_email,
			'js'		=> 'Enabled',
			'css'		=> 'Enabled',
			'homelink'	=> 'In the footer',
			'flood'		=> array(
				'maxmails'	=> 10,
				'minhours'	=> '1',
			),
			'messages'	=> array(
				'failure'	=> __('Please fill out all fields!', 'zero-conf-mail'),
				'success'	=> __('Your message has been sent. Thank you!', 'zero-conf-mail'),
			),
			'input_types' => array(
				'text',
				'textarea',
				'email',
				'submit',
			),
			'advanced'		=> 'Disabled',
			'jumpanchor'	=> 'Disabled',
			'homelink_choices' => array(
				'Below the form',
				'In the footer',
				'Nowhere',
			),
			'enable_choices' => array(
				'Enabled',
				'Disabled',
			),
		),
		'log'			=> array(),
	);
	$default = zcmail_uasort($default);
	update_option( 'zcmail', $default );
}

/**
 * Sort fields by position
 *
 * @param array $data multiple fields
 * @return array multiple sorted fields
 */
function zcmail_uasort($data) {
	uasort($data['fields'], 'zcmail_uasort_callback');
	return($data);
}

/**
 * Callback for uasort, see http://php.net/manual/function.uasort.php
 *
 * @param array $a single field
 * @param array $b single field
 *
 * @return array sorted fields
 */
function zcmail_uasort_callback($a, $b) {
	return ($a['pos'] < $b['pos'] ) ? -1 : 1;
}

/**
 * Print the options page
 *
 * @todo make this more readable...
 * @todo check if we should encode html entities in field labels
 */
function zcmail_options_page() {
	// Check permissions
	if (current_user_can('manage_options')) { ?>
		<div class="wrap" > <?php
		if ( isset( $_POST['pass'] ) ) {
			$nonce = $_POST['_wpnonce'];
			if ( !wp_verify_nonce( $nonce, 'zero-conf-mail') ) die( 'Security check' );
			$option = get_option( 'zcmail' );
			// FIXME use array ?
			unset( $_POST['_wp_http_referer'] );
			unset( $_POST['_wpnonce'] );
			switch ( $_POST['pass'] ) {
				case 'admin_fields':
					$updated_fields = $_POST;
	
					unset( $updated_fields['pass'] );
	
					// merge new into old values
					foreach ( $option['fields'] as $key => $field ) {
						$option['fields'][$key] = array_merge($field, $updated_fields[$key]);
					}
	
					// strip slashes from labels
					foreach ( $option['fields'] as $fieldname => $values ) {
						$option['fields'][$fieldname]['label'] = stripslashes($values['label']);
					}
	
					// sort the result
					$option = zcmail_uasort( $option );
					update_option( 'zcmail', $option );
					echo '<div class="updated">' . __( 'Fields saved', 'zero-conf-mail' ) . '</div>';
					break;
				case 'config':
					$config = $_POST['config'];
					// TODO will this work for arrays?
					foreach( $config as $key => $value ) {
						$option['config'][$key] = $value;
					}
					// TODO checkboxes don't submit anything if unchecked, so we can't simply
					// merge...
					// And check that the whole form was submitted... this is ugly code...
					if ( !isset( $_POST['config']['css'] ) && isset( $_POST['config']['to'] ) ) {
						$option['config']['css'] = 'Disabled';
					}
	
					// TODO wouldn't objects be handy?
					$option['config']['flood']['maxmails']	= intval( $option['config']['flood']['maxmails'] );
					$option['config']['flood']['minhours']	= intval( $option['config']['flood']['minhours'] );
					if( $option['config']['flood']['maxmails'] == 0 ) {
						$option['config']['flood']['maxmails'] = 1;
					}
					if( $option['config']['flood']['minhours'] == 0 ) {
						$option['config']['flood']['minhours'] = 1;
					}
					
	
					update_option( 'zcmail', $option );
					echo '<div class="updated">' . __( 'Settings saved', 'zero-conf-mail' ) . '</div>';
					break;
				case 'reset':
					zcmail_reset();
					$option = get_option( 'zcmail' );
					echo '<div class="updated">' . __( 'The default configuration was restored', 'zero-conf-mail' ) . '</div>';
					break;
				case 'add':
					$new = $_POST['new'];
					$option['fields'][] = $new;
					$option = zcmail_uasort( $option );
					update_option( 'zcmail', $option );
					echo '<div class="updated">' . __( 'Field added', 'zero-conf-mail' ) . '</div>';
					break;
				case 'delete':
					$position = intval( $_POST['position'] );
	
					foreach ( $option['fields'] as $key => $fields ) {
						if ( intval( $fields['pos'] ) == $position ) {
							if ( !is_string( $key ) ) { // FIXME
								unset( $option['fields'][$key] );
								echo '<div class="updated" >' . sprintf( __( "Field with position %s deleted", 'zero-conf-mail' ), $position ) . '</div>';
							}
							else {
								echo '<div class="error" >' . __( 'Can not delete this field', 'zero-conf-mail' ) . '</div>';
							}
						}
					}
					update_option( 'zcmail', $option );
					break;
			}
		}
		$option = get_option( 'zcmail' ); ?>

		<h2><?php _e( 'Zero Conf Mail', 'zero-conf-mail' )?></h2> <?php 
		require_once( 'nkuttler.php' );
		nkuttler0_2_4_links( 'zero-conf-mail', 'http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/' ) ?>
		<p> <?php _e( "I'm sure I am reinventing the wheel with this plugin. However, sometimes it's faster to simply write something yourself than it is to find something that does what you want. This plugin uses no Ajax, no bloated libraries. And it doesn't need to be configured at all.", 'zero-conf-mail' ) ?><br />
		<p> <?php _e( 'Simply include it on any page or post by putting <tt>[zcmail]</tt> into the page content.' ,'zero-conf-mail' )?> </p>
	
		<h3><?php _e( 'Your email form', 'zero-conf-mail' ) ?></h3>
		<p><?php _e( 'This is a preview of your email form:', 'zero-conf-mail' ) ?></p>
		<div id="zcmail">
			<?php echo zcmail_printform( true ); ?>
		</div> <?php

		if ( !is_email( $option['config']['to'] ) ) { ?>
			<div class="error"><?php _e( "It looks like the configured email isn't valid, please check the advanced configuration!", 'zero-conf-mail' ) ?></div> <?php
		} ?>

		<p><?php printf( __( "The mails are being sent to <strong>%s</strong>.", 'zero-conf-mail' ), $option['config']['to'] ) ?></p>

		<a name="customize"></a>
		<h2><?php _e( 'Customize the form', 'zero-conf-mail' ) ?></h2>
	
		<form action="" method="post"> <?php
			function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'zero-conf-mail' ) : null; ?>
			<input type="hidden" name="pass" value="config" />

			<table class="form-table" >

				<tr>
					<th>
						<label>
							<?php _e( 'Do you want to see the customization options?', 'zero-conf-mail' ) ?>
						<label>
					</th>
					<td>
						<?php zcmail_select( "config[advanced]", $option['config']['advanced'], $option['config']['enable_choices'] ); ?>
					</td>
				</tr> <?php

				if ( $option['config']['advanced'] == 'Enabled' ) { ?>

					<tr>
						<th>
							<label>
								<?php _e( 'Include the recommended CSS styles?', 'zero-conf-mail' ); ?>
							<label>
						</th>
						<td>
							<?php zcmail_checkbox( 'config[css]', $option['config']['css'] ); ?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( 'Who receives the emails', 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td>
							<?php zcmail_input( "config[to]", $option['config']['to'], false ); ?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( "Message when the form wasn't completed", 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td>
							<?php zcmail_input( "config[messages][failure]", $option['config']['messages']['failure'], false ); ?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( "Message when the mail was sent", 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td>
							<?php zcmail_input( "config[messages][success]", $option['config']['messages']['success'], false ); ?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( 'Flood protection', 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td> <?php
							printf ( __( "Allow a maximum of %s emails being sent per IP per %s hours.", 'zero-conf-mail' ),
								get_zcmail_input( "config[flood][maxmails]", $option['config']['flood']['maxmails'], false, 3 ),
								get_zcmail_input( "config[flood][minhours]", $option['config']['flood']['minhours'], false, 3 )
							);
							?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( 'Where to put the home link', 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td>
							<?php zcmail_select( "config[homelink]", $option['config']['homelink'], $option['config']['homelink_choices'] ) ?>
						</td>
					</tr>

					<tr>
						<th>
							<label>
								<?php _e( 'Jump to the form after submitting it?', 'zero-conf-mail' ) ?>
							<label>
						</th>
						<td>
							<?php zcmail_select( "config[jumpanchor]", $option['config']['jumpanchor'], array( 'Disable', 'Enable' ) ) ?>
						</td>
					</tr> <?php
				} ?>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'zero-conf-mail' ) ?>" />
			</p>
		</form> <?php

		if ( $option['config']['advanced'] == 'Enabled' ) { ?>
			<h3><?php _e( 'Input fields configuration', 'zero-conf-mail' )?></h3> <?php
			$option = get_option( 'zcmail' ); ?>
			<form action="" method="post">
				<?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'zero-conf-mail' ) : null; ?>
				<table >
					<?php zcmail_thead( $option['config']['advanced'] ) ?>
					<tbody><?php
						zcmail_admin_rows( $option['fields'], $option['config'] );
					?>
					</tbody>
				</table>
				<br />
				<input type="hidden" name="pass" value="admin_fields" />
	
				<!--
				<h3><?php _e('Add a pinch of JavaScript?', 'zero-conf-mail')?></h3>
				<p>
					<?php _e('I recommend that you enable this. It will just add a few characters to the HTML source of the contact form. It doesn\'t depend on any external JavaScript.', 'zero-conf-mail')?>
				</p>
				<?php zcmail_select('config_js', $option['config']['js'], $option['config']['enable_choices'] ); ?>
				<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'zero-conf-mail') ?>">
				-->
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'zero-conf-mail' ) ?>" />
				</p>
			</form>
	
			<h3><?php _e( 'Add a custom field', 'zero-conf-mail' ) ?></h3>
			<form action="" method="post">
				<?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'zero-conf-mail' ) : null; ?>
				<input type="hidden" name="pass" value="add" />
				<table > <?php
				zcmail_thead( $option['config']['advanced'] );
				zcmail_admin_rows( $option['blueprints'], $option['config'] ); ?>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Add Field', 'zero-conf-mail' ) ?>" />
				</p>
			</form>

			<h3><?php _e( 'Delete a field', 'zero-conf-mail' ) ?></h3>
			<p>
				<?php _e( 'Please enter the position of the field to delete.', 'zero-conf-mail' ) ?>
			</p>
			<form action="" method="post">
				<?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'zero-conf-mail' ) : null; ?>
				<input type="hidden" name="pass" value="delete" />
				<table> <?php
				zcmail_input( 'position', __( 'Position', 'zero-conf-mail' ), true, 10 ); ?>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Delete Field', 'zero-conf-mail' ) ?>" />
				</p>
			</form> <?php
		} ?>

		<h3><?php _e( 'Reset the plugin', 'zero-conf-mail' ) ?></h3>
		<p><?php _e( '<strong>Careful!</strong> This will delete any customizations you have made and will also translate the form into your language if possible.', 'zero-conf-mail' ) ?></p>
		<form action="" method="post">
			<?php function_exists( 'wp_nonce_field' ) ? wp_nonce_field( 'zero-conf-mail' ) : null; ?>
			<input type="hidden" name="pass" value="reset" />
			<p class="submit">
				<input type="submit" class="button-secondary" value="<?php _e( 'Reset the plugin', 'zero-conf-mail' ) ?>" />
			</p>
		</form>
	</div> <?php
	}
}

/**
 * Print rows from a set of field definitions
 *
 * @param array $data field definitions
 * @param array $config configuration definitions
 */
function zcmail_admin_rows( $data, $config ) {
	foreach ( $data as $name => $field ) {
	?>
		<tr>
			<td>
				<?php zcmail_input( $name."[label]", $field['label'], false ); ?>
			</td> <?php
			if ($config['advanced'] == 'Enabled' ) { ?>
				<td>
					<?php zcmail_select( $name."[type]", $field['type'], $config['input_types'] ) ?>
				</td>
				<td >
					<?php zcmail_bool( $name."[must]", $field['must'] ) ?>
				</td>
				<td>
					<?php zcmail_input( $name."[pos]", $field['pos'], false, 3 ); ?>
				</td> <?php
			} ?>
		</tr><?php
	}
}

/**
 * The admin fields list table header
 *
 * @param string $advanced show advanced columns
 */
function zcmail_thead($advanced) { ?>
	<thead> 
		<tr>
			<td><?php _e( 'Label', 'zero-conf-mail' ) ?></td><?php
			if ( $advanced == 'Enabled' ) { ?>
				<td><?php _e( 'Type', 'zero-conf-mail') ?></td>
				<td><?php _e( 'Mandatory (y/n)?', 'zero-conf-mail' ) ?></td>
				<td><?php _e( 'Position', 'zero-conf-mail' ) ?></td> <?php
			} ?>
		</tr>
	</thead><?php
}
?>
