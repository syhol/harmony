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

/**
 * Apply default page title
 * 
 * @author Simon Holloway
 * @param string title string
 * @param query WP_Query object
 * @return string title
 */
function default_page_title($title, $query) {
    if ($query->is_home()) {
        if (get_option('page_for_posts', true)) {
            $title = get_the_title(get_option('page_for_posts', true));
        } else {
            $title = 'Latest Posts';
        }
    } elseif ($query->is_archive()) {
        if ($query->is_tax() || $query->is_category() || $query->is_tag()) {
            $title = $query->queried_object->name;
        } elseif ($query->is_post_type_archive()) {
            $title = $query->queried_object->labels->name;
        } elseif ($query->is_day()) {
            $title = 'Archives - ' . date('jS \o\f F Y', get_archive_timestamp($query));
        } elseif ($query->is_month()) {
            $title = 'Archives - ' . date('F Y', get_archive_timestamp($query));
        } elseif ($query->is_year()) {
            $title = 'Archives - ' . date('Y', get_archive_timestamp($query));
        } elseif ($query->is_author()) {
            $title = 'By: ' . $query->queried_object->display_name;
        }
    } elseif ($query->is_search()) {
        $title = 'Search Results for &quot;' . $query->query_vars['s'] . '&quot;';
    } elseif ($query->is_404()) {
        $title = 'Not Found';
    } else {
        $title = get_the_title();
    }
    return $title;
}
add_filter('page_title', 'default_page_title', 5, 2);

/**
 * Apply page title to wp_title (a.k.a head title tag)
 * 
 * @author Simon Holloway
 * @param string title string
 * @param string seperator
 * @param string location
 * @return string title
 */
function apply_page_title_to_wp_title($title, $sep, $location) {
    $title = get_page_title();
    $sep = ' ' . trim($sep) . ' ';
    if ($location !== 'left' ) {
        $title = $title . $sep . get_bloginfo('name');
    } else {
        $title = get_bloginfo('name') . $sep . $title;
    }

    return $title;
}
add_filter('wp_title', 'apply_page_title_to_wp_title', 5, 3);