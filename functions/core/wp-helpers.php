<?php
/**
 * WordPress Helpers
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

/**
 * Get the excerpt from a post id
 * 
 * Uses post_excerpt, if post_excerpt is not available it will use post_content
 * and convert it to an excerpt by running excerpt filters and wp_trim_words.
 * If no $post_id passed will attempt to use the global post object.
 *  
 * @param  integer|string $post_id
 * @return string
 */
function get_excerpt($post_id = null) {

	if (is_numeric($post_id)) {
		$post = get_post($post_id);
	} else {
		global $post;
	}

	if ( ! ($post instanceof WP_Post) ) {
		return '';
	}

	if (isset($post->post_excerpt) && ! empty($post->post_excerpt) ) {
		$excerpt = $post->post_excerpt;
	} else {
		$excerpt = $post->post_content;
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');
		$excerpt = wp_trim_words($excerpt, $excerpt_length, $excerpt_more);
	}

	$excerpt = apply_filters('get_the_excerpt', $excerpt);
	$excerpt = apply_filters('the_excerpt', $excerpt);

	return $excerpt;
}