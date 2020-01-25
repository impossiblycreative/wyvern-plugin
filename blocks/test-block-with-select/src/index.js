/**
 * BLOCK: Test Block - With Select
 * 
 * A demo block that uses withSelect to gather data from the WordPress REST API.
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { withSelect } from '@wordpress/data';
import { Spinner } from '@wordpress/components';
import { RichText } from '@wordpress/editor';

registerBlockType( 'wyvern-plugin/test-block-with-select' , {
    title:      __( 'Test Block - withSelect', 'wyvern-plugin' ),
    icon:       icons.testBlockWithSelect,
    category:   'wyvern-plugin-blocks',
    keywords:   [ __( 'Test', 'wyvern-plugin' ), __( 'Dynamic', 'wyvern-plugin' ) ],

    // Support flags
    supports: {
        alignWide:          true,
        anchor:             true,
        customClassName:    true,
        html:               false, // Turn off by default
    },

    // Editor view
    edit: withSelect( select => {
        return {
            posts: select( 'core' ).getEntityRecords( 'postType', 'post', { per_page: 3 } )
        };
    } )( ( { posts, className, attributes, setAttributes } ) => {
        // Output during loading
        if ( !posts ) {
            return <p className={ className }>
                <Spinner />
                { __( 'Loading...', 'wyvern-plugin' ) }
            </p>;
        }

        // Output for no posts found
        if ( 0 === posts.length ) {
            return <p>{ __( 'No posts found.', 'wyvern-plugin' ) }</p>;
        }

        // Normal output
        return <div className={ className }>
            <RichText
                tagName="h2"
                value={ attributes.listTitle }
                onChange={ value => setAttributes( { listTitle: value } ) }
                placeholder={ __( 'Enter a title for the block...', 'wyvern-plugin' ) }
            />

            <ul>
                { posts.map( post => {
                    return (
                        <li>
                            <a className={ className } href={ post.link }>{ post.title.rendered }</a>
                        </li>
                    );
                } ) }
            </ul>
        </div>;
    } ),

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );