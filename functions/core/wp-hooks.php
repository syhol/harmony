<?php
/**
 * WordPress Hooks
 *
 * @package  Theme_Core
 * @uses     Render_Template
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */


/**
 * Print the application css file
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_assets() {
    wp_enqueue_style('app', get_asset_url('stylesheets/screen.css'));
}
add_action('wp_enqueue_scripts', 'print_theme_assets');

/**
 * Print the application admin css file
 * 
 * @author Simon Holloway
 * @return void
 */
function print_admin_assets() {
    wp_enqueue_style('app-admin', get_asset_url('stylesheets/admin.css'));
}
add_action('admin_enqueue_scripts', 'print_admin_assets');

/**
 * Print require.js script tag
 * 
 * @author Simon Holloway
 * @return void
 */
function print_require_js() {
    echo '<script data-main="' . get_asset_url('js/main') . '" src="' . get_asset_url('js/require.js') . '"></script>';
}
add_action('wp_footer', 'print_require_js');

/**
 * Print favicon, apple-touch-icon and msapplication icon links
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_icons() {
    render_template('header/icons');
}
add_action('admin_head', 'print_theme_icons');
add_action('wp_head', 'print_theme_icons');

/**
 * Print theme title tag, using wp_title();
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_title_tag() {
    echo '<title>';
    wp_title('|');
    echo '</title>';
}
add_action('wp_head', 'print_theme_title_tag', 1);

/**
 * Print meta charset in head
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_charset() {
    echo '<meta charset="' . get_bloginfo('charset') . '" />';
}
add_action('wp_head', 'print_theme_charset', 0);

