<?php
/*
Plugin Name: Seed Buddhist Year
Plugin URI: https://github.com/SeedThemes/seed-buddhist-year
Description: A plugin for setting the year to the buddhist year
Version: 1.0.2
Author: SeedThemes
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

	function seed_is_return_buddhist( $format ) {
		$return = false;

		if ( 	( FALSE !== ( $offset = stripos( $format , 'y' ) ) )
				&& strcmp( $format, DATE_ATOM )
				&& strcmp( $format, DATE_COOKIE )
				&& strcmp( $format, DATE_ISO8601 )
				&& strcmp( $format, DATE_RFC822 )
				&& strcmp( $format, DATE_RFC850 )
				&& strcmp( $format, DATE_RFC1036 )
				&& strcmp( $format, DATE_RFC1123 )
				&& strcmp( $format, DATE_RFC2822 )
				&& strcmp( $format, DATE_RFC3339 )
				&& strcmp( $format, DATE_RSS )
				&& strcmp( $format, DATE_W3C )
		) $return = true;

		return $return;
	}

	add_filter( 'get_the_date', 'seed_buddhist_year_get_the_date', 10, 3 );
	add_filter( 'the_date', 'seed_buddhist_year_the_date', 10, 4 );
	add_filter( 'get_the_time', 'seed_buddhist_year_get_the_time', 10, 3 );
	add_filter( 'the_time', 'seed_buddhist_year_the_time', 10, 2 );

	add_filter( 'get_comment_date', 'seed_buddhist_year_get_comment_date', 10, 3 );
	add_filter( 'get_comment_time', 'seed_buddhist_year_get_comment_time', 10, 4 );

	function seed_buddhist_year_get_comment_date( $date, $format, $comment ) {
		return seed_buddhist_year( $format, strtotime( $comment->comment_date ) );
	}

	function seed_buddhist_year_get_comment_time ( $time, $format, $gmt = false, $translate = true ) {
		return seed_buddhist_year( $format, strtotime( $comment->comment_date ) );
	}

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

		$the_date = strtotime( $the_date );

		if( $format == '' ) {
			$format = get_option( 'date_format' );
		}

		if( seed_is_return_buddhist( $format ) ) {
			$return = seed_buddhist_year( $format, $the_date );
		} else {
			$return = $content;
		}

		return $return;
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

		$the_date = strtotime( $the_date );

		if( $format == '' ) {
			$format = get_option( 'time_format' );
		}

		if( seed_is_return_buddhist( $format ) ) {
			$return = seed_buddhist_year( $format, $the_date );
		} else {
			$return = $content;
		}

		return $return;
	}

	function seed_buddhist_year_the_time($content = '', $format = '') {
		return get_the_time( $format );
	}

	function seed_buddhist_year( $format = '', $time = null ) {
		$return = '';

		if( $format == '' ) {
			$format = get_option( 'date_format' );
		}

		if( $time === null ) {
			$time = time();
		}

		if( FALSE !== ( $offset = stripos( $format, 'y' ) ) ) {
			$index = 0;

			while( $offset !== FALSE ) {
				$_sub_format = substr( $format, $index, $offset - $index );

				if( $_sub_format != '' ) {
					if( trim( $_sub_format ) == '' )
						$return .= $_sub_format;
					else
						$return .= date_i18n( $_sub_format, $time );
				}

				$year_format = substr( $format, $offset , 1 );
				$return .= date_i18n( $year_format, strtotime( "543 years", $time ) );

				$index = $offset + 1;
				$offset = stripos( $format, 'y', $index );
			}

			$_sub_format = substr( $format, $index );

			if( $_sub_format != '' ) {
				if( trim( $_sub_format ) == '' )
					$return .= $_sub_format;
				else
					$return .= date_i18n( $_sub_format, $time );
			}
		} else {
			$return = date_i18n( $format, $time );
		}

		return $return;
	}