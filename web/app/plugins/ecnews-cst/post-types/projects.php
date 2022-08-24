<?php

/**
 * Registers the `projects` post type.
 */
function projects_init() {
	register_post_type(
		'projects',
		[
			'labels'                => [
				'name'                  => __( 'Projects', 'ecnews-cst' ),
				'singular_name'         => __( 'Projects', 'ecnews-cst' ),
				'all_items'             => __( 'All Projects', 'ecnews-cst' ),
				'archives'              => __( 'Projects Archives', 'ecnews-cst' ),
				'attributes'            => __( 'Projects Attributes', 'ecnews-cst' ),
				'insert_into_item'      => __( 'Insert into Projects', 'ecnews-cst' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Projects', 'ecnews-cst' ),
				'featured_image'        => _x( 'Featured Image', 'projects', 'ecnews-cst' ),
				'set_featured_image'    => _x( 'Set featured image', 'projects', 'ecnews-cst' ),
				'remove_featured_image' => _x( 'Remove featured image', 'projects', 'ecnews-cst' ),
				'use_featured_image'    => _x( 'Use as featured image', 'projects', 'ecnews-cst' ),
				'filter_items_list'     => __( 'Filter Projects list', 'ecnews-cst' ),
				'items_list_navigation' => __( 'Projects list navigation', 'ecnews-cst' ),
				'items_list'            => __( 'Projects list', 'ecnews-cst' ),
				'new_item'              => __( 'New Projects', 'ecnews-cst' ),
				'add_new'               => __( 'Add New', 'ecnews-cst' ),
				'add_new_item'          => __( 'Add New Projects', 'ecnews-cst' ),
				'edit_item'             => __( 'Edit Projects', 'ecnews-cst' ),
				'view_item'             => __( 'View Projects', 'ecnews-cst' ),
				'view_items'            => __( 'View Projects', 'ecnews-cst' ),
				'search_items'          => __( 'Search Projects', 'ecnews-cst' ),
				'not_found'             => __( 'No Projects found', 'ecnews-cst' ),
				'not_found_in_trash'    => __( 'No Projects found in trash', 'ecnews-cst' ),
				'parent_item_colon'     => __( 'Parent Projects:', 'ecnews-cst' ),
				'menu_name'             => __( 'Projects', 'ecnews-cst' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-welcome-widgets-menus',
			'show_in_rest'          => true,
			'rest_base'             => 'projects',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'projects_init' );

/**
 * Sets the post updated messages for the `projects` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `projects` post type.
 */
function projects_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['projects'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Projects updated. <a target="_blank" href="%s">View Projects</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ecnews-cst' ),
		3  => __( 'Custom field deleted.', 'ecnews-cst' ),
		4  => __( 'Projects updated.', 'ecnews-cst' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Projects restored to revision from %s', 'ecnews-cst' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Projects published. <a href="%s">View Projects</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		7  => __( 'Projects saved.', 'ecnews-cst' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Projects submitted. <a target="_blank" href="%s">Preview Projects</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Projects scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Projects</a>', 'ecnews-cst' ), date_i18n( __( 'M j, Y @ G:i', 'ecnews-cst' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Projects draft updated. <a target="_blank" href="%s">Preview Projects</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'projects_updated_messages' );

/**
 * Sets the bulk post updated messages for the `projects` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `projects` post type.
 */
function projects_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['projects'] = [
		/* translators: %s: Number of Projects. */
		'updated'   => _n( '%s Projects updated.', '%s Projects updated.', $bulk_counts['updated'], 'ecnews-cst' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Projects not updated, somebody is editing it.', 'ecnews-cst' ) :
						/* translators: %s: Number of Projects. */
						_n( '%s Projects not updated, somebody is editing it.', '%s Projects not updated, somebody is editing them.', $bulk_counts['locked'], 'ecnews-cst' ),
		/* translators: %s: Number of Projects. */
		'deleted'   => _n( '%s Projects permanently deleted.', '%s Projects permanently deleted.', $bulk_counts['deleted'], 'ecnews-cst' ),
		/* translators: %s: Number of Projects. */
		'trashed'   => _n( '%s Projects moved to the Trash.', '%s Projects moved to the Trash.', $bulk_counts['trashed'], 'ecnews-cst' ),
		/* translators: %s: Number of Projects. */
		'untrashed' => _n( '%s Projects restored from the Trash.', '%s Projects restored from the Trash.', $bulk_counts['untrashed'], 'ecnews-cst' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'projects_bulk_updated_messages', 10, 2 );
