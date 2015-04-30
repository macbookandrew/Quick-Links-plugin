<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'add_meta_boxes', 'armd_ql_add_meta_boxes' );
// add URL metabox
function armd_ql_add_meta_boxes() {
    add_meta_box( 'armd-ql-url', 'Image Link', 'armd_ql_add_url', 'home_quick_link', 'normal' );
    add_meta_box( 'armd-ql-publishing-options', 'Publishing Options', 'armd_ql_add_meta', 'home_quick_link', 'side' );
}

// print URL metabox content
function armd_ql_add_url( $post ) {

    // Get existing data, if any
    $this_url = esc_url( get_post_meta( $post->ID, 'armd_ql_url', true ) );
    $target_blank = get_post_meta( $post->ID, 'armd_ql_target_blank', true );

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'armd_ql_form_picker_meta_box', 'armd_ql_form_picker_meta_box_nonce' );

    echo '<p class="description">';
    echo '<label for="armd_ql_url">Add the URL this Quick Link should link to.</label><br/>';
    echo '<input type="url" name="armd_ql_url" placeholder="' . get_home_url() . '/"';
    // fill with existing data, if present
    if ( isset( $this_url ) ) { echo ' value="' . $this_url . '" '; }
    echo 'size="100%"></p>';
    echo '<p class="description">';
    echo '<label for="armd_ql_target_blank"><input type="checkbox" value="yes" name="armd_ql_target_blank" id="armd_ql_target_blank"';
    // add checked status, if present
    checked( $target_blank, 'yes' );
    echo '>  <em>Open link in a new window/tab</em></label></p>';

}

// print publishing options metabox content
function armd_ql_add_meta( $post ) {

    // Get existing data, if any
    $end_date = get_post_meta( $post->ID, 'armd_ql_end_date', true );

    // Format existing data if it exists
    if ( $end_date ) { $end_date = date( 'Y-m-d', strtotime( $end_date ) ); }

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'armd_ql_form_picker_meta_box', 'armd_ql_form_picker_meta_box_nonce' );

    echo '<p>Begin Date: change the <strong>Publish</strong> date above.</p>';
    echo '<label for="armd_ql_end_date">End Date: <input type="date" name="armd_ql_end_date" placeholder="' . date( 'm/d/Y' ) . '"';
        // fill with existing data, if present
        if ( isset( $end_date ) ) { echo ' value="' . $end_date . '" '; }
    echo '></label><br/>';

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
	$sanitized_URL = sanitize_text_field( $_POST['armd_ql_url'] );
    if ( sanitize_text_field( $_POST['armd_ql_target_blank'] ) === 'yes' ) {
        $sanitized_target_blank = 'yes';
    } else {
        $sanitized_target_blank = 'no';
    }
	if ( $_POST['armd_ql_end_date'] ) {
        $sanitized_end_date = date( 'Ymd', strtotime( sanitize_text_field( $_POST['armd_ql_end_date'] ) ) );
    }
    else {
        $sanitized_end_date = NULL;
    }

	// Update the meta field in the database.
    update_post_meta( $post_id, 'armd_ql_url', $sanitized_URL );
    update_post_meta( $post_id, 'armd_ql_target_blank', $sanitized_target_blank );
    update_post_meta( $post_id, 'armd_ql_end_date', $sanitized_end_date );

}

add_action('do_meta_boxes', 'meta_box_position');
// move featured image metabox
function meta_box_position() {
    $custom_thumbnail_dimensions = get_image_sizes( 'home_quick_link' );
    $home_quick_link_dimensions = $custom_thumbnail_dimensions['width'] . '&times;' . $custom_thumbnail_dimensions['height'] . 'px';

	remove_meta_box( 'postimagediv', 'home_quick_link', 'side' );
	add_meta_box('postimagediv', 'Featured Image (' . $home_quick_link_dimensions . ')', 'post_thumbnail_meta_box', 'home_quick_link', 'normal', 'high');
}
