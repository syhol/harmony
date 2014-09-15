<?php
/**
 * Sorcery Fields Module
 *
 * Module to generate awesome form fields
 * 
 * @package Sorcery
 * @subpackage Sorcery_Fields
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

//sorcery_field_text();
//new SorceryFieldText('id', 'Value', '');

class Sorcery_Field implements ArrayAccess, IteratorAggregate
{
	
	protected $id;

	protected $value;

	protected $parent;

	protected $children = array();

	/**
	 * Setup the field
	 * 
	 * @param string $id   	name of widget
	 * @param string $value	value of widget
	 * @param array  $data  widget data and config
	 */
	public function __construct($id, $value, $layout, $widget)
	{
		$this->id = $id;
		$this->value = $value;
	}

	/**
	 * Set the field value
	 * 
	 * @param string $value
	 * @return self
	 */
	public function set_value($value)
	{
		$this->value;
		return $this;
	}

	/**
	 * Get the field id
	 * 
	 * @return string
	 */
	public function get_value()
	{
		return $this->value;
	}

	/**
	 * Set the field id
	 * 
	 * @param string $id
	 * @return self
	 */
	public function set_id($id)
	{
		$this->id = (string)$id;
		return $this;
	}

	/**
	 * Get the field id
	 * 
	 * @return string
	 */
	public function get_id()
	{
		return $this->id;
	}
	
	/**
	 * Get the full field id (with parent ids)
	 * 
	 * @return string
	 */
	public function get_full_id()
	{
		$fqidarray = array();

		$fqidarray[] = $this->get_id();

		$parent = $this;
		while (false !== ($parent = $parent->get_parent())) {
			if (false === is_null($parent->get_id())) {
				$fqidarray[] = $parent->get_id();
			}
		}

		//Make the order go from parent to child
		$fqidarray = array_reverse($fqidarray);

		//Get the root id
		$fqidstring = array_shift($fqidarray);

		if (false === empty($fqidarray)) {
			$fqidstring .= '[' . implode('][', $fqidarray) . ']';
		}

		return $fqidstring;
	}

	/**
	 * Set the field parent
	 * 
	 * @param object $parent
	 * @return self
	 */
	public function set_parent($parent)
	{
		$this->parent = $parent;
		return $this;
	}

	/**
	 * Get the field parent
	 * 
	 * @return self
	 */
	public function get_parent()
	{
		return $this->parent;
	}

	/**
	 * Compile and return the field layout with field data
	 * 
	 * @return string
	 */
	public function compile()
	{
		if ($this->template) {
			return compile_template($this->template, $data);
		} else {
			throw new ErrorException('No template set');
		}
	}

	/**
	 * See if the child is set on this field
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetExists($index)
	{
		$data = array_dot($this->data);
		return isset($this->data[$index]);
	}

	/**
	 * get a child from this field
	 * 
	 * @param string|interger $index
	 * @return mixed|false
	 */
	public function offsetGet($index)
	{
		if ($this->offsetExists($index)) {
			return $this->get($index);
		}
		return false;
	}

	/**
	 * set a child to this field
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetSet($index, $value)
	{
		if ($index) {
			$this->set($index, $value);
		} else {
			$this->data[] = $value;
		}
		return true;
	}

	/**
	 * unset a child from this field
	 * 
	 * @param string|interger $index
	 * @return boolean
	 */
	public function offsetUnset($index)
	{
		array_dot_forget($this->data, $index);
		return true;
	}

	public function getIterator()
	{
		return new ArrayIterator($this->children);
	}

	public function __toString()
	{
		return $this->compile();
	}
}
