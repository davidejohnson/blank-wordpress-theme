<?php

/* 
 * The MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

define('WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('THEME_FOLDER',str_replace("\\",'/',dirname(__FILE__)));
define('THEME_PATH','/'.substr(THEME_FOLDER,stripos(THEME_FOLDER,'wp-content')));
    
/**
 * Performs a clean up of out-of-the-box WordPress features
 */
require (get_template_directory() . '/inc/cleanup.php' );

/**
 * Adds support for breadcrumbs.
 */
require( get_template_directory() . '/inc/breadcrumbs.php' ); 

/**
 * Hide plugin update notifications
*/ 
require (get_template_directory() . '/inc/update-hider.php' );

/**
 * Calls the custom content
 */
require (get_template_directory() . '/inc/custom-content.php' );

/**
 * Creates the custom post types
*/
require (get_template_directory() . '/inc/custom-posts.php' );

/**
 * Enables the page heirarchy redirect
*/
require (get_template_directory() . '/inc/page-heirarchy.php' );

/* Makes WordPress run the quantum_setup once it has initialised itself */
add_action( 'after_setup_theme', 'quantum_setup' );

if (!function_exists('quantum_setup')):
    function quantum_setup() {
        register_nav_menus(array(
           'primary' => __('Top navigation', 'access')
        ));
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 ); // Unlimited height, soft crop
        add_editor_style();
    }
endif;

/**
 *  Renames the "Post" label to "Blog" (or whatever you would like to call it
 */

add_action('admin_menu', 'change_post_menu_label' );

function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Blog';
    $submenu['edit.php'][5][0] = 'Blog';
    $submenu['edit.php'][10][0] = 'Add Blog article';
    $submenu['edit.php'][15][0] = 'Category'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
    echo '';
}

add_action('init', 'change_post_object_label' );

function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Blog';
    $labels->singular_name = 'Blog';
    $labels->add_new = 'Add Blog article';
    $labels->add_new_item = 'Add Blog article';
    $labels->edit_item = 'Edit Blog';
    $labels->new_item = 'Blog';
    $labels->view_item = 'View Blog article';
    $labels->search_items = 'Search Blog';
    $labels->not_found = 'No Blog articles found';
    $labels->not_found_in_trash = 'No Blog articles found in the bin.';
}


?>