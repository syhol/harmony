<?php
/**
 * Single Item Template
 *
 * Standard template for dispaying the main content (like title and text and 
 * meta) on "single" pages like page.php, single.php, single-custom.php ect...
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
?>
<article class="<?php echo $classes; ?>">

    <header>
        <h1><?php echo $title; ?></h1>
    </header>

    <div class="wysiwyg">
        <?php echo $content; ?>
    </div>

</article>