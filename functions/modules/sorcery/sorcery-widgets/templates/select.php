<?php
/**
 * Template for a select control
 * 
 * @package Sorcery
 * @subpackage Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
?>
<select <?php echo $attributes; ?>>
	<?php foreach ($options as $key => $label) : ?>
		<?php render_template($item_template, array(
			'value' => $value,
			'key' => $key,
			'label' => $label,
			'item_template' => $item_template
		)); ?>
	<?php endforeach; ?>
</select>