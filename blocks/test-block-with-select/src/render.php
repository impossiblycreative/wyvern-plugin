<?php

function test_block_with_select_render_callback( $attributes ) {
    $html = '¡ERROR - BLOCK OUTPUT FAILED!';

    // Get our data
    $block_id       = $attributes['anchor'];
    $block_classes  = $attributes['className'];
    $list_title     = $attributes['listTitle'];

    // Get our posts
    $args = array(
        'posts_per_page'        => 3,
        'ignore_sticky_posts'   => true,
        'post_type'             => 'post',
    );

    $recent_posts = new WP_Query( $args );

    // Begin our output
    ob_start();

    // Do our html and such
    ?>
        <div id="<?php echo esc_html( $block_id ); ?>" class="block-with-select <?php echo esc_html( $block_classes ); ?>">
            <h2 class="block-with-select-list-title"><?php echo $list_title ? esc_html( $list_title ) : __( 'Default List Title', 'wyvern-plugin' ) ?></h2>

            <ul class="block-with-select-list">
                <?php if ( $recent_posts->have_posts() ) : ?>
                    <?php while ( $recent_posts->have_posts() ) : ?>
                        <?php $recent_posts->the_post(); ?>
                        
                        <?php
                            $id = $recent['ID']; 
                            $link = get_the_permalink( $id ); 
                            $title = get_the_title( $id ); 
                        ?>
                        
                        <li class="block-with-select-list-item">
                            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
                        </li>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- A little debug info -->
        <pre class="debug-info">DEBUG: var_dump of $attributes<br /><?php var_dump( $attributes ); ?></pre>
        
    <?php
    // Grab the output & store it
    $html = ob_get_clean();

    // Send it back to be rendered
    return $html;
}