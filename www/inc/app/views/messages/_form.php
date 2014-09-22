<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'htmlOptions'=>array('class'=>'well'),
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">Полетата маркирани със <span class="required">*</span> са задължителни.</p>
<?php echo $form->errorSummary($model); ?>
<?php
// echo $form->textAutoCompleteRow($model, 'messageTo', array('class'=>'span9'), array(
// 	'url'=>array('suggestUsers'),
// 	'multiple'=>true,
// ));
?><br/>
<?php $data = CHtml::listData($model->getAddressBook(),'id','text','group'); ?>
<?php echo $form->hiddenField($model, 'messageParent'); ?>
<?php echo $form->dropDownListRow($model, 'messageTo', $data, array('class'=>'span9')); ?><br/>
<?php echo $form->textFieldRow($model, 'messageSubject', array('class'=>'span9')); ?><br/>
<?php //echo $form->textAreaRow($model, 'messageText', array('class'=>'span9', 'rows'=>10)); ?><br/>
<?php
echo $form->textCKEditor($model, 'messageText', array(), array(
	"config"=>array('skin'=>'v2', 'toolbarStartupExpanded' => true),
	"height"=>'200px',
	"width"=>'100%',
	"filespath"=>$_SERVER['DOCUMENT_ROOT']."/files/",
	"filesurl"=>Yii::app()->baseUrl."/files/",
));
?><br/>

<?php echo CHtml::htmlButton('<i class="icon-ok"></i> Изпрати', array('class'=>'btn', 'type'=>'submit', 'name'=>'btn1')); ?>
<?php $this->endWidget(); ?>



