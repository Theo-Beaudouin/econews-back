<?php

/*
 * Add a Formatted Date to the WordPress REST API JSON Post Object
 * https://adambalee.com/?p=1547
 * 'add_action()' = Adds a callback function to an action hook.
 * I like to see action hooks like lifecycles hooks in Vue.
 * The action hook I used is 'rest_api_init', which occures when the Wordpress Core
 * is preparing to serve a REST API request.
 * And then, I associate a callback that will be ran when the Wordpress Core
 * reaches a specific point during its execution.
 */
add_action('rest_api_init', function() {
    //! 'register_rest_field()' = Creates a new field on an existing Wordpress Object type.
    //! register_rest_field( string|array $object_type, string $attribute, $args = array() )
    // '$object_type' = Object in which the field will be registered.
        // Here it's 'post'.
    // '$attribute' = Name of the new attribute to register.
        // In my case, it will be 'formatted_date'.
    // '$args' = Array of arguments used to handle the registered field.
        // 'get_callback' = The callback function used to retrieve the field value.
        // 'update_callback' = The callback function used to set and update the field value.
        // 'schema' = The schema for this field.
    register_rest_field(
        'post',
        'formatted_date',
        array(
            'get_callback'    => function() {
                return get_the_date();
            },
            'update_callback' => null,
            'schema'          => null,
        )
    );
});

// Remove HTML tags from API response data
//! 'remove_filter()' = Removes a callback function from a filter hook
//! 'remove_filter( string $hook_name, callable|string|array $callback, int $priority = 10)'
// '$hook_name' = The filter hook to which the function to be removed is hooked
    // Here, I want to get rid of the HTML tags of the title and the excerpt of posts.
// '$callback' = The callback to be removed from running when the filter is applied
    // Here, it's 'wpautop' which is a group of regex used to identify text and format it.
    // https://developer.wordpress.org/reference/functions/wpautop/
remove_filter('the_title', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

?>