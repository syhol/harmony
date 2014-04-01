<?php
/**
 * Template for a general field layout
 * 
 * @package Sorcery
 * @subpackage Sorcery_Layouts
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
?>
<div <?php echo flatten_attributes($attributes); ?>>

	<?php if($label) : ?>
		<label class="control-label"><? echo $label; ?></label>
	<?php endif; ?>

	<?php if($widget) echo $widget; ?>

	<?php if($help || $errors) : ?>
		<div class="help-block">
		<?php if($errors) echo $errors; ?>
		<?php if($help) : ?>
			<p><? echo $help; ?></p>
		<?php endif; ?>
		</div>
	<?php endif; ?>

</div>