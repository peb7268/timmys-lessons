<?php

/**
 * Get post data and do and send the mail
 *
 * @todo Hardcoded field names. Current fix is to disallow field deletion.
 */
function zcmail_post2mail() {
	$return ='<div id="zcmail">';
	$option = get_option( 'zcmail' );
	if ( isset( $_POST['zcmail'] )) {
		if ( !zcmail_floodprotect( $option, $_SERVER['REMOTE_ADDR'] ) ) {
			$return .= '<div class="zcmail_error"> ';
			$return .= __( 'Temporarily closed', 'zero-conf-mail' );
			$return .= '</div></div>';
			return $return;
		}
		if ( zcmail_validates( $_POST['zcmail'], $option ) ) {
			if ( $_POST['zcmail']['from'] ) {
				$from = $_POST['zcmail']['from'];
			}
			else {
				$from = 'Bug 01 - no from field defined';
			}

			if ( $_POST['zcmail']['subject'] ) {
				$subject  = '[' . get_bloginfo( 'name' ) . '] ';
				$subject .= $_POST['zcmail']['subject'];
			}
			else {
				$subject = 'Bug 02 - no subject field defined';
			}

			if ( $_POST['zcmail']['name'] ) {
				$message = $_POST['zcmail']['name'];
			}

			if ( $_POST['zcmail']['body'] ) {
				$message .= "\n\n" . stripslashes( $_POST['zcmail']['body'] );
			}
			else {
				$message .= "\n\n" . 'Bug 03 - no message field defined';
			}

			if ( $_POST['zcmail']['honeypot'] != '' ) {
				$stickyfingers = true;
			}

			foreach($_POST['zcmail'] as $field => $values) {
				// TODO I guess this should be safe, as a[] = foo => a[0] == foo 
				// Add custom fields to the message
				if ( is_integer( $field ) ) {
					$message .= "\n";
					$message .= $option['fields'][$field]['label'] . ": $values";
				}
			}

			// Add message footer
			$message .= "\n\n---\n" . __( 'Sent with Zero Conf Mail: ', 'zero-conf-mail' );
			$message .= __( 'http://www.nkuttler.de/wordpress/zero-conf-mail/', 'zero-conf-mail' );
			$message .= "\n\n" . __( 'Blog: ', 'zero-conf-mail' );
			$message .= get_bloginfo( 'home' );
			$message .= "\n" . __( 'Page: ', 'zero-conf-mail' );
			$message .= $_SERVER['REQUEST_URI'];
			$message .= "\n" . __( 'From: ', 'zero-conf-mail' );
			$message .= $from;
			$message .= "\n" . __( 'IP  : ', 'zero-conf-mail' );
			$message .= $_SERVER['REMOTE_ADDR'];

			$message = zcmail_sanitize( $message );

			// silently drop mails that touched the honeypot
			if ( $stickyfingers )
				$success = true;
			else
				$success = zcmail_sendmail( $option['config']['to'], $from, $subject, $message );

			if ( $success ) {
				$return .= '<div class="zcmail_success">';
				$return .= $option['config']['messages']['success'];
				$return .= '</div>';
			}
			else {
				$return .= '<div class="zcmail_error"> ';
				$return .= __( "No message could be sent. This means that this server wasn't configured to send mail. Please contact the site administrator.", 'zero-conf-mail' );
				$return .= '</div>';
			}
		}
		else {
			$return .= '<div class="zcmail_error">';
			$return .= $option['config']['messages']['failure'];
			$return .= '</div>';
			$return .= zcmail_printform();
		}
	}
	else {
		$return .= zcmail_printform();
	}
	$return .= '</div>';
	return $return;
}

/**
 * Send a mail
 * 
 * @param string $to receiver
 * @param string $from sender, put this in reply-to
 * @param string $subject subject
 * @param string $body email body
 *
 * @return was the message accepted for delivery
 */
function zcmail_sendmail( $to, $from, $subject, $body ) {
	$headers = "Reply-To: $from\r\n";
	$result = wp_mail( $to, $subject, $body, $headers );
	return $result;
}

