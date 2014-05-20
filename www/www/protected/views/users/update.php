<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
// 	$model->userId=>array('view','id'=>$model->userId),
	'Профил ('.$model->userName.')'=>array('view','id'=>$model->userId),
	'Промяна',
);

$this->menu=array(
	array('label'=>'Потребители', 'url'=>array('admin'),'visible'=>Yii::app()->user->getState('userType')>2),
	array('label'=>'Нов', 'url'=>array('create'),'visible'=>Yii::app()->user->getState('userType')>2),
// 	array('label'=>'Виж', 'url'=>array('view', 'id'=>$model->userId),'visible'=>(Yii::app()->user->getState('userType')>2) || (Yii::app()->user->getId()==$model->userId)),
// 	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Профил <i>(<?php echo $model->userName; ?>)</i></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
