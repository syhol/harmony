<?php

/**
 * Harmony Module Factory
 *
 * @package  Harmony
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  1.0.0
 */
class Harmony_Module_Factory
{
	public function new_module($path)
	{
		return new Harmony_Module($path);
	}

}