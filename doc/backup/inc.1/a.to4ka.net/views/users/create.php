<?php
$this->breadcrumbs=array(
	'Потребители'=>array('index'),
	'Нов',
);

$this->menu=array(
	array('label'=>'Потебители', 'url'=>array('admin')),
);
?>

<h1>Нов потебител</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>