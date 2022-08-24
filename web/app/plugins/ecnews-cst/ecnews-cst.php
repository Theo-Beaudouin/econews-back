<?php
/**
 * Plugin Name: Ecnews-custom
 * Version: 0.1
 */

/* Custom Post Types */
include plugin_dir_path(__FILE__) . 'post-types/guides.php';
include plugin_dir_path(__FILE__) . 'post-types/investigations.php';
include plugin_dir_path(__FILE__) . 'post-types/news.php';
include plugin_dir_path(__FILE__) . 'post-types/studies.php';

/* Custom Taxonomies */
include plugin_dir_path(__FILE__) . 'taxonomies/topics.php';
?>