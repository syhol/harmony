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
function bind_post_single_data($template) {
    
    if ( ! ($template->data instanceof WP_Post) && ! empty($template->data) ) {
        return;
    }

    if ($template->data instanceof WP_Post) {
        $post = $template->data;
    } else {
        global $post;
        if ( ! ($post instanceof WP_Post) ) {
            return;
        }
    }

    $template->data = array(
        'title' => get_page_title(),
        'classes' => join(' ', get_post_class('single-item', $post->ID)),
        'content' => apply_filters('the_content', $post->post_content)
    );
}
add_action('render_template_single-item', 'bind_post_single_data', 5);

/**
 * Set standard data for a post single item
 *  
 * @param object $template template object 
 * 
 * @return array
 */
function bind_post_single_404_data($template) {
    
    if ( ! empty($template->data) || ! is_404()) {
        return;
    }

    $template->data = array(
        'classes' => 'page-404 error-404 single-item',
        'title' => 'Page Not Found',
        'content' => 'Sorry, the page you have requested does not exist.'
    );
}
add_action('render_template_single-item', 'bind_post_single_404_data', 5);


/**
 * Set standard data for a post index item from global $post
 *  
 * @param object $template template object 
 * 
 * @return array
 */
function bind_post_index_data($template) {
    
    if ( ! ($template->data instanceof WP_Post) && ! empty($template->data) ) {
        return;
    }

    if ($template->data instanceof WP_Post) {
        $post = $template->data;
    } else {
        global $post;
        if ( ! ($post instanceof WP_Post) ) {
            return;
        }
    }

    $template->data = array(
        'title' => $post->post_title,
        'classes' => join(' ', get_post_class('index-item', $post->ID)),
        'link' => get_permalink($post->ID),
        'link_text' => 'Read More&nbsp;&raquo;',
        'content' => get_the_excerpt(),
        'title_attribute' => the_title_attribute(array('echo' => false))
    );
}
add_action('render_template_index-item', 'bind_post_index_data', 5);
