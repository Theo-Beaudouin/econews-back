<?php

/**
 * Registers the `topics` taxonomy,
 * for use with 'guides', 'investigations', 'news', 'studies'.
 */
function topics_init() {
	register_taxonomy( 'topics', [ 'guides', 'investigations', 'news', 'studies', 'projects' ], [
		'hierarchical'          => false,
		'public'                => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => true,
		'capabilities'          => [
			'manage_terms' => 'edit_posts',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		],
		'labels'                => [
			'name'                       => __( 'Topics', 'ecnews-cst' ),
			'singular_name'              => _x( 'Topics', 'taxonomy general name', 'ecnews-cst' ),
			'search_items'               => __( 'Search Topics', 'ecnews-cst' ),
			'popular_items'              => __( 'Popular Topics', 'ecnews-cst' ),
			'all_items'                  => __( 'All Topics', 'ecnews-cst' ),
			'parent_item'                => __( 'Parent Topics', 'ecnews-cst' ),
			'parent_item_colon'          => __( 'Parent Topics:', 'ecnews-cst' ),
			'edit_item'                  => __( 'Edit Topics', 'ecnews-cst' ),
			'update_item'                => __( 'Update Topics', 'ecnews-cst' ),
			'view_item'                  => __( 'View Topics', 'ecnews-cst' ),
			'add_new_item'               => __( 'Add New Topics', 'ecnews-cst' ),
			'new_item_name'              => __( 'New Topics', 'ecnews-cst' ),
			'separate_items_with_commas' => __( 'Separate Topics with commas', 'ecnews-cst' ),
			'add_or_remove_items'        => __( 'Add or remove Topics', 'ecnews-cst' ),
			'choose_from_most_used'      => __( 'Choose from the most used Topics', 'ecnews-cst' ),
			'not_found'                  => __( 'No Topics found.', 'ecnews-cst' ),
			'no_terms'                   => __( 'No Topics', 'ecnews-cst' ),
			'menu_name'                  => __( 'Topics', 'ecnews-cst' ),
			'items_list_navigation'      => __( 'Topics list navigation', 'ecnews-cst' ),
			'items_list'                 => __( 'Topics list', 'ecnews-cst' ),
			'most_used'                  => _x( 'Most Used', 'topics', 'ecnews-cst' ),
			'back_to_items'              => __( '&larr; Back to Topics', 'ecnews-cst' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'topics',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );

}

add_action( 'init', 'topics_init' );

/**
 * Sets the post updated messages for the `topics` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `topics` taxonomy.
 */
function topics_updated_messages( $messages ) {

	$messages['topics'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Topics added.', 'ecnews-cst' ),
		2 => __( 'Topics deleted.', 'ecnews-cst' ),
		3 => __( 'Topics updated.', 'ecnews-cst' ),
		4 => __( 'Topics not added.', 'ecnews-cst' ),
		5 => __( 'Topics not updated.', 'ecnews-cst' ),
		6 => __( 'Topics deleted.', 'ecnews-cst' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'topics_updated_messages' );
