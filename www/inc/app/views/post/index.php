<?php
$this->menu=array(
		array('label'=>'Нова статия', 'url'=>array('create'),'visible'=>Yii::app()->user->getState('userType')>2),
);

?>

<?php if(!empty($_GET['tag'])): ?>
<h1>
	Статии отбелязани с <i><?php echo CHtml::encode($_GET['tag']); ?> </i>
</h1>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'template'=>"{items}\n{pager}",
		'pager'=>array('cssFile'=>Yii::app()->baseUrl . '/css/listViewStyle/pager.css',),
)); ?>
