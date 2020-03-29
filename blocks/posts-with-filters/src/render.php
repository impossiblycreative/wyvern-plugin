<?php

function posts_with_filters_render_callback( $attributes, $content = '' ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_classes          = ( $attributes['className'] ) ? $attributes['className'] : 'wp-block-wyvern-plugin-posts-with-filters';
    $block_id               = rand( 0, 100 );

    // ???
    $categories = get_categories( array( 'orderby' => 'name', 'parent'  => 0 ) );
    $posts_args = array(
        'post_type'         => 'post',
        'posts_per_page'    => 12,
    );
    $posts      = new WP_Query( $posts_args );

    // Begin our output
    ob_start();

    // Do our html and such
    ?>
        <div class="alignfull <?php echo esc_html( $block_classes ); ?>">
            <!-- Posts Filter -->
            <?php if ( $categories ) : ?>
                <ul id="posts-category-filters-<?php echo $block_id; ?>" class="posts-category-filters">
                    <li class="posts-category-filter current">
                        <a href="javascript: void(0)" data-category="0" data-category-name="<?php esc_html_e( 'all categories', 'wyvern-plugin' ); ?>" title="<?php esc_html_e( 'Display posts from all categories', 'wyvern-plugin' ); ?>"><?php esc_html_e( 'All', 'wyvern-plugin' ); ?></a>
                    </li>            

                    <?php foreach ( $categories as $category ) { ?>
                        <li class="posts-category-filter">
                            <a href="javascript: void(0)" data-category="<?php echo esc_html( $category->term_id ); ?>" data-category-slug="<?php echo esc_html( $category->slug ); ?>" data-category-name="<?php echo esc_html( $category->name ); ?>" title="<?php esc_html_e( 'Display posts from the ', 'wyvern-plugin' ); echo esc_html( $category->name ); esc_html_e( ' category.', 'wyvern-plugin' ); ?>">
                                <?php echo esc_html( $category->name ); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php endif; ?>

            <!-- ARIA LIVE area -->
            <div id="posts-filter-description-<?php echo $block_id; ?>" class="screen-reader-text" aria-live="polite" aria-atomic="true">
                <?php esc_html_e( 'Currently displaying posts from all categories.', 'wyvern-plugin' );?>
            </div>

            <!-- Posts Display -->
            <?php if ( $posts->have_posts() ) : ?>
                <div id="posts-container-<?php echo $block_id; ?>" class="posts-container">
                    <?php while ( $posts->have_posts() ) : ?>
                        <?php $posts->the_post(); ?>
                        <?php $post_id = get_the_ID(); ?>

                        <div class="post-card">
                            <a class="post-card-image-container" href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                                    <?php echo get_the_post_thumbnail( $post_id, 'post-card', array( 'class' => 'post-card-image' ) ); ?>
                                <?php endif; ?>
                            </a>

                            <div class="post-card-content">
                                <?php $post_categories = wp_get_post_categories( $post_id ); ?>
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

                                <h2 class="post-title">
                                    <a href="<?php echo esc_url( get_the_permalink( $post_id ) ); ?>">
                                        <?php echo esc_html( get_the_title( $post_id ) ); ?>
                                    </a>
                                </h2>
                                
                                <?php $post_likes = get_post_meta( $post_id, '_wyvern_likes', true ) ? get_post_meta( $post_id, '_wyvern_likes', true ) : 0; ?>
                                        
                                <div class="post-meta">
                                    <span class="post-date">
                                        <span class="fas fa-calendar-alt"></span>
                                        <span class="post-date-text"><?php echo esc_html( get_the_date( 'F jS, Y', $post_id ) ); ?></span>
                                    </span>

                                    <span class="post-comment-count">
                                        <span class="fas fa-comments"></span>
                                        <?php echo get_comments_number( $post_id ); ?>
                                    </span>

                                    <span class="post-like-count">
                                        <span class="fas fa-heart"></span>
                                        <span class="post-like-count-number"><?php echo esc_html( $post_likes ); ?></span>
                                    </span>
                                </div>

                                <p class="post-excerpt"><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>

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
                    <?php endwhile; ?>
                </div>

                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="error-message"><?php echo esc_html_e( '¡ERROR - No posts found!' , 'wyvern-plugin' ); ?></p>
            <?php endif; ?>

            <!-- Post Filtering Scripts -->
            <script>
                var postCategoryFilters = ( function() {
                    const allFilters = document.querySelectorAll( '#posts-category-filters-<?php echo $block_id; ?> .posts-category-filter a' );

                    // Makes our REST API request
                    async function restRequest( restURL ) {
                        const data = await fetch( restURL );
                        return data;
                    }

                    // Gives us the correct date format
                    function formatPostDate( date ) {
                        let formattedDate   = '';
                        const split         = date.split( '-' );
                        const day           = split[2].substring( 0, split[2].indexOf( 'T' ) );
                        const months        = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                        formattedDate = months[parseInt( split[1] )] + ' ' + day + ', ' + split[0];

                        return formattedDate;
                    }

                    // Gets the HTML for the Featured Image
                    function getFeaturedImageHTML( postData ) {
                        const altText   = postData._embedded['wp:featuredmedia'][0].alt_text;
                        const sourceURL = postData._embedded['wp:featuredmedia'][0].media_details.sizes['post-card'].source_url;

                        return `
                            <a class="post-card-image-container" href="${ postData.link }">
                                <img class="post-card-image" alt="${ altText }" src="${ sourceURL }"> 
                            </a>
                        `;
                    }

                    // Gets the HTML for the full post card
                    function buildPostCardHTML( postData ) {
                        let featuredImageHTML = ''; 
                        const postDate = formatPostDate( postData.date );

                        if( postData._embedded['wp:featuredmedia'] ) {
                            featuredImageHTML = getFeaturedImageHTML( postData );
                        }

                        return `
                            <div class="post-card">
                                ${ featuredImageHTML }
                                <div class="post-card-content">
                                    <h2 class="post-title">${ postData.title.rendered }</h2>
                                    <div class="post-meta">
                                        <span class="post-date">
                                            <span class="fas fa-calendar-alt"></span>
                                            <span class="post-date-text">${ postDate }</span>
                                        </span>

                                        <span class="post-like-count">
                                            <span class="fas fa-heart"></span>
                                            <span class="post-like-count-number">${ postData.meta._wyvern_likes }</span>
                                        </span>
                                    </div>

                                    <div class="post-excerpt">${ postData.excerpt.rendered }</div>

                                    <a class="read-more" href="${ postData.link }">
                                        <span class="button read-more-button">
                                            <span class="read-more-text">
                                                <span><?php esc_html_e( 'Read More', 'wyvern-plugin' ); ?></span>
                                                <span class="screen-reader-text">... of ${ postData.title.rendered }</span>
                                            </span>
                                            <span class="icon fas fa-book-reader"></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        `;
                    }

                    // Filter the posts on click
                    function filterPosts( event ) {
                        let restURL             = '<?php echo esc_url( get_rest_url( null, 'wp/v2/posts' ) ) ?>' + '?_embed&per_page=12';
                        const category          = this.getAttribute( 'data-category' );
                        const categorySlug      = this.getAttribute( 'data-category-slug' );
                        const categoryName      = this.getAttribute( 'data-category-name' );
                        const nonce             = this.getAttribute( 'data-nonce' );
                        const updateBox         = document.getElementById( 'posts-filter-description-<?php echo $block_id; ?>' );
                        const postsContainer    = document.getElementById( 'posts-container-<?php echo $block_id; ?>' );
                        let postsHTML           = '';

                        // Check if we're requesting a category
                        if ( parseInt( category ) !== 0 ) {
                            restURL += '&categories=' + category;
                        }

                        // Make our request
                        const restData = restRequest( restURL );

                        // Update the ARIA-Live info
                        updateBox.textContent = 'Currently displaying posts from ' + categoryName;

                        // Handle the response
                        restData.then( response => {
                            response.json().then( data => {
                                data.forEach( datum => postsHTML += buildPostCardHTML( datum ) );
                                postsContainer.innerHTML = postsHTML;
                            } ).then( () => {
                                if( parseInt( category ) !== 0 ) {
                                    postsContainer.innerHTML += `
                                        <div class="button-container">
                                            <a class="button" href="<?php echo esc_url( home_url( '/' ) ) ?>category/${ categorySlug }">
                                                <?php echo esc_html_e( 'Sell all posts in ', 'wyvern-plugin' ); ?>${ categoryName }
                                            </a>
                                        </div>
                                    `;
                                } else {
                                    postsContainer.innerHTML += `
                                        <div class="button-container">
                                            <a class="button" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ) ?>">
                                                <?php echo esc_html_e( 'Sell all posts in ', 'wyvern-plugin' ); ?>${ categoryName }
                                            </a>
                                        </div>
                                    `;
                                }
                            } )
                        }, function( error ) {
                            console.log('ERROR: ' + error);
                        } );
                    }

                    allFilters.forEach( filter => filter.addEventListener( 'click', filterPosts ) );
                } )();
            </script>
        </div>

    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}