<?php
/**
 * Data bindings file
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */


/**
 * Get standard data for a post index item
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
    }

    $template->data = array(
        'title' => $post->post_title,
        'classes' => join(' ', get_post_class('', $post->ID)),
        'link' => get_permalink($post->ID),
        'link_text' => 'Read More&nbsp;&raquo;',
        'text' => get_the_excerpt(),
        'title_attribute' => the_title_attribute(array('echo' => false))
    );
}
add_action('render_template_index-item', 'bind_post_index_data');
