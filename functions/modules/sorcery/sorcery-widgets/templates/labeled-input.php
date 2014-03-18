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
<div <?php echo $container_attributes; ?>>
    <label>
        <input <?php echo $attributes; ?> />&nbsp;<?php echo $label; ?>
    </label>
</div>