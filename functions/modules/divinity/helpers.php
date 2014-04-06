<?php
/**
 * Template helpers
 *
 * @package Template
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Flatten an array of attributes into a string that can be placed in a HTML tag
 * 
 * @param  array $attributes attributes to be flattened
 * @return void
 */
function flatten_attributes($attributes) {
	$attrs = array();
	foreach ($attributes as $key => $value) {
		$value = is_array($value) ? implode(' ', $value) : $value ;
		$attrs[] = $key . '="' . $value . '"';
	}
	return implode(' ', $attrs);
}
