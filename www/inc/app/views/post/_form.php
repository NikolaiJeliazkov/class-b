<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php
echo $form->errorSummary($model);
echo $form->textFieldGroup($model, 'postTitle', array('class'=>'span5'));
echo "<div class='form-group'><label class='control-label'>".$model->getAttributeLabel('postAnonce')."</label>";
$this->widget('ext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
	'id' => 'postAnonce',
	'model' => $model,
	'attribute' => 'postAnonce',
	'plugins' => array(
		'imagemanager'=>array('js' => array('imagemanager.js')),
	),
	'options' => array(
		'lang' => 'bg',
		'toolbar' => true,
		'buttonSource' => true,
		'iframe' => true,
		'imageUpload'=>Yii::app()->createUrl('files/imageUpload',array('attr'=>'images')),
		'imageUploadErrorCallback'=>new CJavaScriptExpression(
			'function(obj,json) { alert(obj.error); }'
		),
		'imageManagerJson' => Yii::app()->createUrl('files/imageList',array('attr'=>'images')),
		'imageEditable' => true,
		'css' => '/css/main.css',
	),
));
echo "</div>\n";
echo "<div class='form-group'><label class='control-label'>".$model->getAttributeLabel('postText')."</label>";
$this->widget('ext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
	'id' => 'postText',
	'model' => $model,
	'attribute' => 'postText',
	'plugins' => array(
		'imagemanager'=>array('js' => array('imagemanager.js')),
	),
	'options' => array(
		'lang' => 'bg',
		'toolbar' => true,
		'buttonSource' => true,
		'iframe' => true,
		'imageUpload'=>Yii::app()->createUrl('files/imageUpload',array('attr'=>'images')),
		'imageUploadErrorCallback'=>new CJavaScriptExpression(
				'function(obj,json) { alert(obj.error); }'
		),
		'imageManagerJson' => Yii::app()->createUrl('files/imageList',array('attr'=>'images')),
		'imageEditable' => true,
	),
));
echo "</div>\n";
echo "<div class='form-group'><label class='control-label'>".$model->getAttributeLabel('postTags')."</label>";
$this->widget('CAutoComplete', array(
	'model'=>$model,
	'attribute'=>'postTags',
	'url'=>array('suggestTags'),
	'multiple'=>true,
	'htmlOptions'=> array('class' => 'form-control'),
));
echo "</div>\n";
echo $form->dropDownListGroup($model, 'postStatus',
		array(
			'wrapperHtmlOptions' => array(
				'class' => 'col-sm-5',
			),
			'widgetOptions' => array(
				'data' => Lookup::items('PostStatus'),
				'htmlOptions' => array(),
			)
		)
);
$this->widget(
		'booster.widgets.TbButton',
		array('buttonType' => 'submit', 'label' => ($model->isNewRecord ? 'Създай' : 'Запази'), 'icon'=>'ok')
);
$this->endWidget();

