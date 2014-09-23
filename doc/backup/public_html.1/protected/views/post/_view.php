<div class="post">
	<h2 class="title <?php if ($data->postStatus==1) echo 'postDraft'; ?>"><?php echo CHtml::link(CHtml::encode($data->postTitle), $data->url); ?></h2>
	<p class="meta">
		<span class="date"><?php echo $this->getdate($data->postDate); ?></span>
		<span class="posted"><?php echo $data->user->userFullName; ?></span>
	</p>
	<div style="clear: both;">&nbsp;</div>
	<div class="entry">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->anonceText;
			$this->endWidget();
		?>
		<div style="clear: both;">&nbsp;</div>
		<p class="links">
			<?php echo CHtml::link(CHtml::encode('Още...'), $data->url); ?>
		</p>
	</div>
</div>