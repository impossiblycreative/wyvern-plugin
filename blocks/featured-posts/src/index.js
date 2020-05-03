/**
 * BLOCK: Featured Posts 
 * 
 * Displays a carousel of all posts with the 'featured' post meta flag
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType( 'wyvern-plugin/featured-posts' , {
    title:      __( 'Featured Posts', 'wyvern-plugin' ),
    icon:       icons.featuredPosts,
    category:   'wyvern-blocks',
    keywords:   [ __( 'featured', 'wyvern-plugin' ) ],

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
                Posts selected as "Featured" will display here.
            </div>
        );
    },

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );