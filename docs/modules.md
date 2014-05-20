# Modules

Modules are sections of self contained code (with possible dependencies). A module can contain PHP scripts, CSS stylesheets, Javascript scripts, and pretty much anything.

A module is defined by a module file. If the entire module is just a php file, you just have to place that file in the modules directory. If the module containes more than just 1 php file, create a directory with the same name as the module file in the modules directory, then place the module file inside it along side all the other files needed in that module.

Example:

* modules
	* my-module.php
	* another-module.php
	* a-large-module/
		* a-large-module.php
		* style.css
		* script.js
		* helpers.php
	* another-large-module/
		* another-large-module.php
		* src/
			* MyClass.php
		* my-config.json

All module files should have a docblock at the top of the file, stating the name and description of the module, including author name/email and licence. Using the @require doc tag, you can require other modules as dependencies.

Example module-name.php

<?php
/**
 * Module Name
 *
 * Module Description
 *
 * @author  Author Name <author@email.com>
 * @package Module_Name
 * @license MIT
 * @require Other Module Name, another-module-slug, mod-slug, Grand Module Name
 */

