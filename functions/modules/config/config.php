<?php
/**
 * Config Module
 *
 * Lets theme config variables be get/set using a clean API without the need to 
 * work directly with global variables. also allows the use of per environment
 * config, providing a diffrent set of config for each environment.
 *
 * @package Config
 * @author Simon Holloway
 * @version 1.0.0
 */

$theme_config = array();

require('functions.php');

load_environment_config('default');
load_environment_config();