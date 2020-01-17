import { registerBlockType } from '@wordpress/blocks';
import { RichText } from '@wordpress/block-editor';

registerBlockType( 'wyvern-plugin/block-03-attributes', {
    title:      'Block Example #3 - Adding Attributes',
    icon:       'smiley',
    category:   'layout',

    attributes: {
        content: {
            type:       'array',
            source:     'children',
            selector:   'p',
        },
    },

    example: {
        attributes: {
            content: 'Hello, World!',
        },
    },

    edit: ( props ) => {
        const { attributes: { content }, setAttributes, className } = props;
        const onChangeContent = ( newContent ) => {
            setAttributes( { content: newContent } );
        };

        return (
            <RichText
                tagName="p"
                className={ className }
                onChange={ onChangeContent }
                value={ content }
            />
        );
    },

    save: ( props ) => {
        return <RichText.Content tagName="p" value={ props.attributes.content } />;
    },
} );