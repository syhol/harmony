<?php
/**
 * Form Library for wordpress
 * 
 * @package Sorcery
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 * @version 0.1.0
 */

require('sorcery-widgets/sorcery-widgets.php');
//require('sorcery-fields/sorcery-fields.php');
//require('sorcery-validation/sorcery-validation.php');
//require('sorcery-forms/sorcery-forms.php');


/**
 * Redirect the sorcery-widgets templates to sorcery/sorcery-widgets/templates
 * 
 * @param string $path
 * @param string $original_path path passed into render_template
 * @param string $data
 * @return void
 */
function sorcery_widgets_template_redirect($path, $original_path, $data) {
	if (str_contains($original_path, 'sorcery-widgets:')) {
		list($module, $new_path) = explode(':', $original_path);
		$module_template = get_module_path('/sorcery/sorcery-widgets/templates/' . $new_path . '.php');
		if (is_file($module_template)) {
			$path = $module_template;
		}
	}
	return $path;
}
add_filter('template_path' , 'sorcery_widgets_template_redirect', 30, 3);