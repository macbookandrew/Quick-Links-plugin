<?php
/**
 * Plugin Name: Quick Links
 * Plugin URI: http://code.andrewrminion.com/quick-links-plugin
 * Description: Gives you “quick link” buttons on the home page
 * Version: 1.2
 * Author: Andrew Minion
 * Author URI: http://andrewrminion.com
 * License: GPL2
 */

/* Prevent this file from being accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( 'inc/quick-links-post-type.php' );

/* load backend */
if ( is_admin() ) {
    require_once( 'inc/quick-links-admin.php' );
}

/* display frontend */
if ( ! is_admin() ) {
    require_once( 'inc/quick-links-shortcode.php' );

    // check for existing styles before loading this stylesheet
    add_action( 'wp_enqueue_scripts', 'armd_ql_css' );

    function armd_ql_css() {
        if ( file_exists( get_stylesheet_directory() . '/quick-links-styles.css' ) ) {
            wp_enqueue_style( 'quick-link-styles', get_stylesheet_directory_uri() . '/quick-links-styles.css', array(), '1.0' );
        }
        elseif ( file_exists( get_template_directory() . '/quick-links-styles.css' ) ) {
            wp_enqueue_style( 'quick-link-styles', get_template_directory_uri() . '/quick-links-styles.css', array(), '1.0' );
        }
        else {
            wp_enqueue_style( 'quick-link-styles', plugins_url( '/css/quick-links-styles.css', __FILE__ ), array(), '1.0' );
        }
    }

    // register modernizr unless it already has been registered
    function register_modernizr() {
        if ( wp_script_is( 'modernizr' ) ) { return; }
        else { wp_enqueue_script( 'modernizr-flexbox-flexboxlegacy', plugins_url( '/js/modernizr.flexbox.js', __FILE__ ) ); }
    }
    add_action( 'wp_enqueue_scripts', 'register_modernizr' );
}

#TODO: add recommended sizes, etc.
#TODO: add "order" field to allow sorting, add to query ORDERBY
#TODO: add parameters to shortcode and categories to allow multiple "sets"
