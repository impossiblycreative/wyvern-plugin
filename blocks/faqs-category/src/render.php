<?php

function faqs_category_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes          = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-faqs-category';
    $block_id               = rand( 0, 100 );

    // Begin our output
    ob_start();

    // Set up the query
    $faqs_args = array( 
        'post_type'         => 'wyvern_faqs',
        'posts_per_page'    => -1,
        'orderby'           => 'page_order',
        'order'             => 'ASC',
    );

    // Perform the query
    $faqs = new WP_Query( $faqs_args );

    // Do our html and such
    ?>
        <?php if ( $faqs->have_posts() ) : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <h2 class="faqs-block-header"><?php echo esc_html_e( 'Frequently Asked Questions', 'wyvern-plugin' ); ?></h2>
                <?php while( $faqs->have_posts() ) : ?>
                    <?php $faqs->the_post(); ?>

                    <div class="faq">
                        <h3 class="faq-header"><?php echo esc_html( get_the_title() ); ?></h3>
                        <div class="faq-content"><?php echo wp_kses_post( get_the_content() ); ?></div>
                    </div>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <p class="error-message"><?php echo esc_html_e( '¡ERROR - No FAQs found!' , 'wyvern-plugin' ); ?></p>
            </div>
        <?php endif; ?>
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}