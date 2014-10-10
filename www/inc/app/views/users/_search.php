<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>''),
	'id'=>'search-form',
	'type' => 'horizontal',
	'method'=>'get',
	'enableAjaxValidation'=>false,
));
echo $form->textFieldGroup($model, 'userName', array('class'=>'col-sm-5'))."<br/>";
echo $form->textFieldGroup($model, 'userFullName', array('class'=>'col-sm-5'))."<br/>";
echo $form->textFieldGroup($model, 'userEmail', array('class'=>'col-sm-5'))."<br/>";
$this->widget(
		'booster.widgets.TbButton',
		array('buttonType' => 'submit', 'label' => 'Търси')
);

$this->endWidget();
