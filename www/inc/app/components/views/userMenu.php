<?php
$this->widget('booster.widgets.TbMenu', array(
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'operations'),
));

?>


<ul>
	<li><?php echo CHtml::link('Create New Post',array('post/create')); ?></li>
	<li><?php echo CHtml::link('Manage Posts',array('post/admin')); ?></li>
	<li><?php echo CHtml::link('Logout',array('site/logout')); ?></li>
</ul>