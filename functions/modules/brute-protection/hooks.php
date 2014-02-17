<?php
/**
 * Brute Protection hooks
 * 
 * @package Brute Protection
 * @author Simon Holloway
 */


/**
 * Register Actions and Filters
 */

add_filter('bruprot_get_options', 'bruprot_apply_default_options');
add_filter('shake_error_codes', 'bruprot_add_shake_codes', 1, 1);
add_filter('authenticate', 'bruprot_auth_attempt', 55, 3);
add_action('login_form', 'bruprot_credit_link');

/**
 * Handlers for Actions and Filters
 */

/**
 * Set default module options using the bruprot_get_options hook
 * 
 * @param  array $options
 * @return array
 */
function bruprot_apply_default_options($options = array())
{
    if (!isset($options['attempts'])) {
        $options['attempts'] = array();
    }
    if (!isset($options['attempt_limit'])) {
        $options['attempt_limit'] = 4;
    }
    if (!isset($options['lockout_minuets'])) {
        $options['lockout_minuets'] = 5;
    }
    return $options;
}

/**
 * Add the brute protection error message to the list of error messages to shake
 * 
 * @param  array $codes array of error id's to shake on display
 * @return array        array of error id's to shake on display
 */
function bruprot_add_shake_codes($codes)
{
    $codes[] = 'brute_attempt';
    return $codes;
}

/**
 * Filter to run on authenticate to stop brute force attempts
 * 
 * @param  null|WP_User|WP_Error    $user
 * @param  string                   $username
 * @param  string                   $password
 * @return null|void|WP_User|WP_Error
 */
function bruprot_auth_attempt($user, $username, $password)
{
    
    $options = bruprot_get_options(array());
    $ip      = bruprot_get_ip_range(bruprot_get_ip());
    
    bruprot_clean($ip, $options);
    
    //If failed standard auth, and user is not logging out
    if (
               ! ($user instanceof WP_User) 
            && empty($_GET['loggedout']) 
            && ! empty($username)
            && ! empty($password)
    ) {
        bruprot_fail($ip, $options);
        bruprot_set_options($options);
    }
    
    //If locked out
    if (bruprot_is_locked_out($ip, $options)) {
        return bruprot_locked_out($ip, $options);
        //If other auth error
    } elseif ($user instanceof WP_Error) {
        $amount = $options['attempt_limit'] - $options['attempts'][$ip]['count'];
        $user->add('bruprot', __('You have ' . $amount . ' login attempts left.'));
        return $user;
        //If not locked out and user passed standard auth
    } elseif ($user instanceof WP_User) {
        bruprot_success($ip, $options);
        //var_dump($options);
        //die();
        bruprot_set_options($options);
        return $user;
    }
    
}

/**
 * Display a message on the login form announcing that this module is active
 *  
 * @return void
 */
function bruprot_credit_link()
{
    echo "<p>Login form protected by Brute Protection.<br /><br /><br /></p>";
}