<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', 'create_quick_link', 0 );
// register quick links custom post type
function create_quick_link() {

    $labels = array(
		'name'                => 'Quick Links',
		'singular_name'       => 'Quick Link',
		'menu_name'           => 'Quick Links',
		'parent_item_colon'   => 'Parent Quick Link:',
		'all_items'           => 'All Quick Links',
		'view_item'           => 'View Quick Link',
		'add_new_item'        => 'Add New Quick Link',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Quick Link',
		'update_item'         => 'Update Quick Link',
		'search_items'        => 'Search Quick Link',
		'not_found'           => 'Not found',
		'not_found_in_trash'  => 'Not found in Trash',
	);
	$args = array(
		'label'               => 'home_quick_link',
		'description'         => 'Homepage Quick Link',
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-format-image',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'home_quick_link', $args );

}

// add custom thumbnail size if it doesn't exist already
add_action( 'init', 'create_thumbnail_size' );
function create_thumbnail_size() {
    if ( ! in_array( 'home_quick_link', get_intermediate_image_sizes() ) ) {
        add_image_size( 'home_quick_link', '600', '600' );
    }
}

// add thumbnail support if theme doesn't support it already
add_action( 'after_setup_theme', 'add_thumbnail_support' );
function add_thumbnail_support() {
    if ( ! current_theme_supports( 'post-thumbnails' ) ) {
        add_theme_support( 'post-thumbnails', array( 'home_quick_link' ) );
    }
}
