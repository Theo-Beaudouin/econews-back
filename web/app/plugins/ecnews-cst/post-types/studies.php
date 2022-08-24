<?php

/**
 * Registers the `studies` post type.
 */
function studies_init() {
	register_post_type(
		'studies',
		[
			'labels'                => [
				'name'                  => __( 'Studies', 'ecnews-cst' ),
				'singular_name'         => __( 'Studies', 'ecnews-cst' ),
				'all_items'             => __( 'All Studies', 'ecnews-cst' ),
				'archives'              => __( 'Studies Archives', 'ecnews-cst' ),
				'attributes'            => __( 'Studies Attributes', 'ecnews-cst' ),
				'insert_into_item'      => __( 'Insert into Studies', 'ecnews-cst' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Studies', 'ecnews-cst' ),
				'featured_image'        => _x( 'Featured Image', 'studies', 'ecnews-cst' ),
				'set_featured_image'    => _x( 'Set featured image', 'studies', 'ecnews-cst' ),
				'remove_featured_image' => _x( 'Remove featured image', 'studies', 'ecnews-cst' ),
				'use_featured_image'    => _x( 'Use as featured image', 'studies', 'ecnews-cst' ),
				'filter_items_list'     => __( 'Filter Studies list', 'ecnews-cst' ),
				'items_list_navigation' => __( 'Studies list navigation', 'ecnews-cst' ),
				'items_list'            => __( 'Studies list', 'ecnews-cst' ),
				'new_item'              => __( 'New Studies', 'ecnews-cst' ),
				'add_new'               => __( 'Add New', 'ecnews-cst' ),
				'add_new_item'          => __( 'Add New Studies', 'ecnews-cst' ),
				'edit_item'             => __( 'Edit Studies', 'ecnews-cst' ),
				'view_item'             => __( 'View Studies', 'ecnews-cst' ),
				'view_items'            => __( 'View Studies', 'ecnews-cst' ),
				'search_items'          => __( 'Search Studies', 'ecnews-cst' ),
				'not_found'             => __( 'No Studies found', 'ecnews-cst' ),
				'not_found_in_trash'    => __( 'No Studies found in trash', 'ecnews-cst' ),
				'parent_item_colon'     => __( 'Parent Studies:', 'ecnews-cst' ),
				'menu_name'             => __( 'Studies', 'ecnews-cst' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 9,
			'menu_icon'             => 'dashicons-welcome-learn-more',
			'show_in_rest'          => true,
			'rest_base'             => 'studies',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'studies_init' );

/**
 * Sets the post updated messages for the `studies` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `studies` post type.
 */
function studies_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['studies'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Studies updated. <a target="_blank" href="%s">View Studies</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ecnews-cst' ),
		3  => __( 'Custom field deleted.', 'ecnews-cst' ),
		4  => __( 'Studies updated.', 'ecnews-cst' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Studies restored to revision from %s', 'ecnews-cst' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Studies published. <a href="%s">View Studies</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		7  => __( 'Studies saved.', 'ecnews-cst' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Studies submitted. <a target="_blank" href="%s">Preview Studies</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Studies scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Studies</a>', 'ecnews-cst' ), date_i18n( __( 'M j, Y @ G:i', 'ecnews-cst' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Studies draft updated. <a target="_blank" href="%s">Preview Studies</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'studies_updated_messages' );

/**
 * Sets the bulk post updated messages for the `studies` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `studies` post type.
 */
function studies_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['studies'] = [
		/* translators: %s: Number of Studies. */
		'updated'   => _n( '%s Studies updated.', '%s Studies updated.', $bulk_counts['updated'], 'ecnews-cst' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Studies not updated, somebody is editing it.', 'ecnews-cst' ) :
						/* translators: %s: Number of Studies. */
						_n( '%s Studies not updated, somebody is editing it.', '%s Studies not updated, somebody is editing them.', $bulk_counts['locked'], 'ecnews-cst' ),
		/* translators: %s: Number of Studies. */
		'deleted'   => _n( '%s Studies permanently deleted.', '%s Studies permanently deleted.', $bulk_counts['deleted'], 'ecnews-cst' ),
		/* translators: %s: Number of Studies. */
		'trashed'   => _n( '%s Studies moved to the Trash.', '%s Studies moved to the Trash.', $bulk_counts['trashed'], 'ecnews-cst' ),
		/* translators: %s: Number of Studies. */
		'untrashed' => _n( '%s Studies restored from the Trash.', '%s Studies restored from the Trash.', $bulk_counts['untrashed'], 'ecnews-cst' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'studies_bulk_updated_messages', 10, 2 );
