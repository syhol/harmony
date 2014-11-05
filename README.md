# Harmony - A WP Theme Framework

[![Codeship Status for syholloway/harmony](https://codeship.io/projects/f5630470-473c-0132-bfe3-66e4c0b1f915/status)](https://codeship.io/projects/45540)

![](https://raw.github.com/syholloway/harmony/master/screenshot.png)

**Harmony is a WordPress development theme framework, it helps developers seperate code out and promote code reuse and good coding practises. Harmony comes with a set of modules to really bring some powerful functionality to wordpress.** 

## Installation

Firstly, install wordpress.

Navigate to themes directory, this is located at {your wordpress install}/wp-content/themes in a typical install.

Clone this repository into a new folder.
* If you wish to use harmony as a parent theme, name the new folder "harmony".
* If you wish to build your theme over harmony, name the new folder the name of your theme (in-slug-format)

As this theme can make use of some third party tools (such as larvels awesome blade templating engine) we recommend that you create a view caching folder and give your server rwx access.

- Create a directory /wp-content/uploads if it doesn't exist
- Create a directory /wp-content/uploads/cache if it doesn't exist
- Give the server user access of r/w/x to the uploads folder (chmod 775) or (chmod 777)
- We recommend setting the servers user group (usually www-data on apache) to the uploads folder group.
	- This means that you only need 775 permissions and is more secure

When using harmony as a parent theme, define location constants like CUSTOM_PATH and MODULE_PATH to declare what directories to use for file loading. By changing CUSTOM_PATH to a directory in the child theme, the init.php in the parent theme custom directory will not load, in its place the new (child theme) CUSTOM_PATH's init.php will load after harmony finishes loading. By changing the MODULE_PATH harmony will look in that location for modules instead of the default location.

## Requirments

* PHP >= 5.2
* PHP Extension php_curl
* Apache 2.*
* Apacher Module rewrite_module
* Wordpress >= 3.9 

## Composer Packages You May Wish To Use

You can use multiple templating languages with the "Divinity Template Loading module" by requiring them via composer:

 * "illuminate/view" : "4.1.*",
 * "twig/twig": "1.*",
 * "mustache/mustache" : "2.*"

## Modules

Harmony works by setting out a structure for developers to place code, but most of the awesome functionality comes from self contained modules. Modules can depend on other modules and provide functions and classes, and hooks to enhance the development process.

Modules listed below:

- Autoloaders module
- Dev Tools module
- Divinity - Template Loading module
- Location Helpers module
- Registry module
- Sorcery - Form module
- Voodoo - Model module
- Charms - PHP helpers module
- Glyph - Data container module
- Page Title module
- Router module
