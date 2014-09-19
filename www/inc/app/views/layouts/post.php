<?php $this->beginContent('//layouts/main'); ?>
<div id="content-container">

<div id="content">
	<?php echo $content; ?>
</div><!-- content -->

<div id="sidebar">
<?php
// 	$this->beginWidget('zii.widgets.CPortlet', array(
// 		'title'=>'&nbsp;',
// 	));
// 	$this->widget('ext.visualsearch.VisualSearch', array(
// 		'id'=>'vs111',
// 	));
// 	$this->endWidget();
?>




<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'&nbsp;',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'operations'),
	));
	$this->endWidget();
?>
<?php
	$this->widget('TagCloud', array('maxTags'=>Yii::app()->params['tagCloudCount'],));
?>
<?php
// 	$this->widget('RecentPosts', array('maxComments'=>Yii::app()->params['recentPostsCount'],));
?>


</div><!-- sidebar -->

</div><!-- content-container -->

<?php $this->endContent(); ?>