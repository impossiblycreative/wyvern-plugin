import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'wyvern-plugin/block-00-test', {
    title:      'Basic Example #0',
    icon:       'smiley',
    category:   'layout',
    edit:       () => <div>Hola, mundo!</div>,
    save:       () => <div>Hola, mundo!</div>,
} );