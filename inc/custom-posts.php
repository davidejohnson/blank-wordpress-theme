<?php

/**
 * Creates custom post types within the admin area.
 *
 * @package WordPress
 * @subpackage quantumpress
 * To activate, include this file in the functions.php.
 * 
 */

add_action('init', 'create_post_type', 0);
if(!function_exists('create_post_type')) {
    function create_post_type() {
        register_post_type('news', array(
            'labels' => array(
                'name' => __('News'),
                'singular_name' => __('news'),
                'not_found' => 'No news stories found',
            ),
            'rewrite' => array('slug'=>'news'),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'page-attributes',
                'revisions'
                ),
            'taxonomies' => array('category', 'post_tag') 
            )
        );
        register_post_type('testimonials', array(
            'labels' => array(
                'name' => __('Testimonials'),
                'singular_name' => __('testimonial'),
                'not_found' => 'No testimonials found'
            ),
            'rewrite' => array('slug'=>'testimonial'),
            'public' => true,
            'supports' => array(
                'title',
                'editor',
                'page-attributes',
                'revisions'
            ),
            'has_archive' => true,
            'taxonomies' => array('category', 'post_tag') 
            )            
        );
    }
}

add_action('init', 'create_taxonomies');
if(!function_exists('create_taxonomies')) {
    function create_taxonomies() {
        register_taxonomy_for_object_type('category', 'news');
        register_taxonomy_for_object_type('post_tag', 'news');
        register_taxonomy_for_object_type('category', 'testimonials');
        register_taxonomy_for_object_type('post_tag', 'testimonials');
    }
}

?>
