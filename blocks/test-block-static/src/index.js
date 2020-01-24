/**
 * BLOCK: Test Block - Static
 * 
 * A demo block that is static (doesn't pull data from anywhere).
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

registerBlockType( 'wyvern-plugin/test-block-static' , {
    title:      __( 'Test Block - Static', 'wyvern-plugin' ),
    icon:       icons.testBlockStatic,
    category:   'wyvern-plugin-blocks',
    keywords:   [ __( 'Test', 'wyvern-plugin' ), __( 'Static', 'wyvern-plugin' ) ],

    // Support flags
    supports: {
        alignWide:          true,
        anchor:             true,
        customClassName:    true,
        html:               false, // Turn off by default
    },

    // Data model
    attributes: {
        alignment: {
            type:       'string',
            default:    'none',
        },

        anchor: {
            type:       'string',
        },

        className: {
            type:       'string',
            default:    'wp-block-wyvern-plugin-test-block-static',
        },

        title: {
            type:       'string',
            selector:   'js-book-details-title',
        },

        author: {
            type:       'string',
            selector:   'js-book-details-author',
        },

        summary: {
            type:       'string',
            selector:   'js-book-details-summary',
            multiline:  'p',
        },
    },

    // Editor view
    edit: ( props ) => {
        const { attributes, className, setAttributes } = props;

        return (
            <div className={ className }>
                <RichText
                    className="js-book-details-title wp-admin-book-details-title"
                    value={ attributes.title }
                    onChange={ value => setAttributes( { title: value } ) }
                    tagName="h3"
                    placeholder="Book title"
                />

                <RichText
                    className="js-book-details-author wp-admin-book-details-author"
                    value={ attributes.author }
                    onChange={ value => setAttributes( { author: value } ) }
                    tagName="span"
                    placeholder="Book author"
                />

                <RichText
                    className="js-book-details-summary wp-admin-book-details-summary"
                    value={ attributes.summary }
                    onChange={ value => setAttributes( { summary: value } ) }
                    tagName="div"
                    placeholder="Book summary"
                    multiline="p"
                />
            </div>
        );
    },

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => {
        const { attributes, className } = props;

        return (
            <div className={ className }>
                <RichText.Content 
                    className="book-details-title"
                    value={ attributes.title }
                    tagName="h3"
                />

                <RichText.Content 
                    className="book-details-author"
                    value={ attributes.author }
                    tagName="span"
                />

                <RichText.Content 
                    className="book-details-summary"
                    value={ attributes.summary }
                    tagName="div"
                    multiline="p"
                />
            </div>
        );
    }
} );