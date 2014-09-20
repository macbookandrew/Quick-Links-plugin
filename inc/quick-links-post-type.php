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
		'supports'            => array( 'title', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-format-image',
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'home_quick_link', $args );

}
