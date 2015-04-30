=== Quick Links ===
Contributors: macbookandrew
Tags: button
Donate link: http://andrewrminion.com/
Tested up to: 4.2.1
Stable tag: 1.6
License: GPL2

A WordPress plugin to show a series of images as “quick links.”

== Description ==
A WordPress plugin to show a series of images as “quick links” with the shortcode `[quick_links]`.

By adding a line in your `functions.php` file, you can set the size of the images (defaults to 500×300px). See the Installation section for more details.

== Installation ==
1. Install the plugin
1. Look for the “Quick Links” item in the admin section and create as many as needed. Choose a featured image to be displayed, as well as entering a URL if it should link somewhere.
1. Display it one of two ways:
    1. Add the `[quick_links]` shortcode in the page where you want the buttons to be displayed
    1. Add the following line of code in a theme PHP file
    `if ( function_exists( 'home_quick_links' ) ) { home_quick_links(); }`
1. To change the size of the images, add this line  of code in your theme’s `functions.php` file and edit the dimensions: `add_image_size( 'home_quick_link', '500', '300' );`

=== Advanced ===
 - To include your own stylesheet, add a file named `quick-links-styles.css` in your template folder.

== Changelog ==
= 1.6 =
 - Make images output more accessible using the slide title
 - Simplify spacing rules
 - Add some no-flexbox fallbacks
 - Bump “tested up to” version

= 1.5.1 =
 - Display custom image size in featured image metabox

= 1.5 =
 - Add support for custom thumbnail sizes

= 1.4.1 =
 - Make image output more accessibility-friendly

= 1.4 =
 - Add support for ending date

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
 - This is the first stable version.
