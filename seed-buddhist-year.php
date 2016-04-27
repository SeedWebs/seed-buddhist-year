<?php
/*
Plugin Name: Seed Buddhist Year
Plugin URI: https://github.com/SeedThemes/seed-buddhist-year
Description: A plugin for setting the year to the buddhist year
Version: 0.9.0
Author: Seed Themes
Author URI: http://www.seedthemes.com
License: GPL2
*/

/*
Copyright 2016 SeedThemes  (email : info@seedthemes.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Seed_Buddhist_Year'))
{
    class Seed_Buddhist_Year
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
            // register actions
        } // END public function __construct
    
        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        } // END public static function activate
    
        /**
         * Deactivate the plugin
         */     
        public static function deactivate()
        {
            // Do nothing
        } // END public static function deactivate
    } // END class Seed_Buddhist_Year
} // END if(!class_exists('Seed_Buddhist_Year'))

if(class_exists('Seed_Buddhist_Year'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Seed_Buddhist_Year', 'activate'));
    register_deactivation_hook(__FILE__, array('Seed_Buddhist_Year', 'deactivate'));

    // instantiate the plugin class
    $Seed_Buddhist_Year = new Seed_Buddhist_Year();
}

	add_filter( 'get_the_date', 'seed_buddhist_year_get_the_date', 10, 3 );
	add_filter( 'the_date', 'seed_buddhist_year_the_date', 10, 4 );
	add_filter( 'get_the_time', 'seed_buddhist_year_get_the_time', 10, 3 );
	add_filter( 'the_time', 'seed_buddhist_year_the_time', 10, 2 );

	function seed_buddhist_year_get_the_date($content = '', $format = '', $post_input = null) {
		global $post;

		$the_date = null;

		if ( is_int( $post_input ) ) {
			$post_id = $post_input;
			$the_date = get_post( $post_id )->post_date;
		} elseif( $post_input !== null ) {
			$post_id = $post_input->ID;
			$the_date = $post_input->post_date;
		} else {
			$post_id = $post->ID;
			$the_date = $post->post_date;
		}

		if( $format == '' ) {
			$format = get_option( 'date_format' );
		}

		if( ( $format != 'c' ) && ( $format != 'r' )  && ( $format != 'U' )) {
			$buddhist_time = strtotime( "543 years", strtotime( $the_date ) ); 
		} else {
			$buddhist_time = strtotime( $the_date ) ;
		}

		return date_i18n($format, $buddhist_time);
	}

	function seed_buddhist_year_the_date($content = '', $format = '', $before = '', $after = '') {
		return $before.get_the_date( $format ).$after;
	}

	function seed_buddhist_year_get_the_time($content = '', $format = '', $post_input = null) {
		global $post;

		$the_date = null;

		if ( is_int( $post_input ) ) {
			$post_id = $post_input;
			$the_date = get_post( $post_id )->post_date;
		} elseif( $post_input !== null ) {
			$post_id = $post_input->ID;
			$the_date = $post_input->post_date;
		} else {
			$post_id = $post->ID;
			$the_date = $post->post_date;
		}

		if( $format == '' ) {
			$format = get_option( 'time_format' );
		}

		if( ( $format != 'c' ) && ( $format != 'r' )  && ( $format != 'U' )) {
			$buddhist_time = strtotime( "543 years", strtotime( $the_date ) ); 
		} else {
			$buddhist_time = strtotime( $the_date ) ;
		}

		return date_i18n($format, $buddhist_time);
	}

	function seed_buddhist_year_the_time($content = '', $format = '') {
		return get_the_time( $format );
	}
