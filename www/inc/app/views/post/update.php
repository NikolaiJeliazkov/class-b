<?php
$this->breadcrumbs=array(
	$model->postTitle=>$model->url,
	'Промяна',
);

$this->menu=array(
	array('label'=>'Нова статия', 'url'=>array('create'),'visible'=>Yii::app()->user->getState('userType')>2),
	array('label'=>'Виж', 'url'=>array('view', 'id'=>$model->postId),'visible'=>Yii::app()->user->getState('userType')>2),
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

<h1>Промяна <i><?php echo CHtml::encode($model->postTitle); ?></i></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>