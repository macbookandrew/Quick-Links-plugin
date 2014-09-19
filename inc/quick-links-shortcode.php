<?php
/* Prevent this file from being accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'quick_links', 'home_quick_links' );
// add quick-link shortcode
function home_quick_links() {

    // get all home_quick_link posts
    $args = array (
        'post_type'              => 'home_quick_link',
    );

    // The Query
    $home_links_query = new WP_Query( $args );

    // The Loop
    if ( $home_links_query->have_posts() ) {

        // start content container
        $output = '<section class="home-quick-links-container">';

        while ( $home_links_query->have_posts() ) {

            $home_links_query->the_post();
            $URL = get_post_meta( get_the_ID(), 'armd_ql_url', true );
            $image_URL_array = wp_get_attachment_image_src( get_post_thumbnail_ID( $home_links_query->ID ), 'full' );
            $image_URL = $image_URL_array[0];

            $output .= '<figure class="home-quick-link">';
            $output .= '<a href="' . $URL . '"><img src="' . $image_URL . '" /></a>';
            $output .= '</figure>';

        }
        $output .= '</section><!-- .home-links-container -->';

        return $output;

    } else {
        // no posts found
    }

    // Restore original Post Data
    wp_reset_postdata();

}
