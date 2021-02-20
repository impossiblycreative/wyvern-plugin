import { __ } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { registerPlugin } from '@wordpress/plugins';
import { PanelBody, ToggleControl, TextControl } from '@wordpress/components';
import { withSelect, withDispatch } from "@wordpress/data";

// Our initial component
let WyvernPostMeta = ( props ) => {
    const { featurePost, featuredVideo } = props;

    return (
        <>
            <PanelBody
                title={ __( 'Featured the Post?', 'wyvern-plugin' ) }
                initialOpen={ true }
            >
                <ToggleControl
                    label={ __( 'Feature the post?', 'wyvern-plugin' ) }
                    help={ featurePost ? __( 'The post will be featured.', 'wyvern-plugin' ) : __( 'The post will NOT be featured.', 'wyvern-plugin' ) }
                    checked={ featurePost }
                    onChange={ value => props.updateFeaturePost( value ) }
                />
            </PanelBody>

            <PanelBody
                title={ __( 'Featured Video', 'wyvern-plugin' ) }
                initialOpen={ true }
            >
                <TextControl
                    label="Featured Video URL"
                    value={ featuredVideo }
                    onChange={ value => props.updateFeaturedVideo( value ) }
                />
            </PanelBody>
        </>
    )
}

// Grab our field data
WyvernPostMeta = withSelect(
    ( select ) => {
        return {
            featurePost: select( 'core/editor' ).getEditedPostAttribute( 'meta' )['feature_post'],
            featuredVideo: select( 'core/editor' ).getEditedPostAttribute( 'meta' )['featured_video'],
        }
    }
)( WyvernPostMeta );

// Save our data
WyvernPostMeta = withDispatch(
    ( dispatch ) => ( {
        updateFeaturePost( value ){
            dispatch( 'core/editor' ).editPost( { meta: { feature_post: value } } )
        },
        updateFeaturedVideo( value ){
            dispatch( 'core/editor' ).editPost( { meta: { featured_video: value } } )
        },
    } )
)( WyvernPostMeta );

// Register the plugin
registerPlugin( 'wyvern-plugin-post-meta', {
    render: () => {
        return (
            <PluginDocumentSettingPanel
                name="fx-group-post-meta-panel"
                title={ __( 'Additional Post Information', 'wyvern-plugin' ) }
                className="wyvern-plugin-post-meta"
            >
                <WyvernPostMeta/>
            </PluginDocumentSettingPanel>
        );
    }
} );