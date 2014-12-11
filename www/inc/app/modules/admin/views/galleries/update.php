<?php
$this->breadcrumbs=array(
	'Галерии'=>array('index'),
	$model->galleryTitle,
);

?>

<h1><?php echo $model->galleryTitle; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'article'=>$article)); ?>
