<?php
$this->pageTitle=Yii::app()->name . ' - Вход';
$this->breadcrumbs=array(
	'Вход',
);
?>
<h2 class="title">Вход</h2>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'login-form',
	'htmlOptions'=>array('class'=>'well'),
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'userName', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'userPass', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>
<?php echo CHtml::htmlButton('<i class="icon-ok"></i> Вход', array('class'=>'btn', 'type'=>'submit')); ?>
<?php $this->endWidget(); ?>
