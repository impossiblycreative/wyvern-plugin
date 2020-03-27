/**
 * BLOCK: FAQs container
 * 
 * Displays a series of FAQs based on a selected category
 */

import icons from '../../assets/icons';
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { withSelect } from '@wordpress/data';
import { PanelBody, SelectControl, Spinner } from '@wordpress/components';

registerBlockType( 'wyvern-plugin/faqs' , {
    title:      __( 'FAQs', 'wyvern-plugin' ),
    icon:       icons.faqs,
    category:   'wyvern-blocks',
    keywords:   [ __( 'FAQs', 'wyvern-plugin' ) ],

    // Support flags
    supports: {
        alignWide:          true,
        customClassName:    true,
        html:               false, // Turn off by default
    },

    // Override the alignment
    getEditWrapperProps( attributes ) {
        return { 'data-align': 'full' };
    },

    // Editor view
    edit: withSelect( ( select, props ) => {
        const { attributes } = props;
        let { faqCategory } = attributes;

        // Pull ALL the FAQs if no category is set
        if ( parseInt( faqCategory ) === 0 ) {
            faqCategory = '';
        }

        return {
            faqCategories:          select( 'core' ).getEntityRecords( 'taxonomy', 'wyvern_faq_categories', { per_page: -1 } ),
            selectedCategoryData:   select( 'core' ).getEntityRecords( 'postType', 'wyvern_faqs', { per_page: -1, wyvern_faq_categories: faqCategory } )
        };
    } )( ( props ) => {
        const { attributes, className, setAttributes, faqCategories, selectedCategoryData } = props;
        const { faqCategory } = attributes;

        const getFAQCategories = () => {
            const options = faqCategories.map( category => { 
                var option = {};
                option.label = category.name;
                option.value = category.id;

                return option;
            } );

            // Add default option
            const defaultOption = { label: 'Display all FAQ Categories', value: 0 };
            options.unshift( defaultOption );

            return options;
        };

        // Wait patiently...
        if ( !faqCategories ) {
            return (
                <p className="results">
                    <Spinner />
                    { __( 'Loading...', 'wyvern-plugin' ) }
                </p>
            );
        }

        // Bail if nothing is found
        if ( 0 === faqCategories.length ) {
            return ( <p className="results">{ __( 'No FAQ Categories found.', 'wyvern-plugin' ) }</p> );
        }

        if ( !selectedCategoryData ) {
            return (
                <p className="results">
                    <Spinner />
                    { __( 'Loading...', 'wyvern-plugin' ) }
                </p>
            );
        }

        // Bail if nothing is found
        if ( 0 === selectedCategoryData.length ) {
            return ( <p className="results">{ __( 'No FAQs found.', 'wyvern-plugin' ) }</p> );
        }

        console.log(selectedCategoryData);

        return (
            <div className={ 'alignfull ' + className }>
                <InspectorControls>
                    <PanelBody
                        title={ __( 'Select a FAQ Category', 'wyvern-plugin' ) }
                        initialOpen={ true }
                    >              
                        <SelectControl
                            label={ __( 'Selected FAQ Category', 'wyvern-plugin' ) }
                            value={ faqCategory }
                            options={ getFAQCategories() }
                            onChange={ value => setAttributes( { faqCategory: value } ) }
                        />
                    </PanelBody>
                </InspectorControls>

                <div id={ 'faqs-' + Math.floor( Math.random() * 100 ) } className="faqs-container accordion-container">
                    <h2 class="faqs-block-header">{ __( 'Frequently Asked Questions', 'wyvern-plugin' ) }</h2>

                    { selectedCategoryData.map( ( value, index ) => {
                        return (
                            <div id={ 'faq-' + index } className="faq">
                                <h3 id={ 'faq-' + index + '-header' } className="faq-header accordion-header">
                                    <button className="accordion-trigger">
                                        <span className="faq-header-text">{ value.title.rendered }</span>
                                        <span className="fas fa-plus"></span>
                                    </button>
                                </h3>
                                <div id={ 'faq-' + index + '-content' } class="faq-content accordion-panel" role="region" dangerouslySetInnerHTML={ {__html: value.content.rendered } }></div>
                            </div>
                        )
                    } ) }
                </div>
            </div>
        );
    } ),

    // Frontend Output - Use 'return null' to make block dynamic
    save: ( props ) => { return null; }
} );