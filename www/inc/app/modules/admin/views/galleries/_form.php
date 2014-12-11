<?php
$form = $this->beginWidget ( 'booster.widgets.TbActiveForm', array (
	// 'htmlOptions'=>array('class'=>'well'),
	'id' => 'galleries-form',
	// 'type'=>'horizontal',
	'enableAjaxValidation' => false
// 'inlineErrors'=>true,
// 'htmlOptions' => array('enctype' => 'multipart/form-data'),
) );
$images = Images::model ();
$images->galleryId = $model->galleryId;

echo $form->errorSummary ( $model );
echo $form->errorSummary ( $images );
?>
<?php echo $form->textFieldGroup($model, 'galleryTitle', array('class'=>'span12')); ?>
<div class="form-actions">
	<?php echo CHtml::htmlButton('<i class="icon-ok icon-white"></i> '.($model->isNewRecord?'Създай':'Запази'), array('class'=>'btn btn-primary', 'type'=>'submit', 'name'=>'btn1')); ?>
	&nbsp;
	<?php echo CHtml::htmlButton('<i class="icon-ban-circle"></i> Изчисти', array('class'=>'btn', 'type'=>'reset')); ?>
</div>
<?php

if (! $model->isNewRecord) {
	echo "<br />\n";
	// the button that may open the dialog
	$this->widget ( 'booster.widgets.TbButton', array (
	'buttonType' => 'button',
	'label' => 'Нова картинка',
	'htmlOptions'=> array('onclick' => new CJavaScriptExpression ('$(\'#mydialog\').dialog(\'open\'); return false;')),
	) );

// 	$this->widget ( 'booster.widgets.TbFileUpload', array (
// 		'url' => Yii::app ()->createUrl ( "/admin/galleries/update", array (
// 			"id" => $model->galleryId
// 		) ),
// 		'model' => $model,
// 		'attribute' => 'image', // see the attribute?
// 		'multiple' => true,
// 		'options' => array (
// 			'maxFileSize' => 2000000,
// 			'acceptFileTypes' => 'js:/(\.|\/)(gif|jpg|jpeg|png)$/i'
// 		)
// 	) );

	$gridDataProvider = $images->search ();
	$this->widget ( 'booster.widgets.TbExtendedGridView', array (
		'filter' => $person,
		'type' => 'striped bordered',
		'dataProvider' => $gridDataProvider,
		'template' => "{items}",
		'sortableRows' => true,
		'sortableAttribute' => 'imageOrder',
		'sortableAjaxSave' => true,
		'sortableAction' => Yii::app ()->createUrl ( "/admin/galleries/imagesReorder" ),
		'hideHeader' => true,
		'columns' => array (
			array (
				'class' => 'booster.widgets.TbImageColumn',
				'imagePathExpression' => '$data[\'imagePath\'].\'/\'.$data[\'galleryId\'].\'/tmb/\'.$data[\'imageBaseName\']'
			),
			array (
				'name' => 'imageDescription',
				'class' => 'booster.widgets.TbEditableColumn',
				'editable' => array (
					'type' => 'textarea',
					'url' => Yii::app ()->createUrl ( "/admin/galleries/imageUpdate" )
				)
			),
			array (
				'class' => 'booster.widgets.TbButtonColumn',
				'template' => '{delete}',
				'deleteButtonUrl' => 'Yii::app()->createUrl("/admin/galleries/imageDelete", array("id" => $data[\'imageId\']))',
				'htmlOptions' => array (
					'style' => 'width: 25px'
				)
			)
		)
	) );
}
?>

<?php $this->endWidget(); ?>
<?php

if (! $model->isNewRecord) {

	$this->beginWidget ( 'zii.widgets.jui.CJuiDialog', array (
		'id' => 'mydialog',
		// additional javascript options for the dialog plugin
		'options' => array (
			'title' => 'Нова картинка',
			'autoOpen' => false,
			// 'height'=>250,
			'width' => 500,
			'buttons' => array (
				array (
					'text' => 'Зареди',
					'click' => 'js:function(){$("#images-form").submit();}'
				),
				array (
					'text' => 'Откажи',
					'click' => 'js:function(){$(this).dialog("close");}'
				)
			)
		)
	) );
	$form = $this->beginWidget ( 'booster.widgets.TbActiveForm', array (
		// 'htmlOptions'=>array('class'=>'well'),
		'id' => 'images-form',
		// 'type'=>'horizontal',
		'enableAjaxValidation' => false,
		// 'inlineErrors'=>true,
		'htmlOptions' => array (
			'enctype' => 'multipart/form-data'
		)
	) );
	echo $form->textFieldGroup ( $images, 'imageDescription', array (
		'class' => 'span6'
	) );
	echo $form->fileFieldGroup ( $images, 'image' );
	$this->endWidget ();

	$this->endWidget ( 'zii.widgets.jui.CJuiDialog' );
}
?>