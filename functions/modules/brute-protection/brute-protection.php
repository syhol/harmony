<?php
/**
 * Brute Protection
 * 
 * Adds extra security to wordpress by hooking into the wordpress login 
 * functionality and restricting the rate at which failed logins can be 
 * re-attempted from a given IP range.
 * 
 * @package Brute Protection
 * @version 0.1.0
 * @license MIT
 * @author Simon Holloway
 */

require('hooks.php');
require('helpers.php');