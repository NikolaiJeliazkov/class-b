<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	'Профил ('.$model->userName.')',
);

$this->menu=array(
	array('label'=>'Потребители', 'url'=>array('admin'),'visible'=>Yii::app()->user->getState('userType')>2),
	array('label'=>'Нов', 'url'=>array('create'),'visible'=>Yii::app()->user->getState('userType')>2),
	array('label'=>'Промени', 'url'=>array('update', 'id'=>$model->userId),'visible'=>(Yii::app()->user->getState('userType')>2) || (Yii::app()->user->getId()==$model->userId)),
	array(
		'label'=>'Изтрий',
		'url'=>'#',
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->userId),
			'confirm'=>'Потвърдете изтриването!',
		),
		'visible'=>Yii::app()->user->getId()!=$model->userId,
	),
// 	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Профил <i>(<?php echo $model->userName; ?>)</i></h1>

<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/detailViewStyle/styles.css',
	'attributes'=>array(
// 		'userId',
// 		'userStatus',
// 		'userType',
		'userName',
// 		'userPass',
		'userFullName',
		array(
			'name'=>'studentId',
			'value'=>Students::model()->find('studentId=:studentId', array(':studentId'=>$model->studentId))->studentName
		),
		'userEmail',
		'userPhones',
// 		'userIsVisible',
// 		'notes',
	),
)); ?>
