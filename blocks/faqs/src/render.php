<?php

function faqs_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes          = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-faqs';
    $block_id               = rand( 0, 100 );
    $faq_category           = get_term( $attributes['faqCategory'] )->slug;
    $faq_counter            = 0;
    $tax_query              = NULL;

    if ( !empty( $faq_category ) ) {
        $tax_query = array(
            array(
                'taxonomy'          => 'wyvern_faq_categories',
                'field'             => 'slug',
                'terms'             => $faq_category,
                'include_children'	=> 0
            ),
        );
    }

    // Begin our output
    ob_start();

    // Set up the query
    $faqs_args = array( 
        'post_type'         => 'wyvern_faqs',
        'posts_per_page'    => -1,
        'tax_query'         => ( $tax_query ) ? $tax_query : '',
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

                <div id="faqs-<?php echo $block_id ?>" class="faqs-container accordion-container">
                    <?php while( $faqs->have_posts() ) : ?>
                        <?php $faqs->the_post(); ?>
                        <?php $faq_counter++; ?>

                        <div id="faq-<?php echo $faq_counter; ?>" class="faq" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <h3 id="faq-<?php echo $faq_counter; ?>-header" class="faq-header accordion-header">
                                <button class="accordion-trigger" aria-controls="faq-<?php echo $faq_counter; ?>-content" aria-expanded="<?php echo ( $faq_counter === 1 ) ? 'true' : 'false' ; ?>" <?php echo ( $faq_counter === 1 ) ? 'aria-disabled="true"' : ''; ?>>
                                    <span class="faq-header-text" itemprop="name"><?php echo esc_html( get_the_title() ); ?></span>
                                    <span class="fas <?php echo ( $faq_counter === 1 ) ? 'fa-minus' : 'fa-plus'; ?>"></span>
                                </button>
                            </h3>
                            <div id="faq-<?php echo $faq_counter; ?>-content" class="faq-content-container accordion-panel" role="region" aria-labelledby="faq-<?php echo $faq_counter; ?>-header" <?php echo ( $faq_counter === 1 ) ? '' : 'hidden'; ?> itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div class="faq-content accordion-content" itemprop="text"><?php echo wp_kses_post( get_the_content() ); ?></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Accordion Controlling Script -->
                <script>
                    var accordionControls = ( function() {
                        const triggers = document.querySelectorAll( '#faqs-<?php echo $block_id; ?> .accordion-trigger' );

                        function toggleAccordion( event ) {
                            let trigger = event.target;

                            // Make sure we have the actual trigger
                            if ( trigger.tagName === 'SPAN' ) {
                                trigger = trigger.parentNode;
                            }

                            // Set the ARIA Expanded
                            const expanded = ( trigger.getAttribute( 'aria-expanded' ) === 'true' ) ? false : true;
                            trigger.setAttribute( 'aria-expanded', expanded );

                            // Toggle the content display
                            const content = document.getElementById( trigger.getAttribute( 'aria-controls' ) );
                            content.toggleAttribute( 'hidden' );

                            // Swap the icon
                            const buttonIcon = trigger.querySelector( '.fas' );
                            buttonIcon.classList.toggle( 'fa-minus' );
                            buttonIcon.classList.toggle( 'fa-plus' );
                        }

                        triggers.forEach( trigger => trigger.addEventListener( 'click', toggleAccordion ) );
                    } )();
                </script>

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