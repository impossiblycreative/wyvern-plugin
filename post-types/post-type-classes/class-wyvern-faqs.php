<?php

class Wyvern_FAQs extends Wyvern_CPT {
    public function __construct() {

		$this->labels = array(
	        'name' 			=> 'FAQs',
			'singular_name'	=> 'FAQ',
			'add_new_item'	=> 'Add New FAQ',
			'new_item'		=> 'New FAQ',
			'edit_item'		=> 'Edit FAQ',
			'view_item'		=> 'View FAQ',
			'view_items'	=> 'View FAQs',
		);

		$this->settings = array(
	        'labels'		=> $this->labels,
	        'supports'		=> array( 'title', 'editor', 'page-attributes' ),
	        'public' 		=> true,
			'has_archive' 	=> false,
			'show_in_rest'	=> true,
	        'menu_icon' 	=> 'data:image/svg+xml;base64,' . base64_encode( '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="question-square" class="svg-inline--fa fa-question-square fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M400 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 430c-25.365 0-46-20.636-46-46 0-25.365 20.635-46 46-46s46 20.635 46 46c0 25.364-20.635 46-46 46zm40-131.333V300c0 6.627-5.373 12-12 12h-56c-6.627 0-12-5.373-12-12v-4c0-41.059 31.128-57.472 54.652-70.66 20.171-11.309 32.534-19 32.534-33.976 0-19.81-25.269-32.958-45.698-32.958-27.19 0-39.438 13.139-57.303 35.797-4.045 5.13-11.46 6.069-16.665 2.122l-34.699-26.31c-5.068-3.843-6.251-10.972-2.715-16.258C141.4 112.957 176.158 90 230.655 90c56.366 0 116.531 43.998 116.531 102 0 77.02-83.186 78.205-83.186 106.667z"></path></svg>' ),
	        'rewrite' 		=> array( 'slug' => 'faqs' ),
	    );

	    $this->taxonomy_labels = array(
			'name'			=> 'FAQ Categories',
			'singular_name'	=> 'FAQ Category',
			'menu_name'		=> 'FAQ Categories',
			'add_new_item'	=> 'Add New FAQ Category',
			'new_item'		=> 'New FAQ Category',
			'edit_item'		=> 'Edit FAQ Category',
			'view_item'		=> 'View FAQ Category',
			'view_items'	=> 'View FAQ Categories',
		);

		$this->taxonomy_settings = array(
			'hierarchical'		=> false,
			'orderby' 			=> 'term_order',
			'public'			=> true,
			'labels'			=> $this->taxonomy_labels,
			'show_ui'           => true,
			'show_in_menu'		=> true,
			'show_admin_column'	=> true,
			'show_in_rest'		=> true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'faq-categories' ),
		);
    }

	public function register_post_type() {
		register_post_type( 'wyvern_faqs', $this->settings );
	}

	public function register_taxonomy() {
		register_taxonomy( 'wyvern_faq_categories', 'wyvern_faqs', $this->taxonomy_settings );
		register_taxonomy_for_object_type( 'wyvern_faq_categories', 'wyvern_faqs' );
	}
}