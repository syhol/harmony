<?php

/**
 * Collection of callbacks for sorcery
 * 
 * @package Sorcery_Common
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Sorcery_Factory implements ArrayAccess {

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

	public function offsetExists($index) {
		return isset($this->callbacks[$index]);
	}

	public function offsetGet($index) {
		if($this->offsetExists($index)) {
			return $this->get($index);
		}
		return false;
	}

	public function offsetSet($index, $value) {
		if($index) {
			$this->set($index, $value);
		} else {
			return false;
		}
		return true;

	}

	public function offsetUnset($index) {
		unset($this->callbacks[$index]);
		return true;
	}
}
