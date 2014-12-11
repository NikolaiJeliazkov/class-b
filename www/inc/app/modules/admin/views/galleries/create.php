<?php
$this->breadcrumbs=array(
	'Галерии'=>array('index'),
	'Добавяне на галерия',
);
?>

<h1>Добавяне на галерия</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>
