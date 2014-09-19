<?php
/**
 * Plugin Name: Quick Links
 * Plugin URI: http://code.andrewrminion.com/quick-links-plugin
 * Description: Gives you “quick link” buttons on the home page
 * Version: 1.0
 * Author: Andrew Minion
 * Author URI: http://andrewrminion.com
 * License: GPL2
 */

/* Prevent this file from being accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* load backend */
if ( is_admin() ) {
    require_once( 'inc/quick-links-admin.php' );
}

/* display frontend */
if ( ! is_admin() ) {
    require_once( 'inc/quick-links-shortcode.php' );
}

?>