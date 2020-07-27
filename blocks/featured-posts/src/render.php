<?php

function featured_posts_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes  = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-featured-posts';
    $block_id       = rand( 0, 100 );
    $post_counter   = 0;

    // Begin our output
    ob_start();

    // Set up the query
    $featured_posts_args = array( 
        'post_type'         => 'post',
        'posts_per_page'    => 4,
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

    // Do our html and such
    ?>
        <?php if ( $featured_posts->have_posts() ) : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <div class="wrapper">
                    <?php while ( $featured_posts->have_posts() ) : ?>
                        <?php $featured_posts->the_post(); ?>
                        <?php $post_counter++; ?>
                        <div class="featured-post-container <?php echo ( $post_counter === 1 ) ? 'big' : 'standard'; ?>">
                            <?php $post_id = get_the_id(); ?>
                            <?php $has_video = !empty( get_post_meta( $post_id, 'featured_video', true ) ); ?>

                            <!-- Featured Image -->
                            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                <a class="post-image-container" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $post_id, 'slide', array( 'class' => 'post-image' ) ); ?>

                                    <?php if ( $has_video ) : ?>
                                        <span class="video-icon fas fa-video"></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <a class="post-image-container" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                    <img class="post-image" src="<?php echo esc_url( plugins_url( 'img/default-featured-image.jpg', dirname(__FILE__) ) ); ?>">
                                </a>
                            <?php endif; ?>

                            <!-- Post Information -->
                            <div class="post-content">
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
                                <?php if ( $post_counter === 1 ) : ?>
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
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
                <p class="error-message"><?php echo esc_html_e( '¡ERROR - No featured posts found!' , 'wyvern-plugin' ); ?></p>
            </div>
        <?php endif; ?>
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}