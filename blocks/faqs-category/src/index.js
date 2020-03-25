/**
 * BLOCK: FAQs container
 * 
 * Displays a series of FAQs based on a selected category
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

registerBlockType( 'wyvern-plugin/faqs-category' , {
    title:      __( 'FAQs Category', 'wyvern-plugin' ),
    icon:       icons.faqs,
    category:   'wyvern-blocks',
    keywords:   [ __( 'FAQs', 'wyvern-plugin' ) ],

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
                FAQs from your selected category will display here.
            </div>
        );
    },

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );