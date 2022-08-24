<?php

/**
 * Registers the `guides` post type.
 */
function guides_init() {
	register_post_type(
		'guides',
		[
			'labels'                => [
				'name'                  => __( 'Guides', 'ecnews-cst' ),
				'singular_name'         => __( 'Guides', 'ecnews-cst' ),
				'all_items'             => __( 'All Guides', 'ecnews-cst' ),
				'archives'              => __( 'Guides Archives', 'ecnews-cst' ),
				'attributes'            => __( 'Guides Attributes', 'ecnews-cst' ),
				'insert_into_item'      => __( 'Insert into Guides', 'ecnews-cst' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Guides', 'ecnews-cst' ),
				'featured_image'        => _x( 'Featured Image', 'guides', 'ecnews-cst' ),
				'set_featured_image'    => _x( 'Set featured image', 'guides', 'ecnews-cst' ),
				'remove_featured_image' => _x( 'Remove featured image', 'guides', 'ecnews-cst' ),
				'use_featured_image'    => _x( 'Use as featured image', 'guides', 'ecnews-cst' ),
				'filter_items_list'     => __( 'Filter Guides list', 'ecnews-cst' ),
				'items_list_navigation' => __( 'Guides list navigation', 'ecnews-cst' ),
				'items_list'            => __( 'Guides list', 'ecnews-cst' ),
				'new_item'              => __( 'New Guides', 'ecnews-cst' ),
				'add_new'               => __( 'Add New', 'ecnews-cst' ),
				'add_new_item'          => __( 'Add New Guides', 'ecnews-cst' ),
				'edit_item'             => __( 'Edit Guides', 'ecnews-cst' ),
				'view_item'             => __( 'View Guides', 'ecnews-cst' ),
				'view_items'            => __( 'View Guides', 'ecnews-cst' ),
				'search_items'          => __( 'Search Guides', 'ecnews-cst' ),
				'not_found'             => __( 'No Guides found', 'ecnews-cst' ),
				'not_found_in_trash'    => __( 'No Guides found in trash', 'ecnews-cst' ),
				'parent_item_colon'     => __( 'Parent Guides:', 'ecnews-cst' ),
				'menu_name'             => __( 'Guides', 'ecnews-cst' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 6,
			'menu_icon'             => 'dashicons-clipboard',
			'show_in_rest'          => true,
			'rest_base'             => 'guides',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'guides_init' );

/**
 * Sets the post updated messages for the `guides` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `guides` post type.
 */
function guides_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['guides'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Guides updated. <a target="_blank" href="%s">View Guides</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ecnews-cst' ),
		3  => __( 'Custom field deleted.', 'ecnews-cst' ),
		4  => __( 'Guides updated.', 'ecnews-cst' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Guides restored to revision from %s', 'ecnews-cst' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Guides published. <a href="%s">View Guides</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		7  => __( 'Guides saved.', 'ecnews-cst' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Guides submitted. <a target="_blank" href="%s">Preview Guides</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Guides scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Guides</a>', 'ecnews-cst' ), date_i18n( __( 'M j, Y @ G:i', 'ecnews-cst' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Guides draft updated. <a target="_blank" href="%s">Preview Guides</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'guides_updated_messages' );

/**
 * Sets the bulk post updated messages for the `guides` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `guides` post type.
 */
function guides_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['guides'] = [
		/* translators: %s: Number of Guides. */
		'updated'   => _n( '%s Guides updated.', '%s Guides updated.', $bulk_counts['updated'], 'ecnews-cst' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Guides not updated, somebody is editing it.', 'ecnews-cst' ) :
						/* translators: %s: Number of Guides. */
						_n( '%s Guides not updated, somebody is editing it.', '%s Guides not updated, somebody is editing them.', $bulk_counts['locked'], 'ecnews-cst' ),
		/* translators: %s: Number of Guides. */
		'deleted'   => _n( '%s Guides permanently deleted.', '%s Guides permanently deleted.', $bulk_counts['deleted'], 'ecnews-cst' ),
		/* translators: %s: Number of Guides. */
		'trashed'   => _n( '%s Guides moved to the Trash.', '%s Guides moved to the Trash.', $bulk_counts['trashed'], 'ecnews-cst' ),
		/* translators: %s: Number of Guides. */
		'untrashed' => _n( '%s Guides restored from the Trash.', '%s Guides restored from the Trash.', $bulk_counts['untrashed'], 'ecnews-cst' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'guides_bulk_updated_messages', 10, 2 );
