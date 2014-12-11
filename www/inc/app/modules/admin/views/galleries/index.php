<?php

$this->breadcrumbs=array(
		'Галерии'
);

$this->menu=array(
		array('label'=>'Действия','visible'=>true),
		array(
				'label'=>'Добави галерия',
				'icon'=>'plus',
				'url'=>array('create'),
		),
);

?>

<h1>Галерии</h1>
<?php $this->widget('booster.widgets.TbExtendedGridView', array(
	'id'=>'galleries-grid',
	'sortableRows'=>true,
	'sortableAttribute' => 'galleryOrder',
	'sortableAjaxSave' => true,
	'sortableAction' => Yii::app()->createUrl("/admin/galleries/reorder"),
	'afterSortableUpdate' => 'js:function(sortOrder){ console.log(sortOrder);}',
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css',
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'galleryTitle',
		array(
				'class'=>'booster.widgets.TbButtonColumn',
				'template'=>'{update} {delete}',
				'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
)); ?>
