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
 * @param Divinity_Template $template template object 
 * 
 * @return array
 */
function bind_post_single_data($template)
{
	if (isset($template['post']) && $template['post'] instanceof WP_Post) {
		$post = $template['post'];
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

	$template->apply_defaults($defaultData);
}
add_action('template_bind_single-item', 'bind_post_single_data', 5);

/**
 * Set standard data for a post single item
 *  
 * @param Divinity_Template $template data passed to template
 * 
 * @return array
 */
function bind_post_single_404_data($template)
{
	$the404Data = array();

	if (is_404()) {
		$the404Data = array(
			'classes' => 'page-404 error-404 single-item',
			'title' => 'Page Not Found',
			'content' => 'Sorry, the page you have requested does not exist.'
		);
	}

	$template->apply_defaults($the404Data);
}
add_action('template_bind_single-item', 'bind_post_single_404_data', 4);


/**
 * Set standard data for a post index item from global $post
 *  
 * @param Divinity_Template $template data passed to template
 * 
 * @return array
 */
function bind_post_index_data($template)
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

	$template->apply_defaults($defaultData);
}
add_action('template_bind_index-item', 'bind_post_index_data', 5);
