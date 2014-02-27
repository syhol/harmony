<?php
/**
 * PHP Helpers
 *
 * @package  Theme_Core
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */

/**
 * Convert a string to camelCase format
 * 
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  string $string
 * @param  string $seperator
 * @return string
 */
function camel_case($string, $capitalise_first_char = false)
{
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
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  string $string
 * @param  string $seperator
 * @return string
 */
function remove_camel_case($string, $seperator = ' ')
{
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
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  string $string
 * @param  string $seperator
 * @return string
 */
function snake_case($string, $seperator = '_')
{
    return strtolower(str_replace(' ', $seperator, alphanumeric($string)));
}

/**
 * Strip out all non-alphanumeric items from a string
 * 
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  string $string
 * @return string
 */
function alphanumeric($string)
{
    return preg_replace("/[^A-Za-z0-9 ]/", '', $string);
}

/**
 * Take a string and make it pretty 
 * 
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  string $string
 * @return string
 */
function prettify_string($string)
{
    return ucfirst(str_replace(array('_', '-'), ' ', $string ));
}

/**
 * Get an item from an array using "dot" notation.
 *
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_dot_get($array, $key, $default = null)
{
    if (is_null($key)) return $array;

    if (isset($array[$key])) return $array[$key];

    foreach (explode('.', $key) as $segment)
    {
        if ( ! is_array($array) || ! array_key_exists($segment, $array))
        {
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
 * @author Simon Holloway
 * @author Laravel Illuminate\Support\helpers.php
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return array
 */
function array_dot_set(&$array, $key, $value) 
{
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
 * Check if passed key is the key of the first item in the array
 * 
 * @author Simon Holloway
 * @param  array            $array
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
 * @author Simon Holloway
 * @param  array            $array
 * @param  string|integer   $key
 * @return boolean
 */
function array_is_last(&$array, $key) {
    end($array);
    return $key === key($array);
}

/**
 * Replace the first occurrence of string within a string
 * 
 * @author Simon Holloway
 * @param  string $search  string to search for
 * @param  string $replace string to replace the search string with
 * @param  string $subject string to run the replace on
 * @return string          altered $subject string
 */
function str_replace_first($search, $replace, $subject)
{
    $pos = strpos($subject, $search);

    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}

/**
 * Replace the last occurrence of string within a string
 * 
 * @author Simon Holloway
 * @param  string $search  string to search for
 * @param  string $replace string to replace the search string with
 * @param  string $subject string to run the replace on
 * @return string          altered $subject string
 */
function str_replace_last($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if ($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}