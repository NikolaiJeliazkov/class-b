<?php
$this->breadcrumbs=array(
// 	'Блог'=>array('post/index'),
	$model->postTitle,
);
$this->pageTitle=$model->postTitle;

$this->menu=array(
	array('label'=>'Нова статия', 'url'=>array('create'),'visible'=>Yii::app()->user->getState('userType')>2),
	array('label'=>'Промени', 'url'=>array('update', 'id'=>$model->postId),'visible'=>Yii::app()->user->getState('userType')>2),
	array(
		'label'=>'Изтрий',
		'url'=>'#',
		'linkOptions'=>array(
				'submit'=>array('delete','id'=>$model->postId),
				'confirm'=>'Потвърдете изтриването!',
		),
		'visible'=>Yii::app()->user->getState('userType')>2
	),
);


?>
<div class="post">
	<h2 class="title <?php if ($model->postStatus==1) echo 'postDraft'; ?>"><?php echo CHtml::link(CHtml::encode($model->postTitle), $model->url); ?></h2>
	<p class="meta">
		<span class="date"><?php echo $this->getdate($model->postDate); ?></span>
		<span class="posted"><?php echo $model->user->userFullName; ?></span>
	</p>
	<div style="clear: both;">&nbsp;</div>
	<div class="entry">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $model->postText;
			$this->endWidget();
		?>
		<div style="clear: both;">&nbsp;</div>
		<p class="links">
			Последно обновен на <?php echo $this->getdate($model->postLastUpdate); ?>
<?php
if (trim($model->postTags) != '') { ?>
			&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
			Категории:&nbsp;
			<?php echo implode(', ', $model->tagLinks); ?>
<?php } ?>
		</p>
	</div>
</div>