<?php 
/**
 * Footer Template
 * 
 * Pulls in the wp_foot section, closing html tag, and renders the default 
 * footer markup for the site
 * 
 * @author   Simon Holloway <holloway.sy@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 */
?>
<footer class="mastfoot text-center">
	
	<div class="container">
		
		<?php render_template('footer/nav'); ?>
		
		<?php render_template('footer/copyright'); ?>
		
	</div>
		
</footer>

<?php render_template('footer/foot'); ?>