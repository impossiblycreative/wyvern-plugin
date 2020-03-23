<?php

function test_block_dynamic_render_callback( $attributes, $content ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $book_details_title     = $attributes['title'];
    $book_details_author    = $attributes['author'];
    $book_details_summary   = $attributes['summary'];

    // Begin our output
    ob_start();

    // Do our html and such
    ?>
        <div id="<?php echo esc_html( $attributes['anchor'] ); ?>" class="block-book-details <?php echo esc_html( $attributes['className'] ); ?>">
            <h3 class="block-book-details-title"><?php echo esc_html( $book_details_title ); ?></h3>
            <span class="block-book-details-author"><?php echo esc_html( $book_details_author ); ?></span>
            <div class="block-book-details-summary"><?php echo wp_kses_post( $book_details_summary ); ?></div>
        </div>

        <!-- A little debug info -->
        <pre><?php var_dump( $attributes ); ?></pre>
        <pre><?php var_dump( $content ); ?></pre>
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}