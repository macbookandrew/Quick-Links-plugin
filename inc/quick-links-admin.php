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

add_action( 'add_meta_boxes', 'armd_ql_add_meta_box' );
// add URL metabox
function armd_ql_add_meta_box() {
    add_meta_box( 'armd-ql-url', 'Image Link', 'armd_ql_add_meta', 'home_quick_link', 'normal' );
}

// print URL metabox content
function armd_ql_add_meta( $post ) {

    // Get existing data, if any
    $this_url = get_post_meta( $post->ID, 'armd_ql_url', true );

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'armd_ql_form_picker_meta_box', 'armd_ql_form_picker_meta_box_nonce' );

    echo '<input type="url" name="armd_ql_url" placeholder="' . get_home_url() . '/"';
        // fill with existing data, if present
        if ( isset( $this_url ) ) { echo ' value="' . $this_url . '" '; }
    echo 'size="100%"><br/>';
    echo '<label for="armd_ql_url">Add the URL this Quick Link should link to.</label>';

}

add_action( 'save_post', 'armd_ql_save_meta_box_data' );
// save URL when post is saved
function armd_ql_save_meta_box_data( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['armd_ql_form_picker_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['armd_ql_form_picker_meta_box_nonce'], 'armd_ql_form_picker_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'home_quick_link' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_pages', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			return;
		}
	}

	// Make sure that it is set.
	if ( ! isset( $_POST['armd_ql_url'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['armd_ql_url'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'armd_ql_url', $my_data );

}

add_action('do_meta_boxes', 'meta_box_position');
// move featured image metabox
#TODO: figure out why it's not moving
function meta_box_position() {
	remove_meta_box( 'postimagediv', 'post', 'side' );
	add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'post', 'normal', 'high');
}
