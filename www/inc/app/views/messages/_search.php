<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>''),
	'id'=>'search-form',
	'type' => 'horizontal',
	'method'=>'get',
	'enableAjaxValidation'=>false,
));
echo $form->textFieldGroup($model, 'searchField', array('class'=>'col-sm-5'))."<br/>";
$this->widget(
		'booster.widgets.TbButton',
		array('buttonType' => 'submit', 'label' => 'Търси')
);

$this->endWidget();
