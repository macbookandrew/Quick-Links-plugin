<?php
/**
 * Plugin Name: Quick Links
 * Plugin URI: http://code.andrewrminion.com/quick-links-plugin
 * Description: A WordPress plugin to show a series of images as “quick links.”
 * Version: 1.7.1
 * Author: AndrewRMinion Design
 * Author URI: https://andrewrminion.com/
 * License: GPL2
 */

/* Prevent this file from being accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* register post type */
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
            wp_register_style( 'quick-link-styles', get_stylesheet_directory_uri() . '/quick-links-styles.css', array(), '1.7' );
        }
        elseif ( file_exists( get_template_directory() . '/quick-links-styles.css' ) ) {
            wp_register_style( 'quick-link-styles', get_template_directory_uri() . '/quick-links-styles.css', array(), '1.7' );
        }
        else {
            wp_register_style( 'quick-link-styles', plugins_url( '/css/quick-links-styles.css', __FILE__ ), array(), '1.7' );
        }
    }

    // register modernizr unless it already has been registered
    function register_modernizr() {
        if ( wp_script_is( 'modernizr' ) ) { return; }
        else { wp_register_script( 'modernizr-flexbox-flexboxlegacy', plugins_url( '/js/modernizr.flexbox.js', __FILE__ ) ); }
    }
    add_action( 'wp_enqueue_scripts', 'register_modernizr', 15 );
}

/* get image thumbnail sizes */
function get_image_sizes( $size = '' ) {
    global $_wp_additional_image_sizes;

    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    }

    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }

    return $sizes;
}

/* handle upgrades */
register_activation_hook( __FILE__, 'armd_ql_fix_null_values' );
function armd_ql_fix_null_values() {
    global $wpdb;
    $wpdb->update(
        $wpdb->prefix . 'postmeta',
        array( 'meta_value' => '99991231' ),
        array(
            'meta_key'      => 'armd_ql_end_date',
            'meta_value'    => NULL,
        )
    );
}

#TODO: add parameters to shortcode and categories to allow multiple "sets"