/**
 * Perform (basic) sanitization of user input.
 *
 * @param $string string to sanitize
 * @return string sanitized string
 */
function zcmail_sanitize( $string ) {
	$string = htmlspecialchars( $string, ENT_NOQUOTES );;
	return $string;
}

/**
 * Validate all parameters
 *
 * @param array $input $_POST data
 * @param array $option plugin options
 * 
 * @return boolean do all fields validate
 *
 * @todo Useful error messages per field
 */
function zcmail_validates( $input, $option ) {
	foreach( $option['fields'] as $field => $value ) {
		// Catch empty or unchanged mandatory fields
		if ( $value['type'] == 'text' || $value['type'] == 'textarea' ) {
			if ( ( $value['must'] === true || $value['must'] === 'true' ) && $input[$field] == $value['label'] ) {
				//echo "error: " . $input[$field] . " unchanged";
				return false;
			}
			elseif ( ( $value['must'] === true || $value['must'] === 'true' ) && $input[$field] == '' ) {
				//echo "error: " . $value['label'] . $input[$field] . " empty";
				return false;
			}
		}
		// Catch invalid email adresses
		if ( $value['type'] == 'email' ) {
			if ( ( $value['must'] === true || $value['must'] === 'true' ) && $value['type'] == 'email' && !is_email( $input[$field] ) ) {
				//echo "error: " . $input[$field] . " no mail";
				return false;
			}
		}
	}
	return true;
}

/**
 * Basic flood protection
 * Spam protection is the mail server's job. I don't need captcha.
 *
 * Ways to trick this flood protection (with default settings):
 * 1. Limit oneself to ten mails per IP per hour. If that creates a problem
 * for anybody they probably shouldn't be looking for a technical solution
 * to their problem.
 *
 * @param $option plugin options
 * @param $ip remote ip
 *
 * @return boolean not flood?
 *
 * @todo add dupe protection.. maybe. would require to save mail content + subject etc
 *
 * @since 0.4.0
 */
function zcmail_floodprotect( $option, $ip ) {
	$maxmails = $option['config']['flood']['maxmails'];
	$minhours = $option['config']['flood']['minhours'];

	// get oldest existing or new timestamp
	isset( $option['log'][$ip][0] ) ?
		$oldest_timestamp = $option['log'][$ip][0] :
		$oldest_timestamp = time();

	$allowed_at = strtotime( "+$minhours hours", $oldest_timestamp );

	if ( isset( $option['log'][$ip] ) ) {
		// This IP has already sent a mail
		if ( count( $option['log'][$ip] ) >= $maxmails ) { 

			// This IP has already sent more mail than allowed
			if ( time() < $allowed_at ) {
				// Inside forbidden timeframe, return
				return false;
			}
		}
	}

	// We are allowed to send, update logs

	$option['log'][$ip][] = time();

	// limit log size per IP
	if ( count( $option['log'][$ip] ) > $maxmails ) {
		array_shift( $option['log'][$ip] );
	}

	// clean up log after updating it
	$option = zcmail_purgelog( $option );
	update_option( 'zcmail', $option );

	return true;
}

/**
 * Clean up log entries, forget IPs that haven't sent within the forbidden time
 *
 * @param $option plugin options
 *
 * @return array plugin options with cleaned up log
 *
 * @since 0.4.0
 */
function zcmail_purgelog( $option ) {
	$minhours = $option['config']['flood']['minhours'];

	foreach ( $option['log'] as $log_ip => $timestamps ) {
		$allowed_at = strtotime( "+$minhours hours", $timestamps[0] );
		if( time() > $allowed_at ) {
			unset( $option['log'][$log_ip] );
		}
	}

	return $option;
}

/**
 * Return the mail form for visitors or on the options page
 *
 * @param boolean $disabled disable the submit button
 */
function zcmail_printform( $disabled = false, $honeypot = true ) {
	$option = get_option( 'zcmail' );
	if( $option['config']['jumpanchor'] == 'Enable' )
		$anchor = "#zcmail";

	$return = "<form action=\"$anchor\" method=\"post\"><fieldset>";
	foreach( $option['fields'] as $field => $values ) {
		if ( !isset( $_POST['zcmail'][$field] ) ) {
			$_POST['zcmail'][$field] = null;
		}
		switch( $values['type'] ) {
			case 'text':
			case 'email':
				$return .= get_zcmail_input( "zcmail[$field]", zcmail_get_value( $values['label'], $_POST['zcmail'][$field] ), zcmail_get_value_bool( $values['label'], $_POST['zcmail'][$field] ) );
				break;
			case 'textarea':
				$return .= get_zcmail_textarea( "zcmail[$field]", zcmail_get_value($values['label'], $_POST['zcmail'][$field] ), zcmail_get_value_bool( $values['label'], $_POST['zcmail'][$field] ) );
				break;
			case 'submit':
				$return .= get_zcmail_submit( $values['label'], $disabled );
				break;
		}
	}
	// insert the honeypot field
	if ( $honeypot )
		$return .= '<input type="text" name="zcmail[honeypot]" value="" style="display:none;" />';

	$return .= '</fieldset></form>';
	if ( $option['config']['homelink'] == 'Below the form' ) {
		$return .= get_zcmail_homelink();
	}
	elseif ( $option['config']['homelink'] == 'In the footer' ) {
		add_action( 'wp_footer', 'zcmail_homelink' );
	}
	return $return;
}



/**
 * Print the value the user submitted earlier, or the default.
 *
 * @param string $default Default value
 * @param string $submitted The value that was submitted earlier
 *
 * @return: string Value to print
 */
function zcmail_get_value( $default, $submitted ) {
	if ( isset( $submitted ) ) {
		return $submitted;
	}
	else {
		return $default;
	}
}

/*
 * Tell us if the value the user submitted earlier was the default value.
 *
 * @param string $default Default value
 * @param string $submitted Submitted value
 * 
 * @return: boolean Was the default used?
 */
function zcmail_get_value_bool( $default, $submitted ) {
	if ( !isset( $submitted ) || $submitted == $default ) {
		return true;
	}
	else {
		return false;
	}
}

/**
 * Build  an input tag
 * 
 * @param string $name input field name
 * @param string $label label for the field
 * @param boolean $js show js, 'true' or 'false'
 * @param string $size size of the input field
 *
 * @return string the input tag
 *
 * @since 0.1.12
 */
function get_zcmail_input( $name, $label, $js = true, $size = 40 ) {
	$return = '<input type="text" size="' . $size . '" name="' . $name . '" value="' . $label . '"';
	if ( $js ) $return .= get_zcmail_jsnippet( $label );
	$return .= ' class="zcmail_text" />';
	return $return;
}

/**
 * See get_zcmail_input()
 *
 * @todo Notice defaults for js + size
 */
function zcmail_input( $name, $label, $js = true, $size = 40 ) {
	echo get_zcmail_input( $name, $label, $js, $size ) . "\n";
}

/**
 * Return a textarea, hardcoded size so far
 *
 * @param string $name textarea name
 * @param string $label label for the textarea
 * @param boolean $js use JS effect
 *
 * @return string the textarea
 *
 * @since 0.1.12
 */
function get_zcmail_textarea( $name, $label, $js ) {
	$return = '<textarea rows="10" cols="50" name="' . $name . '" class="zcmail_textarea" ';
	if ( $js ) $return .= get_zcmail_jsnippet( $label );
	$return .= '>' . $label . "</textarea>\n";
	return $return;
}

/**
 * Display a textarea
 *
 * @param string $name textarea name
 * @param string $label label for the textarea
 * @param boolean $js use JS effect
 */
function zcmail_textarea( $name, $label, $js ) {
	echo get_zcmail_textarea( $name, $label, $js );
}

/**
 * Print a submit putton
 *
 * @param string $label submit button value
 * @param boolean $disabled disable the submit button
 *
 * @since 0.1.12
 */
function get_zcmail_submit( $label, $disabled ) {
	$return = '<input type="submit" id="submit" value="' . $label .'" class="zcmail_submit"';
	if ( $disabled) $return .= ' disabled="disabled" ';
	$return .= " />\n";
	return $return;
}

