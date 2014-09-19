<?php
$this->breadcrumbs=array(
	'Съобщения'=>array('index'),
	'Ново съобщение',
);

?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>