<?php
/*
Plugin Name: Seed Buddhist Year
Plugin URI: https://github.com/seedwebs/seed-buddhist-year
Description: A plugin for setting the year to the buddhist year
Version: 1.0.5
Requires at least: 4.9
Requires PHP: 7.4
Author: Seed Webs
Author URI: https://www.seedwebs.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Copyright 2016-2026 Seed Webs Co., Ltd.  (email : info@seedwebs.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('ABSPATH')) {
    exit;
}

if(!class_exists('Seed_Buddhist_Year')) {
    class Seed_Buddhist_Year
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
        }

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        }
    }
}

if(class_exists('Seed_Buddhist_Year')) {
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Seed_Buddhist_Year', 'activate'));
    register_deactivation_hook(__FILE__, array('Seed_Buddhist_Year', 'deactivate'));

    // instantiate the plugin class
    $Seed_Buddhist_Year = new Seed_Buddhist_Year();
}

function seed_is_return_buddhist($format)
{
    $return = false;

    if ((false !== ($offset = stripos($format, 'y')))
            && strcmp($format, DATE_ATOM)
            && strcmp($format, DATE_COOKIE)
            && strcmp($format, DATE_ISO8601)
            && strcmp($format, DATE_RFC822)
            && strcmp($format, DATE_RFC850)
            && strcmp($format, DATE_RFC1036)
            && strcmp($format, DATE_RFC1123)
            && strcmp($format, DATE_RFC2822)
            && strcmp($format, DATE_RFC3339)
            && strcmp($format, DATE_RSS)
            && strcmp($format, DATE_W3C)
            // WordPress 6.3-6.8: the Post Date block compares get_the_modified_date( 'Ymdhi' ) with get_the_date( 'Ymdhi' ).
            && strcmp($format, 'Ymdhi')
    ) {
        $return = true;
    }

    return $return;
}

add_filter('get_the_date', 'seed_buddhist_year_get_the_date', 10, 3);
add_filter('the_date', 'seed_buddhist_year_the_date', 10, 4);
add_filter('get_the_time', 'seed_buddhist_year_get_the_time', 10, 3);
add_filter('the_time', 'seed_buddhist_year_the_time', 10, 2);

add_filter('get_comment_date', 'seed_buddhist_year_get_comment_date', 10, 3);
add_filter('get_comment_time', 'seed_buddhist_year_get_comment_time', 10, 5);

function seed_buddhist_year_get_comment_date($date, $format = '', $comment = null)
{
    if (!is_object($comment)) {
        return $date;
    }

    if ($format == '') {
        $format = get_option('date_format');
    }

    // No year, a DATE_* constant or 'Ymdhi': a value for code, keep the CE date from WordPress.
    if (!seed_is_return_buddhist($format)) {
        return $date;
    }

    return seed_buddhist_year($format, strtotime($comment->comment_date));
}

function seed_buddhist_year_get_comment_time($time, $format = '', $gmt = false, $translate = true, $comment = null)
{
    // Comment feeds call get_comment_time( 'Y-m-d H:i:s', true, false ): keep the real date from WordPress.
    if ($gmt || !$translate || !is_object($comment)) {
        return $time;
    }

    if ($format != '') {
        // Has a year character (y, Y) that is not escaped with a backslash.
        $has_year = false !== stripos(preg_replace('/\\\\./s', '', (string) $format), 'y');

        if ($has_year && seed_is_return_buddhist($format)) {
            return seed_buddhist_year($format, strtotime($comment->comment_date));
        }

        // 'c', 'r', 'U', 'G' and DATE_* are values for code: keep them as WordPress made them.
        if ($has_year || in_array($format, array('c', 'r', 'U', 'G'), true)) {
            return $time;
        }
    }

    // Comment time for readers: 24-hour time with seconds, as in 1.0.4.
    return mysql2date('H:i:s', $comment->comment_date, false);
}

function seed_buddhist_year_get_the_date($content = '', $format = '', $post_input = null)
{
    $post_obj = get_post($post_input);

    // No post (for example other code calling apply_filters() itself): keep the value we got.
    if (!$post_obj) {
        return $content;
    }

    $the_date = strtotime($post_obj->post_date);

    if($format == '') {
        $format = get_option('date_format');
    }

    if(seed_is_return_buddhist($format)) {
        $return = seed_buddhist_year($format, $the_date);
    } else {
        $return = $content;
    }

    return $return;
}

function seed_buddhist_year_the_date($content = '', $format = '', $before = '', $after = '')
{
    return $before.get_the_date($format).$after;
}

function seed_buddhist_year_get_the_time($content = '', $format = '', $post_input = null)
{
    $post_obj = get_post($post_input);

    // No post (for example other code calling apply_filters() itself): keep the value we got.
    if (!$post_obj) {
        return $content;
    }

    $the_date = strtotime($post_obj->post_date);

    if($format == '') {
        $format = get_option('time_format');
    }

    if(seed_is_return_buddhist($format)) {
        $return = seed_buddhist_year($format, $the_date);
    } else {
        $return = $content;
    }

    return $return;
}

function seed_buddhist_year_the_time($content = '', $format = '')
{
    return get_the_time($format);
}

function seed_buddhist_year($format = '', $time = null)
{
    $return = '';

    if($format == '') {
        $format = get_option('date_format');
    }

    if($time === null) {
        $time = time();
    }

    // 1.0.4 read the format with stripos()/substr(), which also accept non-string values.
    $format = (string) $format;

    // Positions of the year characters (y, Y) that are not escaped with a backslash.
    $years = array();
    $length = strlen($format);

    for ($i = 0; $i < $length; $i++) {
        if ('\\' === $format[$i]) {
            $i++; // The next character is printed as it is.
        } elseif ('y' === $format[$i] || 'Y' === $format[$i]) {
            $years[] = $i;
        }
    }

    if($years) {
        $index = 0;

        foreach($years as $offset) {
            $_sub_format = substr($format, $index, $offset - $index);

            if($_sub_format != '') {
                if(trim($_sub_format) == '') {
                    $return .= $_sub_format;
                } else {
                    $return .= date_i18n($_sub_format, $time);
                }
            }

            $year_format = substr($format, $offset, 1);
            $return .= date_i18n($year_format, strtotime("543 years", $time));

            $index = $offset + 1;
        }

        $_sub_format = substr($format, $index);

        if($_sub_format != '') {
            if(trim($_sub_format) == '') {
                $return .= $_sub_format;
            } else {
                $return .= date_i18n($_sub_format, $time);
            }
        }
    } else {
        $return = date_i18n($format, $time);
    }

    return $return;
}

// WordPress 6.9+ prints the Post Date block with wp_date() instead of get_the_date().
// Priority 99: run after other code that changes this block (see the check on the text below).
add_filter('render_block_core/post-date', 'seed_buddhist_year_render_post_date', 99, 2);

function seed_buddhist_year_render_post_date($block_content, $block = array())
{
    if (!is_string($block_content) || !is_array($block)) {
        return $block_content;
    }

    $attrs = (isset($block['attrs']) && is_array($block['attrs'])) ? $block['attrs'] : array();

    // Which date a Block Bindings source gives the block. Older Gutenberg builds called the
    // argument "key", and WordPress still reads it when "field" is empty.
    $binding = (isset($attrs['metadata']['bindings']['datetime']) && is_array($attrs['metadata']['bindings']['datetime']))
        ? $attrs['metadata']['bindings']['datetime'] : array();
    $binding_args = (isset($binding['args']) && is_array($binding['args'])) ? $binding['args'] : array();
    $field = '';

    if (!empty($binding_args['field'])) {
        $field = $binding_args['field'];
    } elseif (!empty($binding_args['key']) && isset($binding['source']) && 'core/post-data' === $binding['source']) {
        $field = $binding_args['key'];
    }

    // Modified dates are not changed (as in 1.0.4).
    if ((isset($attrs['displayType']) && 'modified' === $attrs['displayType']) || 'modified' === $field) {
        return $block_content;
    }

    // Like WordPress, ignore a format that is not a string.
    $format = (!empty($attrs['format']) && is_string($attrs['format'])) ? $attrs['format'] : get_option('date_format');

    if ('human-diff' === $format || !seed_is_return_buddhist($format)) {
        return $block_content;
    }

    // WordPress 6.9 puts the link inside <time>, WordPress 7.0+ puts <time> inside the link.
    if (!preg_match('#<time datetime="([^"]+)">(<a [^>]*>)?([^<]*)(</a>)?</time>#', $block_content, $m)) {
        return $block_content;
    }

    $timestamp = strtotime($m[1]);

    if (false === $timestamp) {
        return $block_content;
    }

    // The same moment as a site-local 'Y-m-d H:i:s' string.
    $local_mysql = get_date_from_gmt(gmdate('Y-m-d H:i:s', $timestamp));

    // Change the text only while it is the CE date WordPress printed (mysql2date() makes the same
    // wp_date() call as the block on WordPress 5.3+). On WordPress 5.7-6.8 the get_the_date filter
    // has already given the BE year, and other code may have changed the text.
    if ($m[3] !== esc_html(mysql2date($format, $local_mysql))) {
        return $block_content;
    }

    // Site-local time as a timestamp, like strtotime( $post->post_date ), whatever PHP's default timezone is.
    $local = strtotime($local_mysql . ' +0000');

    $link_open = $m[2];
    $link_close = isset($m[4]) ? $m[4] : '';
    $time_tag = '<time datetime="' . $m[1] . '">' . $link_open . esc_html(seed_buddhist_year($format, $local)) . $link_close . '</time>';

    return str_replace($m[0], $time_tag, $block_content);
}

// Customizer: WordPress reads the scheduled publish date with get_the_time( 'Y-m-d H:i:s' ) and sends
// it back when the changes are saved, so it has to stay in CE on the Customizer screen.
add_action('customize_controls_init', 'seed_buddhist_year_customize_controls_init');

function seed_buddhist_year_customize_controls_init()
{
    remove_filter('get_the_time', 'seed_buddhist_year_get_the_time', 10);
}
