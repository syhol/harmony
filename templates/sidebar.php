<?php
/**
 * Sidebar Template
 *
 * Renders the standard sidebar on the site using dynamic_sidebar
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
?>

<?php if (is_active_sidebar('sidebar')) : ?>
	<?php dynamic_sidebar('sidebar'); ?>
<?php endif; ?>