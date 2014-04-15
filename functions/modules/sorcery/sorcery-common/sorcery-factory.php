<?php

/**
 * Collection of callbacks for sorcery
 * 
 * @package Sorcery_Common
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Factory extends Glyph {

	/**
	 * Set the widget id
	 * 
	 * @param string $id
	 * @return self
	 */
	public function get($index = null, $default = null, $strict = true) {
		$callback = parent::get($index, $default, $strict);
		if(is_callable($callback)) {
			$args = func_get_args();
			array_shift($args);
			return call_user_func_array($callback, $args);
		}
		return false;
	}

	/**
	 * Get the widget id
	 * 
	 * @return string
	 */
	public function __call($id, $params) {
		array_unshift($params, $id);
		return call_user_func_array(array($this, 'get'), $params);
	}
}
