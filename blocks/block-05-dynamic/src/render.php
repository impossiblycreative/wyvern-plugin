<?php
/**
 * Render callback for the block.
 */
function block_05_dynamic_render_callback( $attributes, $content ) {
    $recent_posts = wp_get_recent_posts( array(
        'numberposts'   => 1,
        'post_status'   => 'publish',
    ) );

    if ( count( $recent_posts ) === 0 ) {
        $message = __( 'No posts.', 'wyvern-plugin' );

        return $message;
    }

    $post = $recent_posts[0];
    $post_id = $post['ID'];

    return sprintf( 
        '<a class="wp-block-wyvern-plugin-latest-post" href="%1$s">%2$s</a>',
        esc_url( get_permalink( $post_id ) ),
        esc_html( get_the_title( $post_id ) )
    );
}