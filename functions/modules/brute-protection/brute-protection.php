<?php
/**
 * Brute Protection
 * 
 * Adds extra security to wordpress by hooking into the wordpress login 
 * functionality and restricting the rate at which failed logins can be 
 * re-attempted from a given IP range.
 * 
 * @package Brute_Protection
 * @version 0.1.0
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

require('hooks.php');
require('helpers.php');