<div id="gallery_form_con">
	<!--<div  id="ajaxstatus" class="hide"  ></div>-->


	<?php if (isset($model->id)) :?>
	<h3 id="update_header">
		<?php echo Yii::t('ImgManagerModule.admincomment','Update')?>
		<?php echo $model->title ?>
	</h3>
	<?php else: ?>
	<h3 id="update_header">
		<?php echo Yii::t('ImgManagerModule.admincomment','Create A New Gallery');?>
	</h3>
	<?php endif; ?>
	<div id="success-gallery" class="notification success png_bg"
		style="display: none;"></div>

	<div id="error-gallery" class="notification errorshow png_bg"
		style="display: none;"></div>
	<div class="form">
		<?php

		$formId='gallery-form';

		$ajaxUrl=$this->createUrl('index');
		//$this->action->id=='article'?$ajaxUrl=CController::createUrl('article/saveComment')
		//                                         :$ajaxUrl=CController::createUrl('comment/update/id/'.$model->id);
		(!isset($model->id))?$val_error_msg=Yii::t('ImgManagerModule.adminimages','The Gallery has not been created.')
		:$val_error_msg=Yii::t('ImgManagerModule.adminimages','Gallery') .$model->title.' '.Yii::t('ImgManagerModule.admincomment','was not updated') ;
		(!isset($model->id))?$val_success_message=Yii::t('ImgManagerModule.adminimages','The Gallery has been successfully created.')
		:$val_success_message=Yii::t('ImgManagerModule.adminimages','Gallery') .' '.$model->title. ' '.Yii::t('ImgManagerModule.admincomment','was updated') ;


		$this->action->id !='article'?
		$updatesuccess='$("#update_header").hide();   ':

		$updatesuccess='';



		$success='function(data){
		var response= jQuery.parseJSON (data);
		if (response.success ==true)
		{
		$("#success-gallery")
		.fadeOut(1000, "linear",function(){
		$(this).addClass("success")
		.html("<div> '.$val_success_message.'</div>")
		.fadeIn(2000, "linear")
}
);
$("#error-gallery").hide();
$("#gallery-form").slideToggle(1500);
'.
$updatesuccess.
'}
else {
$("#error-gallery").hide() .addClass("error").html("<div>'.$val_error_msg .'</div>").fadeIn(2000);
//     $("#gallery-form").each(function(){this.reset();});
}
}//function';

		$js_afterValidate="js:function(form,data,hasError) {
		var arr=form.toArray();


		if (!hasError) {                         //if there is no error submit with  ajax
		jQuery.ajax({'type':'POST',
		'url':'$ajaxUrl',
		'cache':false,
		'data':$(\"#$formId\").serialize(),
		'success':$success
});
return false; //cancel submission with regular post request,ajax submission performed above.
} //if has not error submit via ajax

else{                                                //if there is validation error don't send anything
//$(\"#ajaxstatus\").hide()
//.addClass(\"flash-error\")
// .html('$val_error_msg').fadeIn(2000);
//   $(\"#comment-form\").each (function(){this.reset(); });
//    $(\"#comment-form_es_\").hide().fadeIn(2000);
return false;  //cancel submission with regular post request,validation has errors.
}
}";


		$form=$this->beginWidget('CActiveForm', array(
				'id'=>$formId,

				// 'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
				'focus'=>array($model,'title'),
				'errorMessageCssClass' => 'input-notification-error  error-simple png_bg',
				'clientOptions'=>array('validateOnSubmit'=>true,
						'validateOnType'=>false,
						'afterValidate'=>$js_afterValidate,
						'errorCssClass' => 'err',
						'successCssClass' => 'suc',
						'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
						if(!hasError){
						$("#success-"+attribute.id).fadeIn(500);
						$("label[for=\'Gal_"+attribute.name+"\']").removeClass("error");
}else {
						$("label[for=\'Gal_"+attribute.name+"\']").addClass("error");
						$("#success-"+attribute.id).fadeOut(500);
}

}'
				),
)); ?>
		<?php echo $form->errorSummary($model, '<div style="font-weight:bold">'.Yii::t('ImgManagerModule.adminmenu', 'Please Correct these errors:').'</div>', NULL, array('class' => 'errorsum notification errorshow png_bg')); ?>
		<?php //echo $form->errorSummary($model); ?>
		<p class="note">
			<?php echo Yii::t('ImgManagerModule.adminmenu', 'Fields with <span class="required">*</span> are required.')?>
		</p>

		<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
			<span id="success-Gal_title" class="hid input-notification-success  success png_bg"></span>
			<?php echo $form->error($model,'title'); ?>
		</div>
<!--
		<div class="row">
			<?php echo $form->labelEx($model,'tr_title'); ?>
			<?php echo $form->textField($model,'tr_title',array('size'=>60,'maxlength'=>128)); ?>
			<span id="success-Gal_tr_title" class="hid input-notification-success  success png_bg"></span>
			<?php echo $form->error($model,'tr_title'); ?>
		</div>
 -->
		<div class="row">
			<?php echo $form->labelEx($model,'g_desc'); ?>
			<?php echo $form->textArea($model,'g_desc',array('maxlength'=>512)); ?>
			<span id="success-Gal_g_desc" class="hid input-notification-success  success png_bg"></span>
			<?php echo $form->error($model,'g_desc'); ?>
		</div>
<!-- 		<div class="row">
			<?php echo $form->labelEx($model,'tr_desc'); ?>
			<?php echo $form->textArea($model,'tr_desc',array('maxlength'=>512)); ?>
			<span id="success-Gal_tr_desc" class="hid input-notification-success  success png_bg"></span>
			<?php echo $form->error($model,'tr_desc'); ?>
		</div>
 -->
		<?php if (!$model->isNewRecord):?>
		<div class="row">
			<?php echo $form->hiddenField($model,'update_galid',array('value'=>$model->id)); ?>
		</div>
		<?php endif;?>

		<div class="row buttons">
			<?php

			echo  CHtml::submitButton($model->isNewRecord ? Yii::t('ImgManagerModule.admincomment', 'Submit') : Yii::t('ImgManagerModule.admincomment', 'Save'),array('class' => 'button'));
			?>
		</div>

		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->

</div>
