<?php

namespace WPBerries;

class Settings {

	public function __construct() {
		add_action( 'init', array( $this, 'register_cpt' ) );
	}

	/**
	 * Registers the CPT for Berry tickets.
	 */
	public function register_cpt() {
		
		/**
		 * Post Type: Berry Tickets.
		 */

		$labels = array(
			'name'                     => __( ' Berry Tickets', 'wpberry' ),
			'singular_name'            => __( 'Ticket', 'wpberry' ),
			'menu_name'                => __( 'Berry Tickets', 'wpberry' ),
			'all_items'                => __( 'All Tickets', 'wpberry' ),
			'add_new'                  => __( 'Add new', 'wpberry' ),
			'add_new_item'             => __( 'Add new Ticket', 'wpberry' ),
			'edit_item'                => __( 'Edit Ticket', 'wpberry' ),
			'new_item'                 => __( 'New Ticket', 'wpberry' ),
			'view_item'                => __( 'View Ticket', 'wpberry' ),
			'view_items'               => __( 'View Tickets', 'wpberry' ),
			'search_items'             => __( 'Search Tickets', 'wpberry' ),
			'not_found'                => __( 'No Tickets found', 'wpberry' ),
			'not_found_in_trash'       => __( 'No Tickets found in trash', 'wpberry' ),
			'parent'                   => __( 'Parent Ticket:', 'wpberry' ),
			'featured_image'           => __( 'Featured image for this Ticket', 'wpberry' ),
			'set_featured_image'       => __( 'Set featured image for this Ticket', 'wpberry' ),
			'remove_featured_image'    => __( 'Remove featured image for this Ticket', 'wpberry' ),
			'use_featured_image'       => __( 'Use as featured image for this Ticket', 'wpberry' ),
			'archives'                 => __( 'Ticket archives', 'wpberry' ),
			'insert_into_item'         => __( 'Insert into Ticket', 'wpberry' ),
			'uploaded_to_this_item'    => __( 'Upload to this Ticket', 'wpberry' ),
			'filter_items_list'        => __( 'Filter Tickets list', 'wpberry' ),
			'items_list_navigation'    => __( 'Tickets list navigation', 'wpberry' ),
			'items_list'               => __( 'Tickets list', 'wpberry' ),
			'attributes'               => __( 'Tickets attributes', 'wpberry' ),
			'name_admin_bar'           => __( 'Ticket', 'wpberry' ),
			'item_published'           => __( 'Ticket published', 'wpberry' ),
			'item_published_privately' => __( 'Ticket published privately.', 'wpberry' ),
			'item_reverted_to_draft'   => __( 'Ticket reverted to draft.', 'wpberry' ),
			'item_scheduled'           => __( 'Ticket scheduled', 'wpberry' ),
			'item_updated'             => __( 'Ticket updated.', 'wpberry' ),
			'parent_item_colon'        => __( 'Parent Ticket:', 'wpberry' ),
		);

		$args = array(
			'label'                 => __( 'Tickets', 'wpberry' ),
			'labels'                => $labels,
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_rest'          => true,
			'rest_base'             => '',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'has_archive'           => false,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'delete_with_user'      => false,
			'exclude_from_search'   => false,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			'hierarchical'          => true,
			'rewrite'               => array(
				'slug'       => 'berry',
				'with_front' => true,
			),
			'query_var'             => true,
			'supports'              => array( 'title', 'editor', 'author' ),
			'taxonomies'            => array( 'category', 'post_tag' ),
			'show_in_graphql'       => false,
		);

		register_post_type( 'berry', $args );
	}
}

$settings_instance = new Settings();

