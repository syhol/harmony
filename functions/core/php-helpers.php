<?php
/**
 * PHP Helpers
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @author   Lots of functions stolen from Laravel's Illuminate\Support
 * @license  http://opensource.org/licenses/MIT MIT
 */

/**
 * Flatten a multi-dimensional associative array with dots.
 *
 * @param  array   $array
 * @param  string  $prepend
 * @return array
 */
function array_dot($array, $prepend = '') {
	$results = array();

	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$results = array_merge($results, array_dot($value, $prepend.$key.'.'));
		} else {
			$results[$prepend.$key] = $value;
		}
	}

	return $results;
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_dot_get($array, $key, $default = null) {
	if (is_null($key)) return $array;
	if (isset($array[$key])) return $array[$key];

	foreach (explode('.', $key) as $segment) {
		if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
			return $default;
		}
		$array = $array[$segment];
	}

	return $array;
}

/**
 * Set an array item to a given value using "dot" notation.
 *
 * If no key is given to the method, the entire array will be replaced.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return array
 */
function array_dot_set(&$array, $key, $value)  {
	if (is_null($key)) return $array = $value;

	$keys = explode('.', $key);

	while (count($keys) > 1) {
		$key = array_shift($keys);

		// If the key doesn't exist at this depth, we will just create an empty array
		// to hold the next value, allowing us to create the arrays to hold final
		// values at the correct depth. Then we'll keep digging into the array.
		if ( ! isset($array[$key]) || ! is_array($array[$key])) {
			$array[$key] = array();
		}
		$array =& $array[$key];
	}

	$array[array_shift($keys)] = $value;

	return $array;
}

/**
 * Remove an array item from a given array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @return void
 */
function array_dot_forget(&$array, $key)
{
	$keys = explode('.', $key);

	while (count($keys) > 1) {
		$key = array_shift($keys);

		if ( ! isset($array[$key]) || ! is_array($array[$key])) {
			return;
		}

		$array =& $array[$key];
	}

	unset($array[array_shift($keys)]);
}

/**
 * Check if passed key is the key of the first item in the array
 * 
 * @param  array			$array
 * @param  string|integer   $key
 * @return boolean
 */
function array_is_first(&$array, $key) {
	reset($array);
	return $key === key($array);
}

/**
 * Check if passed key is the key of the last item in the array
 * 
 * @param  array			$array
 * @param  string|integer   $key
 * @return boolean
 */
function array_is_last(&$array, $key) {
	end($array);
	return $key === key($array);
}

/**
 * Get the first key in the array
 * 
 * @param  array			$array
 * @return boolean
 */
function array_get_first(&$array) {
	reset($array);
	return key($array);
}

/**
 * Get the last key in the array
 * 
 * @param  array			$array
 * @return boolean
 */
function array_get_last(&$array) {
	end($array);
	return key($array);
}

/**
 * Split a string by multiple delimiters
 * 
 * @param  array			$delimiters
 * @param  string|integer   $string
 * @return array
 */
function explode_multiple($delimiters, $string) {
	$delimiters = (array)$delimiters;
	return explode(chr(1), str_replace($delimiters, chr(1), $string));
}

/**
 * Replace the first occurrence of string within a string
 * 
 * @param  string $search  string to search for
 * @param  string $replace string to replace the search string with
 * @param  string $subject string to run the replace on
 * @return string		  altered $subject string
 */
function str_replace_first($search, $replace, $subject) {
	$pos = strpos($subject, $search);

	if ($pos !== false) {
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}

	return $subject;
}

/**
 * Replace the last occurrence of string within a string
 * 
 * @param  string $search  string to search for
 * @param  string $replace string to replace the search string with
 * @param  string $subject string to run the replace on
 * @return string		  altered $subject string
 */
function str_replace_last($search, $replace, $subject) {
	$pos = strrpos($subject, $search);

	if ($pos !== false) {
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}

	return $subject;
}

/**
 * Determine if a given string contains a given substring.
 *
 * @param  string		$haystack
 * @param  string|array  $needles
 * @return bool
 */
function str_contains($haystack, $needles) {
	foreach ((array)$needles as $needle) {
		if ($needle != '' && strpos($haystack, $needle) !== false) {
			return true;
		}
	}

	return false;
}

/**
 * Generate a "random" alpha-numeric string.
 *
 * Should not be considered sufficient for cryptography, etc.
 *
 * @param  int	 $length
 * @return string
 */
function str_random($length = 16) {
	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

/**
 * Limit the number of characters in a string.
 *
 * @param  string  $value
 * @param  int	 $limit
 * @param  string  $end
 * @param  boolean $to_nearest_word
 * @return string
 */
function str_limit($value, $limit = 100, $end = '...', $to_nearest_word = true) {
	if (strlen($value) <= $limit) {
		return $value;
	}

	$value = rtrim(substr($value, 0, $limit));

	if ($to_nearest_word) {
		$value = preg_replace('/\s+?(\S+)?$/', '', $value);
	}
	
	return $value . $end;
}

/**
 * Limit the number of words in a string.
 *
 * @param  string  $value
 * @param  int	 $limit
 * @param  string  $end
 * @return string
 */
function str_limit_words($value, $limit = 20, $end = '...') {
	$words = explode(' ', $value);

	if (count($words) <= $limit) {
		return $value;
	}

	return implode(' ', array_splice($words, 0, $limit)) . $end;
}

/**
 * Convert a string to camelCase format
 * 
 * @param  string $string
 * @param  boolean $capitalise_first_char
 * @return string
 */
function camel_case($string, $capitalise_first_char = false) {
	$string = str_replace(' ', '', ucwords(strtolower(alphanumeric($string))));

	if ($capitalise_first_char) {
		$string[0] = strtoupper($string[0]);
	} else {
		$string[0] = strtolower($string[0]);
	}

	return $string;
}

/**
 * Revert a string from snake_case to regular text
 * 
 * @param  string $string
 * @param  string $seperator
 * @return string
 */
function remove_camel_case($string, $seperator = ' ') {
	preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);

	$ret = $matches[0];

	foreach ($ret as &$match) {
		$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
	}

	return implode($seperator, $ret);
}

/**
 * Convert a string to snake_case format
 * 
 * Replace spaces with another character, an underscore by default and make
 * the string lowercase
 * 
 * @param  string $string
 * @param  string $seperator
 * @return string
 */
function snake_case($string, $seperator = '_') {
	return strtolower(str_replace(' ', $seperator, alphanumeric($string)));
}

/**
 * Strip out all non-alphanumeric items from a string
 * 
 * @param  string   $string
 * @param  boolean  $strip_spaces Should spaces be stripped put
 * @return string
 */
function alphanumeric($string, $strip_spaces = false) {
	$pattern = $strip_spaces ? '/[^A-Za-z0-9]/' : '/[^A-Za-z0-9 ]/' ;
	return preg_replace($pattern, '', $string);
}

/**
 * Take a string and make it pretty 
 * 
 * @param  string $string
 * @return string
 */
function prettify($string) {
	return ucfirst(str_replace(array('_', '-'), ' ', $string));
}

/**
 * Dump the passed variables and end the script.
 *
 * @param  dynamic  mixed
 * @return void
 */
function dd() {
	foreach (func_get_args() as $var) {
		var_dump($var);
	}
	
	die();
}
