<?php

/**
 * Class wrapper for collection
 * 
 * @package Voodoo
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
class Voodoo_Post extends Voodoo_Entity implements IteratorAggregate {

	public function pluck($index)
	{
		$plucked = array();
		foreach ($this->data as $child) {
			if ($value = $child->get($index, false)) {
				$plucked[] = $value;
			}
		}
		return $plucked;
	}

	public function getIterator() {
		return new ArrayIterator($this->data);
	}

}
