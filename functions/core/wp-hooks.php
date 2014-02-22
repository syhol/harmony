<?php
/**
 * WordPress Hooks
 *
 * @package Theme Core
 * @author Simon Holloway
 */

add_action('wp_enqueue_scripts', 'print_theme_assets');
add_action('wp_footer', 'print_require_js');
add_action('render_template', 'set_default_template_path', 5);
add_action('render_template', 'set_module_template_path', 6);

function print_theme_assets() {
    wp_enqueue_style('app', get_asset_url('stylesheets/screen.css'));
}

function print_require_js() {
    echo '<script data-main="' . get_asset_url('js/app') . '" src="' . get_asset_url('js/require.js') . '"></script>';
}

function set_default_template_path($template) {
    $template->path = TEMPLATES_DIR . $template->original->path . '.php';
}

function set_module_template_path($template) {
    if (strpos($template->original->path, ':') !== false) {
        list($module, $path) = explode(':', $template->original->path);
        $template->path =  MODULES_DIR . $module . DS . 'templates' . DS . $path . '.php';
    }
}