<?php
/**
 * WordPress Hooks
 *
 * @package Theme Core
 * @author Simon Holloway
 */

add_action('wp_enqueue_scripts', 'print_theme_assets');
add_action('wp_footer', 'print_require_js');

function print_theme_assets()
{
    wp_enqueue_style('app', get_asset_url('stylesheets/screen.css'));
}

function print_require_js()
{
    echo '<script data-main="' . get_asset_url('js/app') . '" src="' . get_asset_url('js/require.js') . '"></script>';
}