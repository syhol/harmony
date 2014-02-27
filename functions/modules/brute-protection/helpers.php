<?php
/**
 * Brute Protection helpers and functions
 * 
 * @package Brute_Protection
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * Clean up old lockouts
 *
 * @param string    $ip ip address of the visitor
 * @param array     $option module options
 * @return void
 */
function bruprot_clean($ip, &$options)
{
    
    $changed   = false;
    $resetsecs = $options['lockout_minuets'] * 60;
    foreach ($options['attempts'] as $ip => $attempt) {
        if ($attempt['last'] + $resetsecs < time()) {
            $changed = true;
            unset($options['attempts'][$ip]);
        }
    }
    
    if ($changed) {
        bruprot_set_options($options);
    }
}

/**
 * Check to see if the visitor is locked out
 *
 * @param string    $ip ip address of the visitor
 * @param array     $option module options
 * @return void
 */
function bruprot_is_locked_out($ip, $options)
{
    if (!isset($options['attempts'][$ip])) {
        return false;
    } else {
        return $options['attempt_limit'] <= $options['attempts'][$ip]['count'];
    }
}

/**
 * Handel the user being locked out
 *
 * @param string    $ip ip address of the visitor
 * @param array     $option module options
 * @return void
 */
function bruprot_locked_out($ip, $options)
{
    $lastattempt = $options['attempts'][$ip]['last'];
    $resettime   = $lastattempt + ($options['lockout_minuets'] * 60);
    $diff        = $resettime - time();
    $minsleft    = ceil($diff / 60);
    return new WP_Error('brute_attempt', '<strong>ERROR</strong>: 
        Too many login attempts. <br> 
        You are now locked out by Brute Protection. <br>
        You may attempt to login again in ' . $minsleft . ' minutes.');
}

/**
 * Record the fail in the database 
 *
 * @param string    $ip ip address of the visitor
 * @param array     $option module options
 * @return void
 */
function bruprot_fail($ip, &$options)
{
    if (!isset($options['attempts'][$ip])) {
        $options['attempts'][$ip] = array(
            'count' => 0,
            'last' => time()
        );
    }
    
    $options['attempts'][$ip]['count']++;
    
    //If the user is not locked out, reset the last login time
    if (!bruprot_is_locked_out($ip, $options)) {
        $options['attempts'][$ip]['last'] = time();
    }
}

/**
 * Removes any login attempts from the database 
 *
 * @param string    $ip ip address of the visitor
 * @param array     $option module options
 * @return void
 */
function bruprot_success($ip, &$options)
{
    if (isset($options['attempts'][$ip])) {
        $options['attempts'][$ip]['count'] = 0;
        $options['attempts'][$ip]['last']  = 0;
    }
}

/**
 * Get the ip address range from ip address
 *
 * @param string    $ip ip address to get the range of
 * @return string ip address range
 */
function bruprot_get_ip_range($ip)
{
    return substr($ip, 0, strrpos($ip, ".")) . '.%';
}

/**
 * Get the ip address to be used for the visitor in this module
 * 
 * @return string ip address to store/compare against the visitor
 */
function bruprot_get_ip()
{
    return addslashes($_SERVER['REMOTE_ADDR']);
}

/**
 * Get the options for this module
 *
 * @param mixed     $default what to return if no options set
 * @return array
 */
function bruprot_get_options($default)
{
    return apply_filters('bruprot_get_options', get_option('brute_protection_options', $default));
}

/**
 * Set the options for this module
 * @param mixed     $options value of options to save
 * @return void
 */
function bruprot_set_options($options)
{
    update_option('brute_protection_options', apply_filters('bruprot_set_options', $options));
}