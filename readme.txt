=== Seed Buddhist Year ===
Contributors: seedwebs
Tags: Buddhist, date, time, year
Requires at least: 4.9
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Change output year to Buddhist year or Buddhist Era (BE).

== Description ==

Seed Buddhist Year shows the year in the Buddhist Era (BE = CE + 543) where WordPress shows post and comment dates to readers. Dates that code reads, such as feeds and `datetime` attributes, stay in the Common Era (CE).

Just install and activate. The year changes to BE in:

* Post dates and times from get_the_date(), the_date(), get_the_time() and the_time()
* Comment dates from get_comment_date() and comment_date()
* The Post Date block, including on WordPress 6.9 and later
* Places that use these functions, such as archive titles, the Latest Posts and Comment Date blocks, and most date columns in the admin lists

These stay in CE on purpose, so feed readers, search engines and other code get the real date:

* Post and comment feeds (RSS2, Atom)
* Dates in the 'c', 'r' and 'U' formats and in the PHP constants DATE_ATOM, DATE_COOKIE, DATE_ISO8601, DATE_RFC822, DATE_RFC850, DATE_RFC1036, DATE_RFC1123, DATE_RFC2822, DATE_RFC3339, DATE_RSS and DATE_W3C, which WordPress and most themes use for `datetime` attributes
* The publish date when you schedule changes in the Customizer

These are not changed:

* Modified ("last updated") dates
* The Latest Comments block, the Archives widget or block, and the Calendar widget or block
* The Activity box on the Dashboard
* Dates in the block editor
* Dates that a theme or plugin prints with date_i18n(), wp_date() or PHP date(), such as WooCommerce order dates

Official development of Seed Buddhist Year is on GitHub, with official stable releases published on WordPress.org. The GitHub repo can be found at https://github.com/SeedWebs/seed-buddhist-year. Please use the Support tab for potential bugs, issues, or enhancement ideas.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/seed-buddhist-year` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.

There are no settings.

== Frequently Asked Questions ==

= Some dates on my site still show the CE year. Why? =

The plugin only changes dates that come from the functions and blocks listed in the Description. Dates that your theme or another plugin prints in other ways stay in CE.

= My code needs the CE year. What should I use? =

Ask for the 'c' or 'U' format, or DATE_W3C, for example get_the_date( DATE_W3C ). These always return the CE year. Other formats that include the year, such as 'Y-m-d' or the newer PHP constants DATE_RFC3339_EXTENDED and DATE_RFC7231, get the BE year.

= I added my own code to show the BE year in the Post Date block. Do I still need it? =

No. Version 1.0.5 changes the block itself, and leaves the date alone when other code has already changed it, so you can remove your code.

= Why do comment times show seconds? =

The plugin shows comment times as 24-hour time with seconds (for example 21:05:00), whatever the Time Format in Settings > General is.

= Does it work on a 32-bit server? =

No. Adding 543 years needs 64-bit PHP. Please check that your hosting server runs 64-bit PHP.

== Screenshots ==

1. Thai date using Buddhist year.

== Changelog ==

= 1.0.5 =
* Fix: The Post Date block shows the BE year again on WordPress 6.9 and later.
* Fix: Comment feeds (RSS2, Atom) show the real comment date. Before, every comment was dated today.
* Fix: Comment `datetime` attributes and get_comment_time( 'U' ) return the real value.
* Fix: get_comment_time() with a format that includes the year shows the BE year. Before, it always showed the time.
* Fix: Saving a scheduled change in the Customizer no longer moves its publish date 543 years ahead. If you scheduled Customizer changes before this update, open the Customizer and check the publish date.
* Fix: On WordPress 6.3 to 6.8, the Post Date block set to the modified date no longer disappears.
* Fix: get_comment_date() keeps the CE year for DATE_* formats, like post dates do.
* Fix: Date formats with an escaped y (\y or \Y) work.
* Fix: No PHP warnings when other code runs the date filters without a post.
* Hardening: Block direct access to the plugin file.
* Removed: The internal helper function fix_seed_buddhist_year_comment_time().
* Requires WordPress 4.9 and PHP 7.4. Tested up to WordPress 7.1.

= 1.0.4 =
* Date: 15 MAY 2024
* Fix: $gmt variable

= 1.0.3 =
* Date: 5 MAR 2021
* Fix: undefined variable: comment

= 1.0.2 =
* Fix: Predefined Constants problem (to support Yoast SEO).

= 1.0.1 =
* New: Support comment date.

= 1.0.0 =
* Date: 2016-05-11
* Fix: leap year problem.

= 0.9.0 =
* First version.

== Upgrade Notice ==

= 1.0.5 =
Shows the Buddhist year in the Post Date block on WordPress 6.9+ again and fixes comment feed dates. If you scheduled Customizer changes before this update, check their publish date.
