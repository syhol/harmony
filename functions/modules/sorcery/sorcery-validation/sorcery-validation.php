<?php
/**
 * Sorcery Validator Module
 *
 * Module to validate data, most often form fields
 * 
 * @package Sorcery
 * @subpackage Sorcery_Validation
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 1.0.0
 */

function sorcery_validate_required($subject) {
	return (bool)( ! empty($subject) );
}

function sorcery_validate_pattern($subject, $pattern) {
	return (bool)preg_match($pattern, $subject);
}

function sorcery_validate_maxchar($subject, $limit) {
	return (bool)(strlen((string)$subject) <= (int)$limit);
}

