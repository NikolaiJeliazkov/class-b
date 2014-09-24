<?php
$this->breadcrumbs=array(
	'Съобщения'=>array('index'),
	(($model->getScenario()=='inbox')?'Входящи':'Изходящи'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('messages-grid', {
		data: $(this).serialize()
	});
	return false;
});


$('#messages-grid tbody tr:contains(\"Ново\")').css('font-weight','bold');


");



?>

<?php echo CHtml::link('търсене','#',array('class'=>'search-button')); ?>
<div class="search-form grid-view rounded" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="btn-toolbar">
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
	'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	'buttons'=>array(
		array('label'=>'Папки', 'items'=>array(
			array('label'=>'Входящи', 'url'=>$this->createUrl('inbox'), 'icon'=>'inbox'),
			array('label'=>'Изходящи', 'url'=>$this->createUrl('outbox'), 'icon'=>'outbox'),
		)),
	),
)); ?>
<?php if ($model->getScenario()=='inbox') : ?>
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
	'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	'buttons'=>array(
		array('label'=>'Ново съобщение', 'url'=>$this->createUrl('send'), 'icon'=>'envelope'),
		array('label'=>'Изтрий маркираните', 'url'=>'#', 'icon'=>'remove', 'htmlOptions'=>array('onClick'=>'return DeleteAll();')),
		array('label'=>'Маркирай като прочетени', 'url'=>'#', 'icon'=>'ok', 'htmlOptions'=>array('onClick'=>'return MarkAsRead();')),
	),
)); ?>
<?php endif; ?>
</div>

<?php
// echo CHtml::ajaxLink("Show Selected", $this->createUrl('getvalue'), array("type" => "post",
// 	"data" => "js:{ids:$.fn.yiiGridView.getChecked('messages-grid','ids')}",
// 	"update" => "#output"));
// echo '<div id="output"></div>';
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'messages-grid',
	'dataProvider'=>$model->search(),
	'pager' => array('cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css'),
	'cssFile' => Yii::app()->baseUrl . '/css/gridViewStyle/gridView.css',
// 	'summaryText' => 'Yiiplayground is showing you {start} - {end} of {count} cool records',
	'selectionChanged'=>"js:getInfo",
// 	'selectionChanged'=>"function(id){if ($.fn.yiiGridView.getSelection(id) != '') {window.location='" . Yii::app()->createUrl('messages/view/id') . "' + '/' + $.fn.yiiGridView.getSelection(id);}}",
	'htmlOptions' => array('class' => 'grid-view rounded'),
	'rowCssClassExpression'=>'$data["messageStatus"]==0?"bold":"normal"',
// 	'rowCssClassExpression'=>'  $this->dataProvider->data[$row]->messageStatus ? "bold" : "normal"',
// 	'rowCssClassExpression'=>'$data->color',
	'columns'=>array(
		array(
			'class' => 'CCheckBoxColumn',
			'id' => 'ids',
			'selectableRows' => '2',
		),
// 		array('name'=>'messageId','header'=>$model->getAttributeLabel('messageId')),
		array('name'=>'messageSubject','header'=>$model->getAttributeLabel('messageSubject')),
		array('value'=> 'Users::getUserLabel(intval($data[\'messageFromUserId\']))', 'name'=>'messageFrom','header'=>$model->getAttributeLabel('messageFrom'), 'visible'=>($model->getScenario()=='inbox')),
// 		array('name'=>'messageFromStudent','header'=>$model->getAttributeLabel('messageFromStudent'), 'visible'=>($model->getScenario()=='inbox')),
		array('value'=> 'Users::getUserLabel(intval($data[\'messageToUserId\']))', 'name'=>'messageTo','header'=>$model->getAttributeLabel('messageTo'), 'visible'=>($model->getScenario()=='outbox')),
// 		array('name'=>'messageToStudent','header'=>$model->getAttributeLabel('messageToStudent'), 'visible'=>($model->getScenario()=='outbox')),
		array('name'=>'messageDate','header'=>$model->getAttributeLabel('messageDate')),
),
)); ?>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'actions-form',
)); ?>
<?php echo $form->hiddenField($model, 'action'); ?>
<?php echo $form->hiddenField($model, 'ids'); ?>
<?php $this->endWidget(); ?>





<?php
Yii::app()->clientScript->registerScript('get_info', "
var getInfo = function(id){
	i = parseInt($.fn.yiiGridView.getSelection(id));
	if (i>0) {
		document.location.href='".$this->createUrl($model->getScenario())."/'+i;
	}
};
function DeleteAll(){
	var ids = $.fn.yiiGridView.getChecked('messages-grid','ids');
	if (ids == '') {
		alert('Не сте избрали съобщение');
	} else {
		if (confirm('Потвърдете изтриването')) {
			$('#Messages_action').val('delete');
			$('#Messages_ids').val(ids);
			$('#actions-form').submit();
		}
	}
	return false;
};
function MarkAsRead(){
	var ids = $.fn.yiiGridView.getChecked('messages-grid','ids');
	if (ids == '') {
		alert('Не сте избрали съобщение');
	} else {
		$('#Messages_action').val('read');
		$('#Messages_ids').val(ids);
		$('#actions-form').submit();
	}
	return false;
};

",CClientScript::POS_END);
?>