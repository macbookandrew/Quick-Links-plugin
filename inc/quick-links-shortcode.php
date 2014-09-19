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
        $output = '<section class="home-links-container">';

        while ( $home_links_query->have_posts() ) {

            $home_links_query->the_post();
            $URL = get_post_meta( $home_links_query->ID, 'armd_ql_url', true );

            $output .= '<figure class="home-link">';
            $output .= '<a href="' . $URL . '">' . get_the_post_thumbnail( $home_links_query->ID, 'full' ) . '</a>';
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
