# Wordpress Theme Development - Coding Standards

## Code Style

### Indentation

* 1 Tab for regular code indentation.
* Spaces for code alignment

### Selection

Standard Formatting:
```
<?php

if ($condition1) {
    action1();
    action2();
} elseif ($condition2 && $condition3) {
    action3();
    action4();
} else {
    defaultaction();
}

?>
```

Templating Formatting:
```

<?php if ($condition1) : ?>
    <div>Condition 1</div>
<?php elseif ($condition2 && $condition3): ?>
    <div>Condition 2 and Condition 3</div>
<?php else: ?>
    <div>Default</div>
<?php endif; ?>

```

### Iteration

#### Standard Formatting:
```
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
```

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

#### Bad example:
```
<?php $ptNmCnt = 1; ?>
```

#### Good example:
```
<?php $post_name_count = 1; ?>
```


### Functions

* Function name to be in snake_case
* Parameter names to be in snake_case
* No space between the function name and open parenthese `(`
* No space between the open parenthese `(` and first parameter
* 1 space between a typehint and the parameter
* 1 space either side of the assignment opperator `=` for default parameters
* No space between the parameter and the parameter seperator `,`
* 1 space between the parameter seperator `,` and the next parameter
* No space between the last parameter seperator and the close parenthese `)`
* New line between the close parenthese and open function body
* Open function body `{` must go on the next line 
* Close function body `}` must go on the next line after the body finishes

```
<?php

function add_params($param1, $param2, (array) $array_of_params, $default_param = 1)
{
    return $param1 + $param2;
}

?>
```

### Classes
Only create PHP classes when wordpress requires it, i.e. walker, theme customizer.
One file per class.

### Namespaces
Don't use them.

## Documentation
PHP DocBlocks at the top of every file, a PHP DocBlock for each function.
