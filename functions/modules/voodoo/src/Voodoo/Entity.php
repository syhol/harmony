<?php

/**
 * Class wrapper for entities
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Entity implements ArrayAccess {

	protected $data = array();

	/**
	 * Setup the entity with required properties
	 *
	 * @param array           $data
	 */
	public function __construct($data) {
		$this->data = $data;
	}

	/**
	 * Set data
	 * 
	 * @param string $index key to save data to
	 * @param string $data  data to set 
	 * @return self
	 */
	public function set($index, $data) {
		if (null !== $index && false !== $index)  {
			array_dot_set($this->data, $index, $data);
		} else {
			$this->data[] = $value;
		}
		return $this;
	}

	/**
	 * Get data
	 *
	 * @param string $index (optional) get data from key provided else return all data 
	 * @param mixed  $default (optional) returns when index not found 
	 * @return mixed
	 */
	public function get($index = null, $default = null) {
		if (null !== $index || false !== $index)  {
			return array_dot_get($this->data, $index, $default);
		} else {
			return $this->data;
		}
			
	}

	/**
	 * Is data set
	 *
	 * @param string $index
	 * @return booean
	 */
	public function has($index) {
		$data = array_dot($this->data);
		return isset($data[$index]);
	}

	/**
	 * Remove data
	 *
	 * @param string $index
	 * @return self
	 */
	public function remove($index) {
		array_dot_forget($this->data, $index);
		return $this;
	}

	/**
	 * Push an item to the end of the array
	 *
	 * @param string $index key to push a value to
	 * @param string $data  data to push 
	 * @return array        altered value at index 
	 */
	public function push($index, $value) {
		$data = $this->get($index, array());
		if( ! is_array($data) ) {
			$data = array();
		}
		array_push($data, $value);
		$this->set($index, $data);
		return $data;
	}

	/**
	 * Pop an item off the end of the array
	 *
	 * @param string $index key to pop a value from
	 * @return mixed        removed value
	 */
	public function pop($index) {
		$data = $this->get($index, array());
		if(is_array($data)) {
			$removed = array_pop($data);
			$this->set($index, $data);
			return $removed;
		}
		return false;
	}

	/**
	 * Push an item to the start of the array
	 *
	 * @param string $index key to push a value to
	 * @param string $data  data to push 
	 * @return array        altered value at index 
	 */
	public function unshift($index, $value) {
		$data = $this->get($index, array());
		if( ! is_array($data) ) {
			$data = array();
		}
		array_unshift($data, $value);
		$this->set($index, $data);
		return $data;
	}

	/**
	 * Shift an item off the start of the array
	 *
	 * @param string $index key to shift a value from
	 * @return mixed        removed value
	 */
	public function shift($index) {
		$data = $this->get($index, array());
		if(is_array($data)) {
			$removed = array_shift($data);
			$this->set($index, $data);
			return $removed;
		}
		return false;
	}

	/**
	 * Convert object to standard array
	 *
	 * @return array
	 */
	public function to_array() {
		return $this->data;
	}


	/**
	 * Set data
	 * 
	 * @param string $index key to save data to
	 * @param string $data  data to set 
	 * @return boolean
	 */
	public function __set($index, $data) {
		$this->set($index, $data);
		return true;
	}

	/**
	 * Get data
	 *
	 * @param string $index
	 * @return mixed
	 */
	public function __get($index) {
		return $this->get($index);
	}

	/**
	 * Is data set
	 *
	 * @param string $index
	 * @return boolean
	 */
	public function __isset($index) {
		return $this->has($index);
	}

	/**
	 * Remove data
	 *
	 * @param string $index 
	 * @return void
	 */
	public function __unset($index) {
		$this->remove($index);
	}

	/**
	 * Set data
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetSet($index, $value) {
		$this->set($index, $value);
		return true;
	}

	/**
	 * Get data
	 * 
	 * @param string|interger $index
	 * @return mixed
	 */
	public function offsetGet($index) {
		return $this->get($index, false);
	}

	/**
	 * Is data set
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetExists($index) {
		return $this->has($index);
	}

	/**
	 * Remove data
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetUnset($index) {
		$this->remove($index);
		return true;
	}
}
