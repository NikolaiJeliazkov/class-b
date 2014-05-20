<?php
$this->breadcrumbs=array(
	'Съобщения'=>array('index'),
	(($model->getScenario()=='inbox')?'Входящи':'Изходящи') => (($model->getScenario()=='inbox')?array('inbox'):array('outbox')),
	$model->messageSubject,
);

if ($model->getScenario()=='inbox') {
	$buttons = array(
		array('label'=>'Отговори', 'url'=>$this->createUrl('send',array('id'=>$model->messageId)), 'icon'=>'chevron-left'),
// 		array('label'=>'Препрати', 'url'=>'#', 'icon'=>'chevron-right'),
		array('label'=>'Изтрий',   'url'=>'javascript:confirmDeletion()', 'icon'=>'remove'),
	);

	echo '<div class="btn-toolbar">';
	$this->widget('bootstrap.widgets.BootButtonGroup', array(
		'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'buttons'=>$buttons,
	));
	echo '</div>';
}

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/detailViewStyle/styles.css',
	'attributes'=>array(
		(($model->getScenario()=='inbox')?'messageFrom':'messageTo'),
		(($model->getScenario()=='inbox')?'messageFromStudent':'messageToStudent'),
		'messageDate',
		'messageSubject',
		'messageText:ntext',
	),
));

Yii::app()->clientScript->registerScript('get_info', "
function confirmDeletion() {
	if (confirm('Потвърдете изтриването')) {
		document.location.href='".$this->createUrl('delete', array('id'=>$model->messageId))."';
	}
};

",CClientScript::POS_END);
?>