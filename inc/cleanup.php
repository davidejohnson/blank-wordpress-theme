<?php

/**
 * Performs a cleanup to the out-of-the-box functionality of WordPress, including:
 * 1. Removing comments
 * 2. Hiding the admin bar on the publicly visible site when an admin user is logged in
 * 3. Removing the WordPress version number from public view
 * 4. Increasing the time between post and subsequent appearance in the RSS feed by 10mins
 *
 * @package WordPress
 * @subpackage quantumpress
 * To activate, include this file in the functions.php.
 * 
 */

 /* Remove the wordpress version info from the head and feeds 
 * (for added security)
 */
add_filter('the_generator', 'complete_version_removal');
if(!function_exists('complete_version_removal')){
    function complete_version_removal() {
        return '';
    }
}

// Delay news feed update by 10 minutes.
add_filter('posts_where', 'publish_later');
if(!function_exists('publish_later')) {
    function publish_later($where){
        global $wpdb;
        if(is_feed()) {
            $now = gmdate('Y-m-d H:i:s');
            //value for the delay; + device
            $wait = '10';
            $device = 'MINUTE'; //use MINUTE, HOUR, DAY, WEEK, MONTH, YEAR
            $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
        }
        return $where;
    }
}

// This removes selected sections from the admin menu in wp_admin during
// load. **Here, we have disabled the comments.
add_action('admin_menu','remove_admin_menu_elements');
if (!function_exists('remove_admin_menu_elements')) {
    function remove_admin_menu_elements(){
        remove_menu_page('edit-comments.php');
    }
}

add_action('wp_before_admin_bar_render','remove_admin_bar_elements');
if (!function_exists('remove_admin_bar_elements')) {
    function remove_admin_bar_elements() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    }    
}

add_action('init','remove_comment_support', 100);
if(!function_exists('remove_comment_support')){
    function remove_comment_support() {
        remove_post_type_support('post', 'comments');
        remove_post_type_support('page', 'comments');
    }
}




?>