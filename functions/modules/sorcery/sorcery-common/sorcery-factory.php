<?php

/**
 * Collection of callbacks for sorcery
 * 
 * @package Sorcery_Common
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Factory implements ArrayAccess {

	/**
	 * collection of callbacks that can be called on via __call, ArrayAccess or get()
	 * 
	 * @var array
	 */
	protected $callbacks = array();

	/**
	 * Set the widget id
	 * 
	 * @param string $id
	 * @return self
	 */
	public function get($id) {
		if(isset($this->callbacks[$id])) {
			if(is_callable($this->callbacks[$id])) {
				$args = func_get_args();
				array_shift($args);
				return call_user_func_array($this->callbacks[$id], $args);
			}
		}
		return false;
	}

	/**
	 * Get the widget id
	 * 
	 * @return string
	 */
	public function set($id, $callback) {
		$this->callbacks[$id] = $callback;
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

	/**
	 * Check if a callback exists
	 * 
	 * @param  string
	 * @return boolean
	 */
	public function offsetExists($index) {
		return isset($this->callbacks[$index]);
	}

	/**
	 * Get run a callback and return the result
	 * 
	 * @param  string $index
	 * @return mixed
	 */
	public function offsetGet($index) {
		if($this->offsetExists($index)) {
			return $this->get($index);
		}
		return false;
	}

	/**
	 * Set a new callback or override one
	 * 
	 * @param  string   $index
	 * @param  callable $value
	 * @return boolean
	 */
	public function offsetSet($index, $value) {
		if($index) {
			$this->set($index, $value);
		} else {
			return false;
		}
		return true;

	}

	/**
	 * Remove a callback
	 * 
	 * @param  string   $index
	 * @return boolean
	 */
	public function offsetUnset($index) {
		unset($this->callbacks[$index]);
		return true;
	}
}
