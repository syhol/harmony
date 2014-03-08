<?php
/**
 * Data bindings file
 *
 * @package  Theme_Custom
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */


/**
 * Set standard data for a post single item
 *  
 * @param object $template template object 
 * 
 * @return array
 */
function bind_post_single_data($data) {
    
    if ( ! ($data instanceof WP_Post) && ! empty($data) ) {
        return;
    }

    if ($data instanceof WP_Post) {
        $post = $data;
    } else {
        global $post;
        if ( ! ($post instanceof WP_Post) ) {
            return;
        }
    }

    $data = array(
        'title' => get_the_title($post->ID),
        'classes' => join(' ', get_post_class('single-item', $post->ID)),
        'content' => apply_filters('the_content', $post->post_content)
    );

    return $data;
}
add_action('render_template_data_single-item', 'bind_post_single_data', 5);

/**
 * Set standard data for a post single item
 *  
 * @param mixed $data data passed to template
 * 
 * @return array
 */
function bind_post_single_404_data($data) {
    
    if ( ! empty($data) || ! is_404()) {
        return $data;
    }

    $data = array(
        'classes' => 'page-404 error-404 single-item',
        'title' => 'Page Not Found',
        'content' => 'Sorry, the page you have requested does not exist.'
    );

    return $data;
}
add_action('render_template_data_single-item', 'bind_post_single_404_data', 5);


/**
 * Set standard data for a post index item from global $post
 *  
 * @param mixed $data data passed to template
 * 
 * @return array
 */
function bind_post_index_data($data) {
    
    if ( ! ($data instanceof WP_Post) && ! empty($data) ) {
        return $data;
    }

    if ($data instanceof WP_Post) {
        $post = $data;
    } else {
        global $post;
        if ( ! ($post instanceof WP_Post) ) {
            return $data;
        }
    }

    $data = array(
        'title' => get_the_title($post->ID),
        'classes' => join(' ', get_post_class('index-item', $post->ID)),
        'link' => get_permalink($post->ID),
        'link_text' => 'Read More&nbsp;&raquo;',
        'content' => get_excerpt($post->ID),
        'title_attribute' => the_title_attribute(array('echo' => false))
    );

    return $data;
}
add_action('render_template_data_index-item', 'bind_post_index_data', 5);
