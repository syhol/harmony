<?php
/**
 * This is the config array containing the envrionment config
 * 
 * Each top level array is an "envrionment", feel free to add more envrionments
 * if you wish, plus more config variables inside all.
 * 
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

return array(

	/**
	 * All config always loaded regardless of environment
	 */
	'all' => array(
		'site-logo' => 'https://cdn3.iconfinder.com/data/icons/free-social-icons/67/wordpress_square-128.png'
	),

	/**
	 * Dev environment config
	 */
	'dev' => array(

	),

	/**
	 * Demo environment config
	 */
	'demo' => array(

	),

	/**
	 * Live environment config
	 */
	'live' => array(

	),
);