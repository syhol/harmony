<?php
/**
 * WordPress Helpers
 *
 * @package Theme Core
 * @author Simon Holloway
 */

/**
 * Get the asset url path and pass a param to append to the end
 *  
 * @author Simon Holloway
 * @param  string   $path
 * @return string       url to assets with any extra path appended to the end
 */
function get_asset_url($path = '') {
    return get_template_directory_uri() . '/assets/' . trim($path, '/');
}

/**
 * Get standard data for a post index item
 *  
 * @author Simon Holloway
 * @param  object   $post
 * @return array
 */
function get_post_index_data($post = null) {
    
    if (is_null($post)) {
        global $post;
    }

    return array(
        'title' => $post->post_title,
        'classes' => join(' ', get_post_class('', $post->ID)),
        'link' => get_permalink($post->ID),
        'link_text' => 'Read More&nbsp;&raquo;',
        'text' => get_the_excerpt(),
        'title_attribute' => the_title_attribute(array('echo' => false))
    );
}
