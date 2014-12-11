<div class="thumb_item" id="<?php echo $data['imageFileId']; ?>" style="display:inline">
<?php echo CHtml::link(
	CHtml::image($data['imagePath'].'/'.$data['galleryId'].'/tmb/'.$data['imageBaseName'], $data['imageDescription'], array('class'=>'tmb', 'id'=>$data['imageFileId'].'_thumb')).
	'', //CHtml::tag('div', array('class'=>'title'), $data['imageDescription']),
	$data['imagePath'] . '/' . $data['galleryId'] . '/' . $data['imageBaseName'],
	array('rel' => 'prettyPhoto[gid-'.$data['galleryId'].']','title'=>$data['imageDescription'])
); ?>
</div>
