<?php
$this->breadcrumbs=array(
	'Снимки'=>$this->createUrl('/gallery'),
	$m->galleryTitle,
);
$this->pageTitle=$m->galleryTitle;

YiiUtil::registerCssAndJs('ext.fancyBox',
'/source/jquery.fancybox.pack.js',
'/source/jquery.fancybox.css');

?>
<div class="post">
	<h3 class="title"><?php echo CHtml::link(CHtml::encode($m->galleryTitle), array('view', 'id'=>$m->galleryId)); ?></h3>
<?php
$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
echo $m->galleryText;
$this->endWidget();
?>
	<div class="thumbs-wrapper clearfix">
<?php
$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>GalleryImage::search($m->galleryId),
		'itemView'=>'_imageItem',
		'template'=>"{items}",
		'cssFile'=>false,
));
?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("a[rel^='prettyPhoto']").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
});
</script>