<?php
$this->breadcrumbs=array(
	'Съобщения'=>array('index'),
	(($model->getScenario()=='inbox')?'Входящи':'Изходящи') => (($model->getScenario()=='inbox')?array('inbox'):array('outbox')),
	$model->messageSubject,
);

if ($model->getScenario()=='inbox') {
	$buttons = array(
		array('label'=>'Отговори', 'icon'=>'chevron-left', 'htmlOptions'=>array('onClick'=>'window.location.href="'.$this->createUrl('send',array('id'=>$model->messageId)).'"')),
		array('label'=>'Изтрий',   'icon'=>'remove',       'htmlOptions'=>array('onClick'=>'return confirmDeletion()')),
	);

	echo '<div class="btn-toolbar">';
	$this->widget('booster.widgets.TbButtonGroup', array(
		'context'=>'default',
		'buttons'=>$buttons,
	));
	echo '</div>';
}

$this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
	'cssFile' => Yii::app()->baseUrl . '/css/detailViewStyle/styles.css',
	'attributes'=>array(
		(($model->getScenario()=='inbox')?
			array(
				'name'=>'messageFrom',
				'value'=>Users::getUserLabel(intval($model->messageFromUserId)),
			)
			:
			array(
				'name'=>'messageTo',
				'value'=>Users::getUserLabel(intval($model->messageToUserId)),
			)
		),
		'messageDate',
		'messageSubject',
		'messageText:html',
	),
));

Yii::app()->clientScript->registerScript('get_info', "
function confirmDeletion() {
	if (confirm('Потвърдете изтриването')) {
		document.location.href='".$this->createUrl('delete', array('id'=>$model->messageId))."';
	}
};

",CClientScript::POS_END);



Controller::trace(Users::getUserLabel(intval($model->messageFromUserId)));
