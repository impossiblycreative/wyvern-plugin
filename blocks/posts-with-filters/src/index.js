/**
 * BLOCK: FAQs container
 * 
 * Displays a series of FAQs based on a selected category
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { withSelect } from '@wordpress/data';
import { PanelBody, SelectControl, Spinner } from '@wordpress/components';

registerBlockType( 'wyvern-plugin/posts-with-filters' , {
    title:      __( 'Posts with Filters', 'wyvern-plugin' ),
    icon:       icons.filters,
    category:   'wyvern-blocks',
    keywords:   [ __( 'FAQs', 'wyvern-plugin' ) ],

    // Support flags
    supports: {
        alignWide:          true,
        customClassName:    true,
        html:               false, // Turn off by default
    },

    // Override the alignment
    getEditWrapperProps( attributes ) {
        return { 'data-align': 'full' };
    },

    // Editor view
    edit: withSelect( ( select, props ) => {
        return {
        };
    } )( ( props ) => {
        const { attributes, className, setAttributes } = props;

        return (
            <div className={ 'alignfull ' + className }>
                stuff
            </div>
        );
    } ),

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );