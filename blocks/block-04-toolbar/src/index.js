import { registerBlockType } from '@wordpress/blocks';

import {
    RichText,
    AlignmentToolbar,
    BlockControls,
    InspectorControls
} from '@wordpress/block-editor';

registerBlockType( 'wyern-plugin/block-04-toolbar', {
    title:      'Block Example #4 - Adding a toolbar',
    icon:       'smiley',
    category:   'layout',

    attributes: {
        content: {
            type:       'array',
            source:     'children',
            selector:   'p',
        },
        alignment: {
            type:       'string',
            default:    'none',
        },
    },

    example: {
        attributes: {
            content: 'Hello, World!',
            alignment: 'right',
        },
    },

    edit: ( props ) => {
        const {
            attributes: {
                content,
                alignment,
            },
            className,
        } = props;

        const onChangeContent = ( newContent ) => {
            props.setAttributes( { content: newContent } );
        };

        const onChangeAlignment = ( newAlignment ) => {
            props.setAttributes( { alignment: newAlignment === undefined ? 'none' : newAlignment } );
        };

        return (
            <div>
                {
                    <BlockControls>
                        <AlignmentToolbar
                            value={ alignment }
                            onChange={ onChangeAlignment }
                        />
                    </BlockControls>
                }
                <RichText
                    className={ className }
                    style={ { textAlign: alignment } }
                    tagName="p"
                    onChange={ onChangeContent }
                    value={ content }
                />
            </div>
        );
    },

    save: ( props ) => {
        return(
            <RichText.Content
                className={ `block-04-toolbar-align-${ props.attributes.alignment }` }
                tagName="p"
                value={ props.attributes.content }
            />
        );
    },
} );