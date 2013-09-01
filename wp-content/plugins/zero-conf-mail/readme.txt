=== Zero Conf Mail===
Contributors: nkuttler
Author URI: http://www.nkuttler.de/
Plugin URI: http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/
Donate link: http://www.nkuttler.de/wordpress/donations/
Tags: admin, plugin, mail, mail form, contact, contact form, zero configuration, simple, easy
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 0.6.1.1

Simple mail contact form, the way I like it. No ajax, no bloat. No configuration necessary, but possible.

== Description ==
It took me quite some time to check a few existing contact forms and I didn't like any of them. No, I don't want you to load jquery on every page of my blog. I want it localized, pretty please. Oh, and I want this JavaScript onfocus/onblur effect I [wrote about](http://www.nkuttler.de/2008/09/20/html-forms-and-onclickonfocus/). And why do I have to do any configuration at all anyway?

Since 0.6.0 the plugin has a built-in spam protection that won't bother your human visitors but will most likely catch all spambots.

= Usage =

The easiest way to use this plugin is to use the shortcode [zcmail]. There's also a widget that you can drag into one of your sidebars.

= Using the mail form in your theme =
You can call the function `zcmail_shortcode()` from your theme to get the same output as from the shortcode. Example:

<code>
if ( function_exists( 'zcmail_shortcode' ) ) {
	echo zcmail_shortcode()
}
</code>

= Support =
Visit the [plugin's home page](http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/) to leave comments, ask questions, etc.

= Other plugins I wrote =

 * [Better Lorem Ipsum Generator](http://www.nkuttler.de/wordpress-plugin/wordpress-lorem-ipsum-generator-plugin/)
 * [Custom Avatars For Comments](http://www.nkuttler.de/wordpress-plugin/custom-avatars-for-comments/)
 * [Better Tag Cloud](http://www.nkuttler.de/wordpress-plugin/a-better-tag-cloud-widget/)
 * [Theme Switch](http://www.nkuttler.de/wordpress-plugin/theme-switch-and-preview-plugin/)
 * [MU fast backend switch](http://www.nkuttler.de/wordpress-plugin/wpmu-switch-backend/)
 * [Visitor Movies for WordPress](http://www.nkuttler.de/wordpress-plugin/record-movies-of-visitors/)
 * [Zero Conf Mail](http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/)
 * [Move WordPress Comments](http://www.nkuttler.de/wordpress-plugin/nkmovecomments/)
 * [Delete Pending Comments](http://www.nkuttler.de/wordpress-plugin/delete-pending-comments)
 * [Snow and more](http://www.nkuttler.de/wordpress-plugin/nksnow/)

== Installation ==
Unzip, upload to your plugin directory, enable the plugin. Add the widget in your dashboard's Design section and configure it as you like.  Then add the shortcode <tt>[zcmail]</tt> on some page or post and you're done.


== Screenshots ==
1. The config options.
2. The tag cloud with some CSS. Live demo at the [plugin's page](http://www.nkuttler.de/nktagcloud/) on [my blog](http://www.nkuttler.de/).

== Frequently Asked Questions ==
Q: How do I remove the link to the plugin homepage?<br />
A: Please read the settings page, you can disable it there.


== Installation ==
Unzip, upload to your plugin directory, enable the plugin. Include it on a page or post by adding the shortcode <tt>[zcmail]</tt> somewhere on it.

== Screenshots ==
1. The contact form with default CSS styles. See the [demo page](http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/) for the minimal onfocus JavaScript effect.

== Frequently Asked Questions ==
Q: What about spam?<br />
A: Webspammers don't gain anything by spamming you through the contact form, as their links don't appear on your site. A spammer is wasting his resources by sending spammy backlinks through the form and should stop soon. Normal spam should be handled by your email provider.<br />
<strong>Update</strong>: Since 0.6.0 there is a simple but hopefully very effective trap for automated spambots.

Q: Anybody can send me a gazillion mails through your plugin!?<br />
A: That's true. That's why the plugin comes with a flood protection. Sender IPs are logged and an attacker would need a considerable amount of resources to bypass that protection. You can make the flood protection rules more severe if you want to.

Q: Who receives the mails?<br />
A: The admin who activated the plugin is a registered user of your blog and has an email address associated with his account. That's where the plugin sends the mails to. This can be changed on the plugin options page.

== Changelog ==
= 0.6.1.1 ( 2010-12-14 ) =
 * Add bulgrian translation, thanks [Veselin]!
 * Update docs
= 0.6.1 ( 2010-05-28 ) =
 * Make jump to form anchor an option, and disable it by default. Thanks Marcelo!
 * Update docs
= 0.6.0 ( 2010-05-06 ) =
 * Add a simple protection against spambots.
= 0.5.1.2 ( 2010-05-02 ) =
 * Add a fieldset to the form to produce valid html.
 * Update italian translation.
= 0.5.1.1 ( 2010-05-01 ) =
 * Add anchor to action URI to jump to the form automtically.
= 0.5.0.3 ( 2010-02-10 ) =
 * Add russian translation, thanks [Carik](http://www.shoptec.ru/?p=2355)!
 * Add dutch translation, thanks Matthijs!
= 0.5.0.2 =
 * Install problem hotfix.
= 0.5.0.1 =
 * Doc fixes.
 * Update italian translation.
= 0.5.0 =
 * Add a widget as requested by [Paul](http://www.dworniak.pl/) and others.
 * Add page and sender info to the mail footer.
= 0.4.2 =
 * Use a WordPress function to send mails. This should fix potential problems with inconsistent From: addresses. Thanks a lot to [MG Lim](http://mirageglobe.com/) for [reporting](http://www.nkuttler.de/wordpress-plugin/zero-conf-mail/#comment-3364) this.
= 0.4.1.2 =
 * Use correct version number.
= 0.4.1.1 =
 * Fix activation bug, thanks to <a href="http://trianglehomesuccess.com/">Robert Reilly</a> for reporting.
= 0.4.1 =
 * Load translations on plugin activation, needed for properly translated field labels.
 * Fix annoying bug, thanks to simon for the detailed report.
 * Bugfixes, optimizations, documention updates.
 * Add delete field option.
= 0.4.0 =
 * Add mail flood protection.
 * Add turkish translation, thanks to Tayfun Duran.
= 0.3.3 =
 * Add icon by <a href="http://www.famfamfam.com">famfamfam</a> to the <a href="http://planetozh.com/blog/my-projects/wordpress-admin-menu-drop-down-css/">Admin Drop Down Menu</a>.
 * Modify directory structure.
 * Fix PHP5ism, thanks to Tico. Now tested on PHP4 as well.
= 0.3.2 =
 * Add hebrew translation, thanks to <a href="http://wordpress.freeall.org/?p=86">Asaf Chetkoff</a>!
 * Include CSS only on pages that contain the shortcode!
= 0.3.1 =
 * This plugin should work by default on as many blogs as possible. Therefore I added a default CSS file that will be included on the form page if you upgrade to this version. Your CSS configuration will be preserved across future upgrades.
= 0.3.0 =
 * Simplified and clarified the interface. After all it's called zero conf for a reason.
 * Add italian translation, thanks to <a href="http://gidibao.net/">Gianni</a>!
 * Fix shortcode position on pages
= 0.1.11 =
 * Clean up code, add documentation
 * Admin CSS
 * Update german translation
= 0.1.9 =
 * Don't use trunk as stable, revert to earlier release and add bugfixes.
= 0.1.8 =
 * Fix short PHP open tags, thanks to <a href="http://speedforce.org/">Kelson</a> for finding them!
= 0.1.7 =
 * Add email check for receiver to catch misconfigurations.
= 0.1.6 =
 * Include sender's name in mail and fix I18N, thanks to <a href="http://www.busseedv.de">Busse EDV</a> for reporting.
 * Success/failure messages are configurable.
 * Produce valid HTML
= 0.1.5 =
 * Fix upgrade data loss bug.
= 0.1.4 =
 * Hopefully fix PHP5ism in array sorting.
= 0.1.3 =
 * I've seen reports of upgrade troubles. Put the reset button where it can always be accessed. This will be hidden when things get more stable.
 * Split main file and only include the things that are needed.
= 0.1.1 =
 * Allow custom fields
 * Restructure the code, document it
 * New, flexible data structure
 * Enable custom fields as requested
 * I18N, german translation
 * Check if sender's mail is an email address
 * Check admin page & form permissions
 * Add configurable link to plugin website
= 0.0.3 =
 * Add success and failure messages
 * All fields are mandatory.
= 0.0.2 =
 * i18n mostly done
 * Added german translation
= 0.0.1 =
 * Initial release
