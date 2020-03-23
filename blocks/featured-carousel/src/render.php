<?php

function featured_carousel_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes          = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-featured-carousel';
    $block_id               = rand( 0, 100 );
    $featured_posts_count   = 1;

    // Begin our output
    ob_start();

    // Set up the query
    $featured_posts_args = array( 
        'post_type'     => 'post', 
        'meta_query'    => array(
            array(
                'key'       => 'feature_post',
                'value'     => true,
                'compare'   => '='
            ),
        ),
    );

    // Perform the query
    $featured_posts = new WP_Query( $featured_posts_args );

    // Do our html and such
    ?>
        <?php if ( $featured_posts->have_posts() ) : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <div id="featured-carousel-<?php echo $block_id; ?>" class="carousel">
                    <div id="featured-carousel-<?php echo $block_id; ?>-content" class="slides">
                        <?php while( $featured_posts->have_posts() ) : ?>
                            <?php $featured_posts->the_post(); ?>

                            <div class="slide" data-slide-number="<?php echo esc_html( $featured_posts_count ); ?>">
                                <?php echo the_title(); ?>
                            </div>

                            <?php $featured_posts_count++; ?>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>

                <!-- Carousel Navigation -->
                <ul id="featured-carousel-<?php echo $block_id; ?>-navigation" class="carousel-navigation">
                    <?php for ( $i = 1; $i < $featured_posts_count; $i++ ) : ?>
                        <li class="carousel-navigation-button-container">
                            <a class="carousel-navigation-button" href="javascript: void(0)" data-target-slide="<?php echo $i; ?>" tabindex="-1">
                                <span class="screen-reader-text"><?php echo __( 'Scroll to Slide #', 'wyvern-plugin' ); ?><?php echo $i; ?></span>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>

                <!-- Carousel Navigation Controlling Script -->
                <script>
                    var carouselControls = ( function() {
                        const slidesContainerSelector   = 'featured-carousel-<?php echo $block_id ?>-content';
                        const slidesContainer           = document.getElementById( slidesContainerSelector );
                        const slides                    = document.querySelectorAll( `#${ slidesContainerSelector } .slide` );
                        const slideWidth                = slides[0].offsetWidth + 20;
                        const slidesNavButtons          = document.querySelectorAll( '#featured-carousel-<?php echo $block_id; ?>-navigation .carousel-navigation-button' );
                        let scrollObserver;
                        let scrollObserverOptions       = {
                            root:       slidesContainer,
                            rootMargin: '0px',
                            threshold:  0.75
                        };

                        // Scroll to a specific slide when a slide nav button is clicked
                        function scrollToSlide( event ) {
                            const targetSlide = event.target.closest( '.carousel-navigation-button' ).getAttribute( 'data-target-slide' );

                            // Scroll to the slide
                            slidesContainer.scrollLeft = slideWidth * ( targetSlide - 1 );
                        }

                        // Updates the current slide marker
                        function updateCurrentSlides( changes, observer ) {
                            changes.forEach( change => {
                                const slideNumber = change.target.getAttribute( 'data-slide-number' );
                                const slideTargetSelector = '#featured-carousel-<?php echo $block_id; ?>-navigation [data-target-slide="' + slideNumber + '"]';
                                const navButton = document.querySelector( slideTargetSelector );

                                if ( change.isIntersecting ) {
                                    navButton.classList.add( 'current' );
                                } else {
                                    navButton.classList.remove( 'current' );
                                }
                            } );
                        }

                        // Setup our scroll observer to track the current slide
                        scrollObserver = new IntersectionObserver( updateCurrentSlides, scrollObserverOptions );
                        slides.forEach( slide => scrollObserver.observe( slide ) );

                        // Add event listeners for slide nav button clicks
                        slidesNavButtons.forEach( button => button.addEventListener( 'click', scrollToSlide ) );
                    } )();
                </script>
            </div>
        <?php else : ?>
            <div id="featured-carousel-<?php echo rand( 0, 100 ) ?>" class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <p class="error-message"><?php echo esc_html_e( '¡ERROR - No featured posts found!' , 'wyvern-plugin' ); ?></p>
            </div>
        <?php endif; ?>
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}