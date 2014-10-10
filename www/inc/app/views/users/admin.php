<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	'Администриране',
);

$this->menu=array(
	array('label'=>'Потребители', 'url'=>array('admin')),
	array('label'=>'Нов', 'url'=>array('create')),
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
<div class="search-form grid-view rounded" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php $this->widget('booster.widgets.TbGridView', array(
	'id'=>'users-grid',
	'dataProvider'=>$model->search(),
// 	'filter'=>$model,
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css',
	//changing the text above the grid can be fun
// 	'summaryText' => 'Yiiplayground is showing you {start} - {end} of {count} cool records',
	//and you can even set your own css class to the grid container
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'columns'=>array(
		'userName',
		'userFullName',
		'student.studentName',
		'userEmail',
		'userPhones',
		array(
			'htmlOptions' => array('nowrap'=>'nowrap'),
			'class'=>'booster.widgets.TbButtonColumn',
// 			'viewButtonUrl'=>null,
// 			'updateButtonUrl'=>null,
// 			'deleteButtonUrl'=>null,
		)
// 		array(
// 			'header' => '',
// 			'class' => 'CButtonColumn',
// 			'viewButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/' . 'gr-view.png',
// 			'updateButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/' . 'gr-update.png',
// 			'deleteButtonImageUrl' => Yii::app()->baseUrl . '/css/gridViewStyle/' . 'gr-delete.png',
// ),
	),
)); ?>
