<?php

function newsletter_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes  = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-newsletter';
    $prompt         = $attributes['prompt'];
    $form_name      = $attributes['formName'];

    // Begin our output
    ob_start();

    // Do our html and such
    ?>
        <?php if ( !empty( $form_name ) ) : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <div class="wrapper">
                    <?php if ( !empty( $prompt ) ) : ?>
                        <p class="newsletter-prompt"><?php echo esc_html( $prompt ); ?></p>
                    <?php endif; ?>
                    <?php gravity_form( $form_name, false, false, false, false, true ); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <p class="error-message"><?php echo esc_html_e( '¡ERROR - No signup form found!' , 'wyvern-plugin' ); ?></p>
            </div>
        <?php endif; ?>
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}