=== This Day in History - Hiztory ===

Contributors: beliefmedia
Donate link: http://www.internoetics.com/
Tags: this day in history, today in history, history, hiztory, events, births, deaths, aviation, aircraft, aerospace, shortcode
Requires at least: 3.1
Tested up to: 4.4
Stable tag: 0.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generate 'This Day in History' by way of shortcode. Includes a generator for creating appropriate shortcode.

== Description ==

**Hiztory** is a highly configurable but simple plugin that generates shortcode that'll permit you to display 'this day in history' information on a WordPress page, post or sidebar. 

Features include:

* Generator shortcode (via the admin control panel) with the appropriate options that you can cut and paste into your post, page or widget.
* Option to update WP to enable shortcode in widgets.
* We currently provide birth, death, event and aviation history. More modules to come.
* Numerous shortcode options (list, random, date, formatting ect).
* Convert words in text that match your WordPress post tags to (tag archive) links. The feature connects the content of the "This Day in History" text to other areas of your website.

Hiztory will be built upon the needs of those that need it. The initial purpose of the plugin was to provide 'This Day in Aviation History' for the [Flight.org](http://www.flight.org/ "Flight") website and readers since no other tool was available for such information.

At the moment, we permit up to a maximum of 15 results to be rendered on your website in one query. The Hiztory API applies rate limiting so results are cached locally (using the WordPress transient API) for one hour. Each new request generates new and (optionally) random results.

Related links:

* [Usage](http://www.beliefmedia.com/wp-plugins/hiztory.php)
* [Flight](http://www.flight.org/blog/)
* [Internoetics](http://www.internoetics.com/)

== Installation ==

**To install the plugin manually:**

1. Extract the contents of the archive (zip file)
2. Upload the hiztory folder to your '/wp-content/plugins' folder
3. Activate the plugin through the Plugins section in your WordPress admin panel.

**Upload via the WordPress administration panel:**

1. Click on "Plugins" in the left panel, then click on "Add new".
2. You should now see the Install Plugins page. Click on "Upload".
3. Click on Browse and select your "hiztory.zip" file.
4. Click on "Install now", activate it and you're done!

== Screenshots ==

1. Shortcode Generator.
2. Example history rendered on the Twenty Thirteen theme (as a post/page).
3. Three random historical aviation events in a widget.

== Changelog ==

= 0.1.4 =
* Correct error if tags empty. Other minor corrections. Next release will be a full rewrite.

= 0.1.3 =
* Added an optional feature that will convert words in history text matching your WordPress tags to links (to tag archives). This feature closely connects your history text to your WordPress content.

= 0.1.2 =
* Corrected an issue with incorrect date formatting.

= 0.1 =
* Initial Release. Basic (proof of concept) plugin only.

== Upgrade Notice ==
= 0.1.4 =
* Correct error if tags empty. Other minor corrections.

= 0.1.3 =
* New feature: Convert words in history text matching your WordPress tags to (tag archive) links.

= 0.1.2 =
* Corrected an issue with incorrect date formatting.

= 0.1 =
* Initial Release. Basic (proof of concept) plugin only.

== Frequently Asked Questions ==

**What will the plugin do?**

The hiztory plugin will retrieve data from the Hiztory API relating to - at this stage - births, deaths, events or aviation and display the data anywhere on your website.

**I can't see shortcode in my WordPress sidebar. What should I do?**

There's an option in the plugin to activate/deactivate the filter that'll enable you to use shortcodes in your sidebar.

**Why is there a limit on 15 items via the plugin?**

We'll increase the limit in the very near future that'll allow you to access unlimited events for a particular day. The limit is just a temporary measure while we test the load of the API.

**What are the plans for the future?**

We plan on developing a huge number of options. They include:

* A removal of the 15 results limit.
* The API will shortly permit multiple events from multiple user defined categories.
* We'll enable you to display events based on a particular timeframe (i.e. 1 year ago, 5 years ago etc.)
* Geo-specific history queries.
* Additional categories (tech, marine, country specific etc.)

**Where can I go for more information?**

View the complete FAQs and other Hiztory information [here](http://www.beliefmedia.com/wp-plugins/hiztory.php). 