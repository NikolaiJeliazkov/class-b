<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php
echo $form->errorSummary($model);
echo $form->hiddenField($model, 'messageParent');
echo $form->dropDownListGroup($model, 'messageTo',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => CHtml::listData($model->getAddressBook(),'id','text','group'),
				'htmlOptions' => array(),
			)
		)
);
echo $form->textFieldGroup($model, 'messageSubject', array('class'=>'col-sm-5'));
echo "<div class='form-group'><label class='control-label'>".$model->getAttributeLabel('messageText')."</label>";
$this->widget('ext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
	'id' => 'messageText',
	'model' => $model,
	'attribute' => 'messageText',
	'plugins' => array(
		'imagemanager'=>array('js' => array('imagemanager.js')),
	),
	'options' => array(
		'lang' => 'bg',
		'toolbar' => true,
		'buttonSource' => true,
		'iframe' => true,
		'imageUpload'=>Yii::app()->createUrl('messages/imageUpload',array('attr'=>'images')),
		'imageUploadErrorCallback'=>new CJavaScriptExpression(
				'function(obj,json) { alert(obj.error); }'
		),
		'imageManagerJson' => Yii::app()->createUrl('messages/imageList',array('attr'=>'images')),
		'imageEditable' => true,
		'fileUpload' => Yii::app()->createUrl('messages/fileUpload',array('attr'=>'files')),
		'fileUploadErrorCallback'=>new CJavaScriptExpression(
				'function(obj,json) { alert(obj.error); }'
		),
		'css' => '/css/main.css',
	),
));
echo "</div>\n";
$this->widget(
		'booster.widgets.TbButton',
		array('buttonType' => 'submit', 'label' => 'Изпрати', 'icon'=>'ok')
);
$this->endWidget();


