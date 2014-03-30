<?php
/**
 * Template for a labeled input
 *
 * Often used for radio buttons and checkboxes
 * 
 * @package Sorcery
 * @subpackage Sorcery_Widgets
 * @author  Simon Holloway <holloway.sy@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */
?>
<div <?php echo flatten_attributes($container_attributes); ?>>
	<label>
		<input <?php echo flatten_attributes($attributes); ?> />&nbsp;<?php echo $label; ?>
	</label>
</div>