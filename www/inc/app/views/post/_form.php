<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'users-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'postTitle', array('class'=>'span5')); ?><br/>
<?php echo $form->textCKEditor($model, 'postAnonce', array(), array(
	"config"=>array('skin'=>'v2', 'toolbarStartupExpanded' => false),
	"height"=>'200px',
	"width"=>'100%',
	"filespath"=>$_SERVER['DOCUMENT_ROOT']."/files/",
	"filesurl"=>Yii::app()->baseUrl."/files/",
)); ?><br/>
<?php echo $form->textCKEditor($model, 'postText', array(), array(
	"config"=>array('skin'=>'v2', 'toolbarStartupExpanded' => true),
	"height"=>'200px',
	"width"=>'100%',
	"filespath"=>$_SERVER['DOCUMENT_ROOT']."/files/",
	"filesurl"=>Yii::app()->baseUrl."/files/",
)); ?><br/>
<?php echo $form->textAutoCompleteRow($model, 'postTags', array('class'=>'span5'), array(
	'url'=>array('suggestTags'),
	'multiple'=>true,
)); ?><br/>
<?php echo $form->dropDownListRow($model, 'postStatus', Lookup::items('PostStatus'), array('class'=>'span5')); ?><br/>
<?php echo CHtml::htmlButton('<i class="icon-ok"></i> '.($model->isNewRecord ? 'Създай' : 'Запази'), array('class'=>'btn', 'type'=>'submit')); ?>
<?php $this->endWidget(); ?>
