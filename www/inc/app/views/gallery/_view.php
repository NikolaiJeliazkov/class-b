<?php
$a = Gallery::model('Gallery');
$a->scenario = 'preview';
$a = $a->findByPk($data['galleryId']);
$dp = GalleryImage::search($data['galleryId'], 1);
$data = $dp->getData();
$data = $data[0];
?>
<div class="thumb_item" id="img_<?php echo $data['imageId']; ?>">
<?php echo CHtml::link(
	CHtml::image($data['imagePath'].'/'.$data['galleryId'].'/tmb/'.$data['imageBaseName'], $a->galleryTitle, array('class'=>'tmb', 'id'=>'thumb_'.$data['imageId'])).
	CHtml::tag('div', array('class'=>'title'), $a->galleryTitle),
	array('view', 'id'=>$a->galleryId),
	array('rel' => 'prettyPhoto[gid-'.$data['galleryId'].']','title'=>$a->galleryTitle)
); ?>
</div>
