<?php

function featured_carousel_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes          = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-featured-carousel';
    $block_id               = rand( 0, 100 );
    $featured_posts_count   = 1;

    // Set up the query
    $featured_posts_args = array( 
        'post_type'         => 'post',
        'posts_per_page'    => -1,
        'meta_query'        => array(
            array(
                'key'       => 'feature_post',
                'value'     => true,
                'compare'   => '='
            ),
        ),
    );

    // Perform the query
    $featured_posts = new WP_Query( $featured_posts_args );

    // Begin our output
    ob_start();

    // Do our html and such
    ?>
        <?php if ( $featured_posts->have_posts() ) : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <div id="featured-carousel-<?php echo $block_id; ?>" class="carousel">
                    <div id="featured-carousel-<?php echo $block_id; ?>-content" class="slides">
                        <?php while( $featured_posts->have_posts() ) : ?>
                            <?php $featured_posts->the_post(); ?>

                            <div class="slide" data-slide-number="<?php echo esc_html( $featured_posts_count ); ?>">
                                <?php $post_id = get_the_id(); ?>

                                <!-- Featured Image -->
                                <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                    <a class="slide-image-container" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                        <?php echo get_the_post_thumbnail( $post_id, 'slide', array( 'class' => 'slide-image' ) ); ?>
                                    </a>
                                <?php else : ?>
                                    <a class="slide-image-container" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                        <img class="slide-image" src="<?php echo esc_url( plugins_url( 'img/default-featured-image.jpg', dirname(__FILE__) ) ); ?>">
                                    </a>
                                <?php endif; ?>

                                <!-- Post Information -->
                                <div class="slide-content">
                                    <?php $post_categories = wp_get_post_categories( $post_id ); ?>

                                    <!-- Post Categories -->
                                    <?php if ( $post_categories ) : ?>
                                        <ul class="categories-list">
                                            <?php foreach( $post_categories as $category) : ?>
                                                <?php $current_cat = get_category( $category ); ?>

                                                <li class="categories-list-item">
                                                    <a href="<?php echo esc_url( get_category_link( $current_cat ) ); ?>"><?php echo esc_html( $current_cat->name ); ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <!-- Post Title -->
                                    <h2 class="post-title">
                                        <a href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                            <?php echo esc_html( get_the_title( $post_id ) ); ?>
                                        </a>
                                    </h2>

                                    <!-- Post Meta -->
                                    <div class="post-meta">
                                        
                                        <!-- Post Date -->
                                        <span class="post-date">
                                            <span class="fas fa-calendar-alt"></span>
                                            <span class="post-date-text"><?php echo esc_html( get_the_date( 'F jS, Y', $post_id ) ); ?></span>
                                        </span>

                                        <!-- Post Comment Count -->
                                        <span class="post-comment-count">
                                            <span class="fas fa-comments"></span>
                                            <?php echo get_comments_number( $post_id ); ?>
                                        </span>

                                        <!-- Post Likes -->
                                        <?php $post_likes = get_post_meta( $post_id, '_wyvern_likes', true ) ? get_post_meta( $post_id, '_wyvern_likes', true ) : 0; ?>
                                        <span class="post-like-count">
                                            <span class="fas fa-heart"></span>
                                            <span class="post-like-count-number"><?php echo esc_html( $post_likes ); ?></span>
                                        </span>

                                        <!-- Post Excerpt -->
                                        <p class="post-excerpt"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>

                                        <!-- Read More Link -->
                                        <a class="read-more" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                            <span class="button read-more-button">
                                                <span class="read-more-text">
                                                    <span><?php esc_html_e( 'Read More', 'wyvern-plugin' ); ?></span>
                                                    <span class="screen-reader-text">... of <?php esc_html( get_the_title( $post_id ) ); ?></span>
                                                </span>
                                                <span class="icon fas fa-book-reader"></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
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