<?php
/**
 * Template for a select item
 *
 * Could either be a option or an optgroup. This template is recursive.
 * 
 * @package Sorcery
 * @subpackage Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
?>
<?php if (is_array($label)) : ?>
	<optgroup label="<?php echo $key; ?>">
	<?php foreach ($label as $child_key => $child_label) : ?>
		<?php render_template($item_template, array(
			'value' => $value, 
			'key' => $child_key, 
			'label' => $child_label,
			'item_template' => $item_template
		)); ?>
	<?php endforeach; ?>
	</optgroup>
<?php else : ?>
	<?php $is_selected = ($value === $key) ? 'selected="selected"' : ''; ?>
	<option value="<?php echo $key; ?>" <?php echo $is_selected; ?>>
		<?php echo $label; ?>
	</option>
<?php endif; ?>