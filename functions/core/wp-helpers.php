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
