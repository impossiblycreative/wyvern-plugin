import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'wyvern-plugin/block-01-basic', {
    title:      'Basic Example #2',
    icon:       'smiley',
    category:   'layout',
    edit:       () => <div>Hello, World!</div>,
    save:       () => <div>Hello, World!</div>,
} );