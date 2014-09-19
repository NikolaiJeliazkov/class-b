<?php
$this->breadcrumbs=array(
	'Нова статия',
);
?>
<h1>Нова статия</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>