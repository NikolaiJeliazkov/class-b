<?php
/**
 *Gallery Manager _imageItem view file.
 *
 * @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */

$title=$item->title;
$desc=$item->desc;

?>
<div class="thumb_item" id="<?php echo $item->file_id ?>">
	<?php echo CHtml::link(CHtml::image($item->path . '/tmb/' . $item->file_id . '_100_100' . '_thumb' .$item->extension,'<h1>'. $title.'</h1>'
			, array('class' => 'tmb', 'id' => $item->file_id . '_thumb')),
			$item->path . '/' . $item->file_id . $item->extension,
			array('rel' => 'prettyPhoto[gid-'.$item->gid.']','title'=>$desc)); ?>
</div>
