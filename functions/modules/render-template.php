<?php
/**
 * Render Template Module
 *
 * A small template loader module that loads a template from a prefedined 
 * location (usually the themes TEMPLATES_PATH) and sets up variables to be 
 * include in the templates scope. Using the render_template action the path 
 * and variables (data) can be changed/overridden. 
 *
 * @package Render_Template
 * @uses    Theme_Core
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

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

/**
 * Add default hooks to load templates form the right locations
 */
add_action('render_template', 'set_default_template_path', 5);
add_action('render_template', 'set_module_template_path', 6);

/**
 * Set the default path in the theme templates directory
 * 
 * Set the path to {TEMPLATES_PATH}/{$path}.php by default
 *  
 * @author Simon Holloway
 * @param object $template
 * @return void
 */
function set_default_template_path($template) {
    $template->path = TEMPLATES_PATH . $template->original->path . '.php';
}

/**
 * Set the path to module templates when the ":" operator is used
 * 
 * if a module template is called the path will be set to 
 * {MODULES_PATH}/{$module}/templates/{$path}.php  
 * 
 * @example render_template('mymodule:mydirectory/mytemlate');
 * 
 * @author Simon Holloway
 * @param object $template
 * @return void
 */
function set_module_template_path($template) {
    if (strpos($template->original->path, ':') !== false) {
        list($module, $path) = explode(':', $template->original->path);
        $template->path =  MODULES_PATH . $module . DS . 'templates' . DS . $path . '.php';
    }
}