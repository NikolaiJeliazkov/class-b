<?php
$this->breadcrumbs=array(
	'Потребители',
);

$this->menu=array(
	array('label'=>'Потребители', 'url'=>array('admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
		data: $(this).serialize()
	});
	return false;
});
");



?>

<h1>Потребители</h1>

<?php echo CHtml::link('търсене','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$dataProvider,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$dataProvider->search(),
// 	'filter'=>$model,
	'columns'=>array(
// 		'userId',
// 		'userStatus',
// 		'userType',
		'userName',
// 		'userPass',
		'userFullName',
// 		'studentId',
		'userEmail',
		'userPhones',
// 		'userIsVisible',
// 		'notes',
// 		array(
// 			'class'=>'CButtonColumn',
// 		),
	),
)); ?>



<?php
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// ));
?>
