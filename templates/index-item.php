<?php
/**
 * Index Item Template
 *
 * Standard template for displaying a single piece of content in a list or index
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
?>
<article class="<?php echo $classes; ?>">
	
	<a href="<?php echo $link; ?>" title="<?php echo $title_attribute; ?>">
		<h2><?php echo $title; ?></h2>
	</a>
	
	<p><?php echo $content; ?></p>
	
	<a class="btn btn-default" href="<?php echo $link; ?>" title="<?php echo $title_attribute; ?>">
		<?php echo $link_text; ?> 
	</a>
	
</article>