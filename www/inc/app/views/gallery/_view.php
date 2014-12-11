<?php
$a = Gallery::model ( 'Gallery' );
$a->scenario = 'preview';
$a = $a->findByPk ( $data ['galleryId'] );
$dp = GalleryImage::search ( $data ['galleryId'], 3 );
$data = $dp->getData ();
?>
<div class="thumb_item post" id="img_<?php echo $data['imageId']; ?>">
<?php
foreach ( $data as $dd ) {
	$imgs .= CHtml::image ( $dd ['imagePath'] . '/' . $dd ['galleryId'] . '/tmb/' . $dd ['imageBaseName'], $a->galleryTitle, array (
		'class' => 'tmb',
		'id' => 'thumb_' . $dd ['imageId']
	) );
	$imgs .= " ";
}
echo CHtml::tag ( 'h3', array (
	'class' => 'title'
), CHtml::link ( $a->galleryTitle, array (
	'view',
	'id' => $a->galleryId
), array (
	'rel' => 'prettyPhoto[gid-' . $dd ['galleryId'] . ']',
	'title' => $a->galleryTitle
) ) );
echo CHtml::link ( $imgs, array (
	'view',
	'id' => $a->galleryId
), array (
	'rel' => 'prettyPhoto[gid-' . $dd ['galleryId'] . ']',
	'title' => $a->galleryTitle
) );
?>
;
</div>
<br />
