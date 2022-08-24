<?php

/**
 * Registers the `investigations` post type.
 */
function investigations_init() {
	register_post_type(
		'investigations',
		[
			'labels'                => [
				'name'                  => __( 'Investigations', 'ecnews-cst' ),
				'singular_name'         => __( 'Investigations', 'ecnews-cst' ),
				'all_items'             => __( 'All Investigations', 'ecnews-cst' ),
				'archives'              => __( 'Investigations Archives', 'ecnews-cst' ),
				'attributes'            => __( 'Investigations Attributes', 'ecnews-cst' ),
				'insert_into_item'      => __( 'Insert into Investigations', 'ecnews-cst' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Investigations', 'ecnews-cst' ),
				'featured_image'        => _x( 'Featured Image', 'investigations', 'ecnews-cst' ),
				'set_featured_image'    => _x( 'Set featured image', 'investigations', 'ecnews-cst' ),
				'remove_featured_image' => _x( 'Remove featured image', 'investigations', 'ecnews-cst' ),
				'use_featured_image'    => _x( 'Use as featured image', 'investigations', 'ecnews-cst' ),
				'filter_items_list'     => __( 'Filter Investigations list', 'ecnews-cst' ),
				'items_list_navigation' => __( 'Investigations list navigation', 'ecnews-cst' ),
				'items_list'            => __( 'Investigations list', 'ecnews-cst' ),
				'new_item'              => __( 'New Investigations', 'ecnews-cst' ),
				'add_new'               => __( 'Add New', 'ecnews-cst' ),
				'add_new_item'          => __( 'Add New Investigations', 'ecnews-cst' ),
				'edit_item'             => __( 'Edit Investigations', 'ecnews-cst' ),
				'view_item'             => __( 'View Investigations', 'ecnews-cst' ),
				'view_items'            => __( 'View Investigations', 'ecnews-cst' ),
				'search_items'          => __( 'Search Investigations', 'ecnews-cst' ),
				'not_found'             => __( 'No Investigations found', 'ecnews-cst' ),
				'not_found_in_trash'    => __( 'No Investigations found in trash', 'ecnews-cst' ),
				'parent_item_colon'     => __( 'Parent Investigations:', 'ecnews-cst' ),
				'menu_name'             => __( 'Investigations', 'ecnews-cst' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 7,
			'menu_icon'             => 'dashicons-search',
			'show_in_rest'          => true,
			'rest_base'             => 'investigations',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'investigations_init' );

/**
 * Sets the post updated messages for the `investigations` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `investigations` post type.
 */
function investigations_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['investigations'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Investigations updated. <a target="_blank" href="%s">View Investigations</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ecnews-cst' ),
		3  => __( 'Custom field deleted.', 'ecnews-cst' ),
		4  => __( 'Investigations updated.', 'ecnews-cst' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Investigations restored to revision from %s', 'ecnews-cst' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Investigations published. <a href="%s">View Investigations</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		7  => __( 'Investigations saved.', 'ecnews-cst' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Investigations submitted. <a target="_blank" href="%s">Preview Investigations</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Investigations scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Investigations</a>', 'ecnews-cst' ), date_i18n( __( 'M j, Y @ G:i', 'ecnews-cst' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Investigations draft updated. <a target="_blank" href="%s">Preview Investigations</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'investigations_updated_messages' );

/**
 * Sets the bulk post updated messages for the `investigations` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `investigations` post type.
 */
function investigations_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['investigations'] = [
		/* translators: %s: Number of Investigations. */
		'updated'   => _n( '%s Investigations updated.', '%s Investigations updated.', $bulk_counts['updated'], 'ecnews-cst' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Investigations not updated, somebody is editing it.', 'ecnews-cst' ) :
						/* translators: %s: Number of Investigations. */
						_n( '%s Investigations not updated, somebody is editing it.', '%s Investigations not updated, somebody is editing them.', $bulk_counts['locked'], 'ecnews-cst' ),
		/* translators: %s: Number of Investigations. */
		'deleted'   => _n( '%s Investigations permanently deleted.', '%s Investigations permanently deleted.', $bulk_counts['deleted'], 'ecnews-cst' ),
		/* translators: %s: Number of Investigations. */
		'trashed'   => _n( '%s Investigations moved to the Trash.', '%s Investigations moved to the Trash.', $bulk_counts['trashed'], 'ecnews-cst' ),
		/* translators: %s: Number of Investigations. */
		'untrashed' => _n( '%s Investigations restored from the Trash.', '%s Investigations restored from the Trash.', $bulk_counts['untrashed'], 'ecnews-cst' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'investigations_bulk_updated_messages', 10, 2 );
