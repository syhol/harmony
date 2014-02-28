<?php
/**
 * WordPress Helpers
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

/**
 * Get the asset url path and pass a param to append to the end
 *  
 * @author Simon Holloway
 * @param  string   $path
 * @return string       url to assets with any extra path appended to the end
 */
function get_asset_url($path = '') {
    return get_theme_url('assets/' . trim($path, '/'));
}

/**
 * Get the theme url path and pass a param to append to the end
 *  
 * @author Simon Holloway
 * @param  string   $path
 * @return string       url to assets with any extra path appended to the end
 */
function get_theme_url($path = '') {
    return get_template_directory_uri() . '/' . trim($path, '/');
}

/**
 * Get date query timestamp from a WP_Query archive query
 *  
 * @author Simon Holloway
 * @param  object   WP_Query
 * @return integer|false
 */
function get_archive_timestamp($query = null) {
    if(is_null($query)) {
        global $wp_query;
        $query = $wp_query;
    }

    if ( ! $query->is_date() )
        return false;


    $vars = $query->query_vars;
    $day = isset($vars['day']) && $vars['day'] > 0 
        ? str_pad($vars['day'], 2, '0', STR_PAD_LEFT) : '01';

    $month = isset($vars['monthnum']) && $vars['monthnum'] > 0  
        ? str_pad($vars['monthnum'], 2, '0', STR_PAD_LEFT) : '01';

    $year = isset($vars['year'])  && $vars['year'] > 0  
        ? str_pad($vars['year'], 4, '0', STR_PAD_LEFT) : date('Y');

    return strtotime($day . '-' . $month . '-' . $year);
}

/**
 * Get title for a page/post/term/archive/index/search/404/and more...
 *  
 * @author Simon Holloway
 * @param object WP_Query|null
 * @return string title
 */
function get_page_title($query = null) {
    if(is_null($query)) {
        global $wp_query;
        $query = $wp_query;
    }
    $title = '';
    return apply_filters('page_title', $title, $query);
}

/**
 * echo get_page_title()
 *
 * @see get_page_title()
 * @author Simon Holloway
 * @param  object WP_Query|null
 * @return string title
 */
function page_title($query = null) {
    echo get_page_title($query);
}
