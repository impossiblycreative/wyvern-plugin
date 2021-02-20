/**
 * BLOCK: Featured Posts Carousel
 * 
 * Displays a carousel of all posts with the 'featured' post meta flag
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls, RichText } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

registerBlockType( 'wyvern-plugin/newsletter' , {
    title:      __( 'Newsletter Signup', 'wyvern-plugin' ),
    icon:       icons.newsletter,
    category:   'wyvern-blocks',
    keywords:   [ __( 'news', 'wyvern-plugin' ), __( 'form', 'wyvern-plugin' ) ],

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
            <InspectorControls>
                <PanelBody
                    title={ __( 'Newsletter Signup Form', 'wyvern-plugin' ) }
                    initialOpen={ true }
                >
                    <TextControl
                        label={ __( 'Signup Form Name', 'wyvern-plugin' ) }
                        value={ attributes.formName }
                        onChange={ value => setAttributes( { formName: value } ) }
                    />
                </PanelBody>
            </InspectorControls>

                <div>
                    <RichText
                        className="newsletter-prompt"
                        value={ attributes.prompt }
                        onChange={ value => setAttributes( { prompt: value } ) }
                        tagName="p"
                        placeholder="Sign up for updates!"
                    />
                    <p>The selected form, { attributes.formName } , will display here.</p>
                </div>
            </div>
        );
    },

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );