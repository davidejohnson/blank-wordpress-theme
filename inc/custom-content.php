<?php

/**
 * Adds custom content areas to the admin section on each Page and Post. By
 * default, I have included:
 * 1/ Metadata (rendered in the header of each page)
 * 2/ Javascript (rendered in the footer of each page)
 *
 * @package WordPress
 * @subpackage quantumpress
 * To activate, include this file in the functions.php.
 * 
 */


add_action('admin_init', 'custom_content_init');

function custom_content_init()
{
    wp_enqueue_style('custom_meta_css', THEME_PATH . '/custom/meta.css');
    wp_enqueue_style('custom_pagetitle_css', THEME_PATH . '/custom/page-title.css');
    wp_enqueue_style('custom_script_css', THEME_PATH . '/custom/custom-script.css');
    // add a metabox for each wordpress page type
    foreach(array('post','page') as $type)
    {
        add_meta_box('custom_meta_data', 'Metadata', 'custom_meta_setup', $type, 'normal', 'high');
        add_meta_box('custom_pagetitle_data', 'Page title', 'custom_page_title_setup', $type, 'normal', 'high');
        add_meta_box('custom_script_data', 'Javascript', 'custom_script_setup', $type, 'normal', 'low');
    }
    
    //include a callback function to save any data the user enters
    add_action('save_post', 'custom_meta_save');
    add_action('save_post', 'custom_page_title_save');
    add_action('save_post', 'custom_script_save');
}

function custom_meta_setup() {  
    global $post;
    //an underscore prevents the meta variable from appearing in the custom fields section
    $meta = get_post_meta($post->ID, '_meta_custom', TRUE);
    include(THEME_FOLDER.'/custom/meta.php');
    echo '<input type="hidden" name="custom_meta_noncename" value="'.wp_create_nonce(__FILE__).'" />';
}

function custom_page_title_setup() {
    global $post;
    $pagetitle = get_post_meta($post->ID, '_pagetitle_custom', TRUE);
    include(THEME_FOLDER.'/custom/page-title.php');
    echo '<input type="hidden" name="pagetitle_noncename" value="'.wp_create_nonce(__FILE__).'" />';
}

function custom_script_setup() {
    global $post;
    $scripts = get_post_meta($post->ID, '_script_custom', TRUE);
    include(THEME_FOLDER.'/custom/custom-script.php');
    echo '<input type="hidden" name="custom_script_noncename" value="'.wp_create_nonce(__FILE__).'" />';
}

function custom_meta_save($post_id) {
    //first, we ensure that the saved data comes from our meta box
    if (!wp_verify_nonce($_POST['custom_meta_noncename'],__FILE__)) return $post_id;
    
    //then we check the user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
   
    /* passed the authentication steps, then we can save the data
     * var types
     * single: _meta_custom[var]
     * array: _meta_custom[var][]
     * grouped array: _meta_custom[var_group][0][var_1], _meta_custom[var_group][0][var_2]
     * 
     */
    
    $current_data = get_post_meta($post_id, '_meta_custom', TRUE);
    $new_data = $_POST['_meta_custom'];
    custom_content_clean($new_data);
    
    if ($current_data){
        if (is_null($new_data)) delete_post_meta($post_id, '_meta_custom');
        else update_post_meta($post_id, '_meta_custom', $new_data);
    } elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'_meta_custom',$new_data,TRUE);
    }
    
    return $post_id;    
}

function custom_script_save($post_id) {
    //first, we ensure that the saved data comes from our meta box
    if (!wp_verify_nonce($_POST['custom_script_noncename'],__FILE__)) return $post_id;  
    
    //then we check the user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
    
    $current_data = get_post_meta($post_id, '_script_custom', TRUE);
    $new_data = $_POST['_script_custom'];
    custom_content_clean($new_data);
    
    if ($current_data){
        if (is_null($new_data)) delete_post_meta($post_id, '_script_custom');
        else update_post_meta($post_id, '_script_custom', $new_data);
    } elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'_script_custom',$new_data,TRUE);
    }
    
    return $post_id;   
}

function custom_page_title_save($post_id) {
    //first, we ensure that the saved data comes from our meta box
    if (!wp_verify_nonce($_POST['pagetitle_noncename'],__FILE__)) return $post_id;  
    
    //then we check the user permissions
    if ($_POST['post_type'] == 'page')
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    } else {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
    
    $current_data = get_post_meta($post_id, '_pagetitle_custom', TRUE);
    $new_data = $_POST['_pagetitle_custom'];
    custom_content_clean($new_data);
    
    if ($current_data){
        if (is_null($new_data)) delete_post_meta($post_id, '_pagetitle_custom');
        else update_post_meta($post_id, '_pagetitle_custom', $new_data);
    } elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'_pagetitle_custom',$new_data,TRUE);
    }
    
    return $post_id;   
}

function custom_content_clean(&$arr)
{
    if (is_array($arr))
    {
        foreach ($arr as $i => $v)
        {
            if (is_array($arr[$i])) 
            {
                custom_content_clean($arr[$i]);
                if (!count($arr[$i])) 
                {
                    unset($arr[$i]);
                }
            }
            else 
            {
                if (trim($arr[$i]) == '') 
                {
                    unset($arr[$i]);
                }
            }
        }

        if (!count($arr)) 
        {
            $arr = NULL;
        }
    }
}
?>
