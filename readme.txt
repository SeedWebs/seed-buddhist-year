=== Seed Buddhist Year ===
Contributors: seedwebs
Tags: Buddhist, date, time, year
Requires at least: 4.0.1
Tested up to: 6.6
Stable tag: 1.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Change output year to Buddhist year or Buddhist Era (BE).

== Description ==

Seed Buddhist Year will change output year to Buddhist year or Buddhist Era (BE) but not effect microformat, which uses Christian/Common Era (CE).

Just install and it will overide these functions,

* get_the_date()
* the_date()
* get_the_time()
* the_time()

Then, this plugin will not work if your theme user other standard ways to output the date and time.

Official development of Seed Buddhist Year is on GitHub, with official stable releases published on WordPress.org. The GitHub repo can be found at https://github.com/SeedThemes/seed-buddhist-year/. Please use the Support tab for potential bugs, issues, or enhancement ideas.


== Installation ==


1. Upload the plugin files to the `/wp-content/plugins/seed-buddhist-year` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress

There is no settings.


== Frequently Asked Questions ==

= It's not working? =

This plugin will not work if your theme user other standard ways to output the date and time. Now we support just 4 functions,

* get_the_date()
* the_date()
* get_the_time()
* the_time()

And we found that it's not working on 32 Bit CPU. Please check that your hosting server is 64 Bit CPU. 

== Screenshots ==

1. Thai date using Buddhist year.


== Changelog ==

= 1.0.4 =
* Date: 23 FEB 2023
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