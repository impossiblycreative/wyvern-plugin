/**
 * BLOCK: Test Block - Media Uploader
 * 
 * A demo block that uses the Media Uploader component.
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { RichText, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';

registerBlockType( 'wyvern-plugin/test-block-media-uploader' , {
    title:      __( 'Test Block - Media Uploader', 'wyvern-plugin' ),
    icon:       icons.testBlockMediaUploader,
    category:   'wyvern-plugin-blocks',
    keywords:   [ __( 'Test', 'wyvern-plugin' ), __( 'Media', 'wyvern-plugin' ) ],

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
            default:    'wp-block-wyvern-plugin-test-block-dynamic',
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

        image: {
            type:       'object',
            selector:   'js-book-details-image'
        }
    },

    // Editor view
    edit: ( props ) => {
        const { attributes, className, setAttributes } = props;
        const { image } = attributes; // Makes accessing the image easier

        return (
            <div className={ className }>
                <MediaUploadCheck>
                    <MediaUpload
                        className="js-book-details-image wp-admin-book-details-image"
                        allowedTypes={ ['image'] }
                        multiple={ false }
                        value={ image ? image.id : '' }
                        onSelect={ image => setAttributes( { image: image } ) }
                        render={ ( { open } ) => (
                            image 
                                ? 
                                    <div>
                                        <p>
                                            <img src={ image.url } width={ image.width / 2 }/>
                                        </p>
                                    </div>
                                :
                                    <Button onClick={ open } className="button">{ __( 'Upload Image', 'wyvern-plugin' ) }</Button>
                        ) }
                    />
                </MediaUploadCheck>

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
    save: ( props ) => { return null; }
} );