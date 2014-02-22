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
 * Render a template from the templates directory
 * 
 * Pass a path and a dataset to this function and render_template hooks will 
 * attempt to interpret the path into a real file path, then the file is 
 * included and the data var is added to the templates scope, arrays are 
 * extracted by default, but the original is still available at $template->data
 * 
 * @author Simon Holloway
 * @param  string   $path 
 * @param  mixed    $data
 * @return void
 */
function render_template($path, $data = array()) {
    $template = (object)array(
        'path' => $path,
        'data' => $data
    );
    $template->original = clone $template;
    do_action('render_template', $template);
    do_action('render_template_' . $path, $template);
    $data = $template->data;
    $path = $template->path;
    if(is_array($data)) extract($data);
    require($template->path);
}
