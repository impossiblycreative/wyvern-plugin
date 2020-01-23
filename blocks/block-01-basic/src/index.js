import { registerBlockType } from '@wordpress/blocks';

const blockStyle = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
};

registerBlockType( 'wyvern-plugin/block-01-basic', {
    title:      'Block Example #1',
    icon:       'smiley',
    category:   'layout',
    edit:       ( props ) => <div style={ blockStyle }>Hello, World!</div>,
    save:       ( props ) => { return null },
} );