# Harmony - A WP Starter Theme

![](https://raw.github.com/syholloway/harmony/master/screenshot.png)

## Todos
- Wordpress helpers
    - Location helpers
- Post Type module
- Taxonomy module
- Meta module
    - Meta types
        - Post
        - User
        - Term
        - Site - (options page)
    - Meta forms
        - Widgets
        - Fields
        - Validation
- Create a good way to add theme setup like menus, images sizes ect. 
- Pagination module
    - Infinite scroll sub module
    - JS Slider pagination sub module
- Image module
    - Featured image module
- Menu module

## Modules
- Dev Tools
    - Profiler
- Route module
- Registry module
- Page Title module
- Template module
- PHP Helpers

## Requirments

* PHP >= 5.2
    * php_curl
* Apache 2.*
    * rewrite_module
* Wordpress >= 3.5 

## Code Style

The following coding style is a mixture of PSR-2 and WordPress style 

### Strings

* Must use single quotes when creating a string 

### Indentation

* 4 spaces for PHP indentation
* 4 spaces for HTML indentation
* 4 spaces for JavaScript indentation
* 2 spaces for CSS indentation


### Selection

#### Standard Formatting:

* 1 space between the selection keywork and open parenthese `(`
* No space between the open parenthese `(` and condition (unless specified)
* 1 space each side of operators
    * 1 space each side of Not (!) operators and 1 space after the not condition
* No space between the condition and the close parenthese `)` (unless specified)
* 1 space between the close parenthese and open selection body
* Open selection body `{` must go on the same line 
* Close selection body `}` must go on the next line after the body finishes
* Else and elseif must go on the same line as the close body of the previous selection
* Elseif must be used as 1 word and not "else if"

```php
<?php
if ($condition1) {
    action1();
    action2();
} elseif ($condition2 && $condition3) {
    action3();
    action4();
} elseif ( ! $condition4 ) {
    action5();
} else {
    defaultaction();
}
?>
```

#### Templating Formatting:

* 1 space between the selection keywork and open parenthese `(`
* No space between the open parenthese `(` and condition (unless specified)
* 1 space each side of operators
    * 1 space each side of Not (!) operators and 1 space after the not condition
* No space between the condition and the close parenthese `)` (unless specified)
* 1 space between the close parenthese and open selection body `:`
* Open selection body `:` must go on the same line 
* Close selection body `<?php endif; ?>` must go on the next line after the body finishes
* If, else, elseif, and endif must go on a line by itself
* Elseif must be used as 1 word and not "else if"

```php
<?php if ($condition1) : ?>
    <div>Condition 1</div>
<?php elseif ($condition2 && $condition3) : ?>
    <div>Condition 2 and Condition 3</div>
<?php elseif ( ! $condition4 ) : ?>
    <div>Not Condition 4</div>
<?php else : ?>
    <div>Default</div>
<?php endif; ?>
```

### Iteration

#### Standard Formatting:

* 1 space between the iteration keywork and open parenthese `(`
* No space between the open parenthese `(` and condition (unless specified)
* 1 space each side of operators
    * 1 space each side of `as`, `=>` and conditional/assignment operators
* No space between the condition and the close parenthese `)` (unless specified)
* 1 space between the close parenthese and open iteration body
* Open iteration body `{` must go on the same line 
* Close iteration body `}` must go on the next line after the body finishes

```php
<?php
for ($i = 0; $i < $count; $i++) {
    action();
}
foreach ($array as $key => $value) {
    action();
}
while ($condition) {
    action();
}
?>
```

#### Templating Formatting:

* 1 space between the iteration keywork and open parenthese `(`
* No space between the open parenthese `(` and condition (unless specified)
* 1 space each side of operators
    * 1 space each side of `as`, `=>` and conditional/assignment operators
* No space between the condition and the close parenthese `)` (unless specified)
* 1 space between the close parenthese and open iteration body `:`
* Open iteration body `:` must go on the same line 
* Close iteration body must go on the next line after the body finishes
* for, endfor, foreach, endforeach, while, and endwhile must go on a line by itself

```php
<?php for ($i = 0; $i < $count; $i++) : ?>
    <div>Looping</div>
<?php endfor; ?>

<?php foreach ($array as $key => $value) : ?>
    <div>Looping</div>
<?php endforeach; ?>

<?php while ($condition) : ?>
    <div>Looping</div>
<?php endwhile; ?>

```

### Variables

* Use snake_case for long variable names
* Explicit descriptive names over brevity
* 1 space each side of an assignment operator `=`

#### Bad example:
```php
<?php $ptNmCnt=1; ?>
```

#### Good example:
```php
<?php $post_name_count = 1; ?>
```


### Functions

* Function name to be in snake_case
* Parameter names to be in snake_case
* No space between the function name and open parenthese `(`
* No space between the open parenthese `(` and first parameter
* 1 space between a typehint and the parameter
* 1 space each side of the assignment opperator `=` for default parameters
* No space between the parameter and the parameter seperator `,`
* 1 space between the parameter seperator `,` and the next parameter
* No space between the last parameter seperator and the close parenthese `)`
* 1 space between the close parenthese and open function body
* Open function body `{` must go on the same line 
* Close function body `}` must go on the next line after the body finishes

```php
<?php
function add_params($param1, array $array_of_params, $default_param = 1) {
    return $param1 + $default_param;
}
?>
```

### Classes
Only create PHP classes when necessary 
One file per class.

### Namespaces
Don't use them.

### Documentation
PHP DocBlocks at the top of every file, a PHP DocBlock for each function.

### Type Juggling
Swapping types should be done with the (bool)/(string)/(array) syntax
