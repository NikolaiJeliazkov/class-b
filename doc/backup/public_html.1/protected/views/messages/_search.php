<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'searchForm',
    'type'=>'search',
//     'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->textFieldRow($model, 'searchField', array('class'=>'input-medium')); ?>
<?php echo CHtml::htmlButton('<i class="icon-search"></i> Търси', array('class'=>'btn','type'=>'submit')); ?>

<?php $this->endWidget(); ?>
