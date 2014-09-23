<?php
/**
 * Gallery  Management  imgitem view file in Admin Page.
 *
 * @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */


$iconfolder = YiiBase::getPathOfAlias('imgManager.images.icons');
$iconbaseUrl = Yii::app()->assetManager->publish($iconfolder);
$data=$this->item;
//Used in img tag,to set the title and description for Pretty Photo
$title=(Yii::app()->language=='en')?$data->title:(($data->tr_title!=null&&$data->tr_title!='')?$data->tr_title:$data->title);
$desc=(Yii::app()->language=='en')?$data->desc:(($data->tr_desc!=null&&$data->tr_desc!='')?$data->tr_desc:$data->desc);
?>

<div class="thumb_item" id="<?php echo $data->file_id ?>">
	<div id="<?php echo $data->title?>" class=" tit hidden"></div>
	<div id="<?php echo $galid?>" class="gal  hidden"></div>
	<div id="<?php echo $data->file_id ?>_title" class="img_title">
		<?php echo html_entity_decode($data->title); ?>
	</div>

	<?php
	echo CHtml::link(CHtml::image($iconbaseUrl . '/pencil.png',
			'Edit info',
			array('id' => $data->file_id . '_editimg')),
			'#',
			array('class' => 'fan',
					'id' => $data->file_id . '_link',
					'title'=>   Yii::t('ImgManagerModule.adminimages','Edit')                                      )
	);
	?>


	<?php
	echo CHtml::link(CHtml::image($iconbaseUrl . '/cross.png', 'delete image'),
			'#', array(
					'id' => 'delete_' . $data->file_id,
					'class' => 'del_link',
					'title'=>Yii::t('ImgManagerModule.adminimages','Delete')
			));
	?>

	<div>
		<?php


		echo CHtml::link(CHtml::image($data->path . '/tmb/' . $data->file_id . '_100_100' . '_thumb' . $data->extension,$title
				, array('class' => 'tmb', 'id' => $data->file_id . '_thumb')),
				$data->path . '/' . $data->file_id . $data->extension,
                                              array('rel' => 'prettyPhoto[pp_gal]','title'=>$desc)); ?>
	</div>

</div>



<?php echo CHtml::hiddenField('path', $data->path,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php  echo CHtml::hiddenField('basename', $data->basename,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('extension', $data->extension,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('file_id', $data->file_id,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('title', $data->title,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('url', $data->url,array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('echojson','false',array('class'=>'fileinfo'.$data->file_id)); ?>
<?php echo CHtml::hiddenField('galid',$galid,array('class'=>'fileinfo'.$data->file_id)); ?>


