<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php
echo $form->errorSummary($model);
echo $form->textFieldGroup($model, 'userName', array('class'=>'col-sm-5'));
echo $form->passwordFieldGroup($model, 'userPass', array('class'=>'col-sm-5'));
echo $form->passwordFieldGroup($model, 'userPass_repeat', array('class'=>'col-sm-5'));
echo $form->textFieldGroup($model, 'userFullName', array('class'=>'col-sm-5'));
echo $form->dropDownListGroup($model, 'studentId',
	array(
			'wrapperHtmlOptions' => array(
					'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
					'data' => $model->getStudentsList(),
					'htmlOptions' => array(),
			)
	)
);
echo $form->textFieldGroup($model, 'userEmail', array('class'=>'col-sm-5'));
echo $form->textFieldGroup($model, 'userPhones', array('class'=>'col-sm-5'));
//echo $form->checkBoxRow($model, 'userIsVisible', array());
if(Yii::app()->user->getState('userType')>2) {
	echo $form->textAreaGroup($model, 'notes', array('class'=>'col-sm-5', 'rows'=>3));
}
$this->widget(
		'booster.widgets.TbButton',
		array('buttonType' => 'submit', 'label' => ($model->isNewRecord ? 'Създай' : 'Запази'), 'icon'=>'ok')
);
$this->endWidget();