/**
 * See get_zcmail_submit()
 */
function zcmail_submit( $label, $disabled = false ) {
	echo get_zcmail_submit( $label, $disabled );
}

/**
 * Print a select dropdown
 *
 * @param string $name Form input name
 * @param string $value Current value
 * @param array $choices Possible choices
 */
function zcmail_select( $name, $value, $choices ) { ?>
	<select name="<?php echo $name ?>"><?php
	foreach ( $choices as $choice ) {
		if ( $choice == $value ) { ?>
			<option value="<?php echo $choice ?>" selected><?php echo __( $choice, 'zero-conf-mail' ) ?></option>
		<?php }
		else { ?>
			<option value="<?php echo $choice ?>" ><?php echo __( $choice, 'zero-conf-mail' ) ?></option>
		<?php }
	}
	?>
	</select>
	<?php
}

/**
 * Print a checkbox, checked or unchecked
 * 
 * @param string $name form input name
 * @param string $true checked? 'Enabled' or 'Disabled'... 
 *
 * @todo use consts for Enabled etc....
 * @todo allow users to use this
 */
function zcmail_checkbox( $name, $true ) {
	if ( $true == 'Enabled' ) { ?>
		<input type="checkbox" name="<?php echo $name ?>" value="Enabled" checked />
	<?php }
	else { ?>
		<input type="checkbox" name="<?php echo $name ?>" value="Enabled" />
	<?php }
}

/**
 * Print two radio select buttons for true/false choice
 *
 * @param string $name radio field name
 * @param string $true 'true' or anything else... FIXME

 * @todo use consts for,true Enabled etc. and migrate data
 */
function zcmail_bool( $name, $true ) {
	if ( $true == 'true' ) { ?>
		<input type="radio" name="<?php echo $name ?>" value="true" checked />
		<input type="radio" name="<?php echo $name ?>" value="false" />
	<?php }
	else { ?>
		<input type="radio" name="<?php echo $name ?>" value="true" />
		<input type="radio" name="<?php echo $name ?>" value="false" checked />
	<?php }
}

/**
 * Get the javascript for input fields for the mail form for visitors
 *
 * @param string $param will be deleted or filled in
 *
 * @return string JavaScript
 *
 * @since 0.1.12
 */
function get_zcmail_jsnippet( $param ) {
	/*
	FIXME RTL languages... hebrew po file contains text in wrong order?!? See
	stripslashes as well.
	FIXED (?) Seems because of my incorrect PHP setup for RTL languages.
	*/
	$param = addslashes( $param );
	$return = " onfocus=\"if(this.value=='$param'){this.value=''};\" ";
	$return .= " onblur=\"if(this.value==''){this.value='$param'}\" ";
	return $return;
}

/**
 * print get_zcmail_jsnippet()
 *
 * @param $param input field value
 */
function zcmail_jsnippet( $param ) {
	echo get_zcmail_jsnippet( $param );
}

/**
 * Return the link to the plugin site.
 */
function get_zcmail_homelink() {
	$url = __( 'http://www.nkuttler.de/wordpress/zero-conf-mail', 'zero-conf-mail' );
	$return = '<span class="zcmail_home">';
	$return .= sprintf ( __( "<a href=\"%s\">Mail form</a> powered by <a href=\"%s\">Zero Conf Mail</a>", 'zero-conf-mail'), $url, $url );
	$return .= '</span>';
	return $return;
}

/**
 * Print the link to the plugin site.
 */
function zcmail_homelink() {
	echo get_zcmail_homelink();
}

/**
 * Include standard CSS if shortcode exists
 *
 * @since 0.3.1
 */
function zcmail_include_css() {
	// Check if shortcode exists in page or post content
	global $post;
	if ( strstr( $post->post_content, '[zcmail]' ) ) { ?>
		<link rel="stylesheet" href="<?php echo get_bloginfo( 'home' ) . '/' .  PLUGINDIR . '/zero-conf-mail/css/zcmail.css?v=0.3.1' ?>" type="text/css" media="all" /> <?php
	}
}
