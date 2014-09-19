<ul>
	<?php foreach($this->getRecentPosts() as $post): ?>
	<li><?php echo CHtml::link(CHtml::encode($post->postTitle), $post->getUrl()); ?></li>
	<?php endforeach; ?>
</ul>