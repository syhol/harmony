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











