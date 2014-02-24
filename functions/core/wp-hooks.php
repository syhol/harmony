<?php
/**
 * WordPress Hooks
 *
 * @package Theme Core
 * @author Simon Holloway
 */

add_action('wp_enqueue_scripts', 'print_theme_assets');
add_action('admin_enqueue_scripts', 'print_admin_assets');
add_action('wp_footer', 'print_require_js');
add_action('admin_head', 'print_theme_icons');
add_action('wp_head', 'print_theme_icons');

/**
 * Print the application css file
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_assets() {
    wp_enqueue_style('app', get_asset_url('stylesheets/screen.css'));
}

/**
 * Print the application admin css file
 * 
 * @author Simon Holloway
 * @return void
 */
function print_admin_assets() {
    wp_enqueue_style('app-admin', get_asset_url('stylesheets/admin.css'));
}

/**
 * Print require.js script tag
 * 
 * @author Simon Holloway
 * @return void
 */
function print_require_js() {
    echo '<script data-main="' . get_asset_url('js/main') . '" src="' . get_asset_url('js/require.js') . '"></script>';
}

/**
 * Print favicon, apple-touch-icon and msapplication icon links
 * 
 * @author Simon Holloway
 * @return void
 */
function print_theme_icons() {
    echo '<link rel="shortcut icon" href="' . get_asset_url('img/icons/favicon.ico') . '">';
    echo '<link rel="apple-touch-icon" sizes="57x57" href="' . get_asset_url('img/icons/apple-touch-icon-57x57.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="114x114" href="' . get_asset_url('img/icons/apple-touch-icon-114x114.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="72x72" href="' . get_asset_url('img/icons/apple-touch-icon-72x72.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="144x144" href="' . get_asset_url('img/icons/apple-touch-icon-144x144.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="60x60" href="' . get_asset_url('img/icons/apple-touch-icon-60x60.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="120x120" href="' . get_asset_url('img/icons/apple-touch-icon-120x120.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="76x76" href="' . get_asset_url('img/icons/apple-touch-icon-76x76.png') . '">';
    echo '<link rel="apple-touch-icon" sizes="152x152" href="' . get_asset_url('img/icons/apple-touch-icon-152x152.png') . '">';
    echo '<link rel="icon" type="image/png" href="' . get_asset_url('img/icons/favicon-196x196.png" sizes="196x196') . '">';
    echo '<link rel="icon" type="image/png" href="' . get_asset_url('img/icons/favicon-160x160.png" sizes="160x160') . '">';
    echo '<link rel="icon" type="image/png" href="' . get_asset_url('img/icons/favicon-96x96.png" sizes="96x96') . '">';
    echo '<link rel="icon" type="image/png" href="' . get_asset_url('img/icons/favicon-16x16.png" sizes="16x16') . '">';
    echo '<link rel="icon" type="image/png" href="' . get_asset_url('img/icons/favicon-32x32.png" sizes="32x32') . '">';
    echo '<meta name="msapplication-TileColor" content="#5e5a66">';
    echo '<meta name="msapplication-TileImage" content="' . get_asset_url('img/icons/mstile-144x144.png') . '">';
    echo '<meta name="msapplication-square70x70logo" content="' . get_asset_url('img/icons/mstile-70x70.png') . '">';
    echo '<meta name="msapplication-square144x144logo" content="' . get_asset_url('img/icons/mstile-144x144.png') . '">';
    echo '<meta name="msapplication-square150x150logo" content="' . get_asset_url('img/icons/mstile-150x150.png') . '">';
    echo '<meta name="msapplication-square310x310logo" content="' . get_asset_url('img/icons/mstile-310x310.png') . '">';
    echo '<meta name="msapplication-wide310x150logo" content="' . get_asset_url('img/icons/mstile-310x150.png') . '">';
}