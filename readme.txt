=== Quick Links ===
Contributors: macbookandrew
Tags: button
Donate link: http://andrewrminion.com/
Tested up to: 4.0
Stable tag: 1.3
License: GPL2

A WordPress plugin to show a series of images as “quick links.”

== Description ==
A WordPress plugin to show a series of images as “quick links” with the shortcode `[quick_links]`.

== Installation ==
1. Install the plugin
1. Look for the “Quick Links” item in the admin section and create as many as needed. Choose a featured image to be displayed, as well as entering a URL if it should link somewhere.
1. Display it one of two ways:
    1. Add the `[quick_links]` shortcode in the page where you want the buttons to be displayed
    1. Add the following line of code in a theme PHP file
    `if ( function_exists( 'home_quick_links' ) ) { home_quick_links(); }`

== Changelog ==
= 1.3 =
 - Add support for image captions

= 1.2 =
 - Allow adding via shortcode or function in PHP file

= 1.1.1 =
 - Check whether or not Modernizr has already been loaded before loading our customized copy

= 1.1 =
 - Add flexbox support to center items in the parent container
 - Add a custom build of Modernizr to detect flexbox support

= 1.0 =
This is the first stable version.
