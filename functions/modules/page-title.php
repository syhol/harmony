<?php
/**
 * Page Title Module
 *
 * Module to generate a title for a query
 * 
 * @package Page_Title
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */


/**
 * Get title for a page/post/term/archive/index/search/404/and more...
 *  
 * @param object WP_Query|null
 * @return string title
 */
function get_page_title($query = null) {
	if (is_null($query)) {
		global $wp_query;
		$query = $wp_query;
	}
	return apply_filters('page_title', '', $query);
}

/**
 * echo get_page_title()
 *
 * @see get_page_title()
 * @param  object WP_Query|null
 * @return string title
 */
function page_title($query = null) {
	echo get_page_title($query);
}


/**
 * Get date query timestamp from a WP_Query archive query
 *  
 * @param  object   WP_Query
 * @return integer|false
 */
function get_archive_timestamp($query) {
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
 * Apply default page title
 * 
 * @param string title string
 * @param query WP_Query object
 * @return string title
 */
function default_page_title($title, $query) { 
	$o = '&ldquo;';
	$c = '&rdquo;';
	if ($query->is_home()) {
		if (get_option('page_for_posts', true)) {
			$title = get_the_title(get_option('page_for_posts', true));
		} else {
			$title = 'Latest Posts';
		}
	} elseif ($query->is_tax() && $query->get_queried_object()) {
		$title = $query->get_queried_object()->name;
	} elseif ($query->is_category() && $query->get_queried_object()) {
		$title = 'In Category' . $o . $query->get_queried_object()->name . $c;
	} elseif ($query->is_tag() && $query->get_queried_object()) {
		$title = 'Tagged  ' . $o . $query->get_queried_object()->name . $c;
	} elseif ($query->is_post_type_archive() && $query->get_queried_object()) {
		$title = $query->get_queried_object()->labels->name;
	} elseif ($query->is_day()) {
		$title = 'Archives - ' . date('jS \o\f F Y', get_archive_timestamp($query));
	} elseif ($query->is_month()) {
		$title = 'Archives - ' . date('F Y', get_archive_timestamp($query));
	} elseif ($query->is_year()) {
		$title = 'Archives - ' . date('Y', get_archive_timestamp($query));
	} elseif ($query->is_author() && $query->get_queried_object()) {
		$title = 'By: ' . $query->get_queried_object()->display_name;
	} elseif ($query->is_search()) {
		$title = 'Search Results for ' . $o . $query->query_vars['s'] . $c;
	} elseif ($query->is_404()) {
		$title = 'Not Found';
	} elseif($query->is_singular() && $query->get_queried_object_id()) {
		$title = get_the_title($query->get_queried_object_id());
	}
	return $title;
}
add_filter('page_title', 'default_page_title', 5, 2);

/**
 * Apply page title to wp_title (a.k.a head title tag)
 * 
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