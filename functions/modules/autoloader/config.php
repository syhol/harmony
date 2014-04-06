<?php
/**
 * Autoloader Config
 * 
 * @package Autoloader
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.0.1
 */

return array(
	'all' => array(
		'autoloader' => array(
			'psr-4' => new Harmony_PSR4_Autoloader,
			'psr-0' => new Harmony_PSR0_Autoloader,
		)
	)
);