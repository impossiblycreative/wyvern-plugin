/**
 * BLOCK: Featured Posts Carousel
 * 
 * Displays a carousel of all posts with the 'featured' post meta flag
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType( 'wyvern-plugin/featured-carousel' , {
    title:      __( 'Featured Posts Carousel', 'wyvern-plugin' ),
    icon:       icons.featuredCarousel,
    category:   'wyvern-blocks',
    keywords:   [ __( 'featured', 'wyvern-plugin' ), __( 'slider', 'wyvern-plugin' ), __( 'carousel', 'wyvern-plugin' ) ],

    // Support flags
    supports: {
        alignWide:          true,
        customClassName:    true,
        html:               false, // Turn off by default
    },

    // Editor view
    edit: ( props ) => {
        const { attributes, className, setAttributes } = props;

        return (
            <div className={ className }>
                Posts selected as "Featured" will display in a carousel.
            </div>
        );
    },

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );