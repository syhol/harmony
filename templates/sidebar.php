<?php
/**
 * Sidebar Template
 *
 * Renders the standard sidebar on the site using dynamic_sidebar
 */
?>

<?php if (is_active_sidebar('sidebar')) : ?>
    <?php dynamic_sidebar('sidebar'); ?>
<?php endif; ?>