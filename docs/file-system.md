# File System

The harmony theme file system is layed out as follows:

* /assets/
* /docs/
* /functions/
* /templates/
* /functions.php
* /index.php
* /style.css

## Assets

The assets directory is for any front end files like images, stylesheets (CSS) and front end scripts (JavaScript) the assets directory is then further broken down into the following:

* /assets/css/
* /assets/js/
* /assets/img/
* /assets/fonts/
* /assets/stylesheets/

### Css
The CSS directory contains SASS files with SASS includes.

### Js
The JS directory contains JavaScript files (.js), often in multiple files then concatenated with r.js or something similar. 

### Img
The Img directory containes images (.png, .jpeg, .gif, .ico, .svg, ...) hardcoded into the theme, most often textures and sprites.

### Fonts
The Fonts directory containes font files (.ttf, .woff, .svg, .eot, .otf, ...) used for both webfonts and icon fonts.

### Stylesheets
The Stylesheets directory containes CSS files compiled from SASS files. 

## Docs

The docs directory is full of markdown files documenting harmony and its modules. There is a module directory in the docs directory containing a markdown documentation file for each module.

## Functions

The functions directory containes PHP files adding functionality to the theme. It containes harmony core code, plus module files and custom theme code.

* /functions/core/
* /functions/custom/
* /functions/modules/
* /functions/psr-0/
* /functions/vendor/
* /functions/composer.json
* /functions/composer.lock

### Core

Containing the module loading and bootstrapping code for harmony, the core directory is the foundation of the framework. The core directory should not be edited in a harmony site, only when the harmony theme updates.

### Custom

The custom directory is a place to put site specific code, like declare site helpers and template data binding, register post types, taxonomies and theme support. The main file run in the custom directory is the init.php file, this file will then go on to include other files in the custom directory. 

### Modules

This is the default module directory. Files put in here will be treated as module files and directories should contain a module file of the same name. Harmony searchs this directory for new modules on each page load, but caches module info if the module file has not been updated since the last cache.

### PSR-0

By default the composer autoloader will register the psr-0 directory to the root namespace, this can be used to add PSR-0 standard code to your application. For example:
* /psr-0/
* /psr-0/ExampleClass.php
* /psr-0/Example/
* /psr-0/Example/SubClass.php

After composer initialises you would be able to use the classes without having to include them. Example:

'''php
<?php
$example = new ExampleClass();
$sub = new Example_SubClass();
// or
$sub = new Example\SubClass();
// Depending on if you are using namespaces
?>
'''

### Vendor

The vendor directory contains packages downloaded by composer, and the composer autoloader. The contence of this directory should be ignored by version control systems. 

### Composer.json (and composer.lock)

These are the composer files. The composer.json contains a list of all the application php dependencies, feel free to edit this to pull in new packages. The composer.lock stores the current state of the composer setup, this should be version controlled so that when installing the site on a new environment, you know that it will use the same package versions as the last time you updated and tested the site.

## Templates

This directory is the standard place for storing HTML templates. The templates in here should contain as little logic as possible. The standard place to put markup is in the top of the theme level template files, but we recommend avoiding this because it clutters up the theme directory and promotes a mixing responsibilites (fetching data and presenting it) and this is bad! To learn more, read up on the seperation of concerns.

## Theme Directory Files

The top of the theme directory has a few required files that can't sit anywhere else.

### Functions.php

The functions.php file should really only contain a few lines to load other functionality in other files. It is recommended to use the functions.php file just to initialise harmony and include files in the functions directory.

### Style.css

Style.css defines the theme information. While it contain css, it is not recommened. Using the /assets/stylesheets/ directory is a more tidy to organise the code.

### Template Files

Template files (like index.php and single.php) are a powerful multi-purpose component of wordpress. In harmony it is recommened to just use them for routing the application by combining data and templates. Any markup in these template files is hard to reuse and is tightly bound to the data in the file. 
