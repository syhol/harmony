<?php
/**
 * Data bindings file
 *
 * @package  Theme_Custom
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */


/**
 * Set standard data for a post single item
 *  
 * @param object $template template object 
 * 
 * @return array
 */
function bind_post_single_data($data)
{
	if (isset($data['post']) && $data['post'] instanceof WP_Post) {
		$post = $data['post'];
	} else {
		global $post;
	}

	$defaultData = array(
		'title' => '',
		'classes' => '',
		'content' => ''
	);

	if ($post instanceof WP_Post) {
		$defaultData = array(
			'title' => get_the_title($post),
			'classes' => join(' ', get_post_class('single-item', $post)),
			'content' => apply_filters('the_content', $post->post_content)
		);
	}
	
	return wp_parse_args($data, $defaultData);
}
add_filter('template_data_single-item', 'bind_post_single_data', 5);

/**
 * Set standard data for a post single item
 *  
 * @param mixed $data data passed to template
 * 
 * @return array
 */
function bind_post_single_404_data($data)
{
	$the404Data = array();

	if ( is_404() ) {
		$the404Data = array(
			'classes' => 'page-404 error-404 single-item',
			'title' => 'Page Not Found',
			'content' => 'Sorry, the page you have requested does not exist.'
		);
	}

	return wp_parse_args($data, $the404Data);
}
add_filter('template_data_single-item', 'bind_post_single_404_data', 4);


/**
 * Set standard data for a post index item from global $post
 *  
 * @param mixed $data data passed to template
 * 
 * @return array
 */
function bind_post_index_data($data)
{	
	if (isset($data['post']) && $data['post'] instanceof WP_Post) {
		$post = $data['post'];
	} else {
		global $post;
	}

	$defaultData = array(
		'title' => '',
		'classes' => '',
		'link' => '',
		'link_text' => '',
		'content' => '',
		'title_attribute' => '',
	);

	if ($post instanceof WP_Post) {
		$defaultData = array(
			'title' => get_the_title($post),
			'classes' => join(' ', get_post_class('index-item', $post)),
			'link' => get_permalink($post),
			'link_text' => 'Read More&nbsp;&raquo;',
			'content' => get_excerpt($post),
			'title_attribute' => the_title_attribute(array('echo' => false))
		);
	}

	return wp_parse_args($data, $defaultData);
}
add_filter('template_data_index-item', 'bind_post_index_data', 5);
