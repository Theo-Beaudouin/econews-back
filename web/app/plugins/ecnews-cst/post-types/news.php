<?php

/**
 * Registers the `news` post type.
 */
function news_init() {
	register_post_type(
		'news',
		[
			'labels'                => [
				'name'                  => __( 'News', 'ecnews-cst' ),
				'singular_name'         => __( 'News', 'ecnews-cst' ),
				'all_items'             => __( 'All News', 'ecnews-cst' ),
				'archives'              => __( 'News Archives', 'ecnews-cst' ),
				'attributes'            => __( 'News Attributes', 'ecnews-cst' ),
				'insert_into_item'      => __( 'Insert into News', 'ecnews-cst' ),
				'uploaded_to_this_item' => __( 'Uploaded to this News', 'ecnews-cst' ),
				'featured_image'        => _x( 'Featured Image', 'news', 'ecnews-cst' ),
				'set_featured_image'    => _x( 'Set featured image', 'news', 'ecnews-cst' ),
				'remove_featured_image' => _x( 'Remove featured image', 'news', 'ecnews-cst' ),
				'use_featured_image'    => _x( 'Use as featured image', 'news', 'ecnews-cst' ),
				'filter_items_list'     => __( 'Filter News list', 'ecnews-cst' ),
				'items_list_navigation' => __( 'News list navigation', 'ecnews-cst' ),
				'items_list'            => __( 'News list', 'ecnews-cst' ),
				'new_item'              => __( 'New News', 'ecnews-cst' ),
				'add_new'               => __( 'Add New', 'ecnews-cst' ),
				'add_new_item'          => __( 'Add New News', 'ecnews-cst' ),
				'edit_item'             => __( 'Edit News', 'ecnews-cst' ),
				'view_item'             => __( 'View News', 'ecnews-cst' ),
				'view_items'            => __( 'View News', 'ecnews-cst' ),
				'search_items'          => __( 'Search News', 'ecnews-cst' ),
				'not_found'             => __( 'No News found', 'ecnews-cst' ),
				'not_found_in_trash'    => __( 'No News found in trash', 'ecnews-cst' ),
				'parent_item_colon'     => __( 'Parent News:', 'ecnews-cst' ),
				'menu_name'             => __( 'News', 'ecnews-cst' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => 8,
			'menu_icon'             => 'dashicons-tagcloud',
			'show_in_rest'          => true,
			'rest_base'             => 'news',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'news_init' );

/**
 * Sets the post updated messages for the `news` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `news` post type.
 */
function news_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['news'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'News updated. <a target="_blank" href="%s">View News</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ecnews-cst' ),
		3  => __( 'Custom field deleted.', 'ecnews-cst' ),
		4  => __( 'News updated.', 'ecnews-cst' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'News restored to revision from %s', 'ecnews-cst' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'News published. <a href="%s">View News</a>', 'ecnews-cst' ), esc_url( $permalink ) ),
		7  => __( 'News saved.', 'ecnews-cst' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'News submitted. <a target="_blank" href="%s">Preview News</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'News scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview News</a>', 'ecnews-cst' ), date_i18n( __( 'M j, Y @ G:i', 'ecnews-cst' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'News draft updated. <a target="_blank" href="%s">Preview News</a>', 'ecnews-cst' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'news_updated_messages' );

/**
 * Sets the bulk post updated messages for the `news` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `news` post type.
 */
function news_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['news'] = [
		/* translators: %s: Number of News. */
		'updated'   => _n( '%s News updated.', '%s News updated.', $bulk_counts['updated'], 'ecnews-cst' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 News not updated, somebody is editing it.', 'ecnews-cst' ) :
						/* translators: %s: Number of News. */
						_n( '%s News not updated, somebody is editing it.', '%s News not updated, somebody is editing them.', $bulk_counts['locked'], 'ecnews-cst' ),
		/* translators: %s: Number of News. */
		'deleted'   => _n( '%s News permanently deleted.', '%s News permanently deleted.', $bulk_counts['deleted'], 'ecnews-cst' ),
		/* translators: %s: Number of News. */
		'trashed'   => _n( '%s News moved to the Trash.', '%s News moved to the Trash.', $bulk_counts['trashed'], 'ecnews-cst' ),
		/* translators: %s: Number of News. */
		'untrashed' => _n( '%s News restored from the Trash.', '%s News restored from the Trash.', $bulk_counts['untrashed'], 'ecnews-cst' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'news_bulk_updated_messages', 10, 2 );
