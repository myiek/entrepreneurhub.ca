=== Livefyre Realtime Comments ===
Contributors: Livefyre
Donate link: http://livefyre.com/
Tags: comments, widget, plugin, community, social, profile, moderation 
Requires at least: 2.8
Tested up to: 3.02
Stable tag: 3.04

Livefyre is an embeddable real-time comment system that increases the quality and quantity of your comments and drives traffic to your site.

== Description ==

Livefyre is an embeddable real-time commenting platform that turns comments on any site into live conversations, increases the quality of those conversations, and drives traffic to content around the web.

Here are some key features:

*   Built on chat technology so all comments, likes, and moderation happen in real-time
*   New comment indicators inform you when new posts have happened above or below you
*   Universal reputation for users across the Livefyre network
*   Share comments and conversations on Facebook and Twitter

For more info check out [Livefyre's full feature list](http://livefyre.com/features).

== Installation ==

First, make sure you registered your site on Livefyre after receiving your private beta code. Haven't signed up for the private beta? Go to [http://www.livefyre.com](http://www.livefyre.com) and enter your information.

Once your blog checks out:

1. Install this plugin (Livefyre Realtime Comments) in your WordPress Admin.
2. Activate the plugin through the 'Plugins' menu in WordPress

You're done! Livefyre will send you an e-mail when the installation is complete. 

== Frequently Asked Questions ==

Visit the [Livefyre FAQ](http://livefyre.assistly.com) or e-mail us at support@livefyre.com.

== Changelog ==
= 3.04 =
* Handling quotes better for postback, as using the correct "init" hook causes wordpress to unilaterally escape all quotes in $_POST.  This fixes broken postback in a number of cases.
= 3.03 =
* Moving postback hook into the more appropriate "init" wp hook for better performance
= 3.02 =
* Fixing syntax that was incompatible with php 4.x.
= 3.01 =
* New platform release with updated postback synchronization.
= 2.41 =
* Fixed bug where livefyre css loads on every page (which made pingdom claim that every image in the css, whether loaded or not, was being fetched on page load.  LIES!)
= 2.40 =
* Fixed bug related to load order changes in the Livefyre streaming library.
= 2.39 =
* Fixed bug on upgrade to 3.0.3 that caused a permission error on activation (or re-activation) of Livefyre.
= 2.38 =
* Corrected use of 'siteurl' to 'home' instead when obtaining the site's base url for web service endpoints in the plugin.
= 2.37 =
* Added 'copy my comments' button for those who decide to import or who need to sync comments.  Unfortunately until our 'full sync' solution is complete, the button is kind of dumb and is there all the time.  It can't hurt tho - we'll never duplicate a comment thats already in the livefyre system.
* Added automated test for wp_head() template hook, to proactively notify users of compatibility issues.
= 2.36 =
* Improved the automated wordpress importer - it now limits the maximum number of queries to run for one chunk of xml (20) in addition to limiting the number of characters that are allowed in one chunk.
* Improved the automated wordpress importer - using local dates where GMT is unavailable on very old articles, presumably from versions of WP that didn't track gmt.
* Added a 'copy my comments' button to the options page for users who opted out of automatic import on the initial registration step.
= 2.33 =
* Added automatic comment sync for users who deactivate, then collect more comments in the wp db, then re-activate Livefyre.
= 2.31 =
* Securing the export process with a signature.
= 2.27 =
* Changes to ignore bogus/zero import dates.
= 2.26 =
* Adding phone-home on activation/deactivation of plugin, we now store the status on a Livefyre server for debugging purposes.
* Adding large blog import support - we now use chunk files with a central index delivered to Livefyre.com instead of one giant XML file of arbitrary length (regularly growing to the point of exhausting RAM).
* Making the livefyre interface behave correctly on pages (eg 'About') as well as posts.
* Not showing the livefyre interface on preview mode - this was breaking the title grabber.
* Only showing approved pingbacks/trackbacks.
= 2.25 =
* Excluding pingback and trackback data from comment data import. Removed unnecessary extra call to Livefyre server on successful authentication on the plugin options page.
= 2.24 =
* Added cache reset calls to reset wp-cache and WP Super Cache plugins
= 2.22 =
* Shows trackbacks
= 2.20 =
* Copies comments to WordPress database.