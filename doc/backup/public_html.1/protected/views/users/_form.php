<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'userName', array('class'=>'span5')); ?><br/>
<?php echo $form->passwordFieldRow($model, 'userPass', array('class'=>'span5')); ?><br/>
<?php echo $form->passwordFieldRow($model, 'userPass_repeat', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'userFullName', array('class'=>'span5')); ?><br/>
<?php echo $form->dropDownListRow($model, 'studentId', $model->getStudentsList(), array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'userEmail', array('class'=>'span5')); ?><br/>
<?php echo $form->textFieldRow($model, 'userPhones', array('class'=>'span5')); ?><br/>
<?php echo $form->checkBoxRow($model, 'userIsVisible', array()); ?><br/>
<?php if(Yii::app()->user->getState('userType')>2) :?>
<?php echo $form->textAreaRow($model, 'notes', array('class'=>'span5', 'rows'=>3)); ?><br/>
<?php endif ?>
<?php echo CHtml::htmlButton('<i class="icon-ok"></i> '.($model->isNewRecord ? 'Създай' : 'Запази'), array('class'=>'btn', 'type'=>'submit', 'name'=>'btn1')); ?>
<?php $this->endWidget(); ?>
