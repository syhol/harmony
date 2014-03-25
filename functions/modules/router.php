<?php
/**
 * Router Module
 * 
 * Module to generate wordpress routes 
 * 
 * @package Router
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.0.1
 */

/**
 * Get the route array requested url, (REQUEST_URI by default)
 * 
 * @param  string       $url url to match against
 * @return array|false
 */
function get_custom_route($url = null) {
    if (empty($url)) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $url = '#/' . trim($url, '/') . '/#';

    foreach (get_registry('router.routes', array()) as $route) {
        
        $pattern = '#' . $route['pattern'] . '#';

        if (preg_match_all($pattern, $url, $matches, PREG_SET_ORDER)) {
            $matches = $matches[0];
            array_shift($matches);
            return array_merge($route, array('matches' => $matches));
        }
    }
    return false;
}

/**
 * Add a new custom route
 * 
 * Route includes a pattern to match, a callback for successful matches and
 * an optional template path to include after callback has finished executing
 * 
 * @param string            $path     regex pattern to match 
 * @param boolean|callable  $callback callable callback on pattern match
 * @param boolean|string    $template template path to include after callback
 */
function add_route($path, $callback = false, $template = false) {
    $path = '/' . trim($path, '/') . '/';
    push_registry('router.routes', array(
        'path' => $path,
        'callback' => $callback,
        'template' => $template
    ));
}

/**
 * On custom routes, change the called template file according to route array
 * 
 * @param  string $template
 * @return string          
 */
function route_template_include($template) {
    if ($route = get_custom_route()) {
        $template = $route['template'];
    }
    return $template;
}
add_filter('template_include', 'route_template_include');

/**
 * Run callback on wp_loaded if current request is a custom route
 * 
 * @return void
 */
function route_run_callbacks() {
    if ($route = get_custom_route()) {
        if (is_callable($route['callback'])) {
            call_user_func_array($route['callback'], $route['matches']);
        }
    }
  
}
add_action('wp_loaded', 'route_run_callbacks');
