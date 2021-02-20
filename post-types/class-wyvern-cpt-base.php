<?php

class Wyvern_CPT {
	public $labels;
	public $settings;
	public $taxonomy_labels;
	public $taxonomy_settings;

	public function __construct() {
		$this->labels = array();
		$this->settings = array();
		$this->taxonomy_labels = array();
		$this->taxonomy_settings = array();
	}

	// Helper functions
	public function get_labels() {
		return $this->labels;
	}

	public function get_settings() {
		return $this->$settings;
	}

	public function get_taxonomy_labels() {
		return $this->taxonomy_labels;
	}

	public function get_taxonomy_settings() {
		return $this->taxonomy_settings;
	}

	// CPT functionality (must be overwritten in the child class)
	public function register_post_type(){}
	public function register_taxonomy(){}
	public function add_meta(){}
	public function display_meta( $post ){}
	public function save_meta( $post_ID ){}
}
