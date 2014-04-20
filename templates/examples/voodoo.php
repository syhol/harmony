<div class="well">
	<h2><?php echo $voodoo_post->post_title; ?></h2>
	<p><?php echo $voodoo_post['post_content']; ?></p>
	<h3><?php echo $voodoo_post['feature.title']; ?></h3>
	<h4><?php echo $voodoo_post->get('feature.subtitle'); ?></h4>
	<ul>
		<?php foreach ($voodoo_post['feature.items'] as $item): ?>
			<li><?php echo $item; ?></li>
		<?php endforeach; ?> 
	</ul>
	<p><?php echo $voodoo_post->get('feature.content', 'Default Fallback Content...'); ?></p>
</div>