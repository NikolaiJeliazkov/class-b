<?php
/**
 * $Id: form.php 1175 2014-11-22 13:00:32Z atonkin $
 * @var $model Document
 */
$attachments = $model->images;
$hasAttachments = !empty($attachments);
?>

<!-- The table listing the files available for upload/download -->
<div class="row-fluid">
	<table class="items table table-striped table-bordered table-condensed">
		<thead class="files-header" <?php if(!$hasAttachments): ?>style="display: none;"<?php endif; ?>>
			<tr>
				<th style="width: 1%; text-align: center;"></th>
				<th style="width: 1%; text-align: center;"></th>
				<th>Файл</th>
				<th></th>
			</tr>
		</thead>
		<tbody class="files"><?php if(is_array($attachments)): ?>
<?php foreach($attachments as $attachment): ?><tr class="template-download<?php if(!$hasAttachments): ?> fade<?php endif; ?>">
				<td><i class="glyphicon glyphicon-paperclip"></i></td>
				<td class="delete"><a href="#" data-toggle="tooltip"
					title="Премахни" data-type="POST"
					data-url="<?php

echo Yii::app()->controller->createUrl('/attachments/delete', array(
                        'id' => $attachment->fileHash,
                        'context' => get_class($model) . '-' . $model->id,
                        'method' => 'uploader'
                    ));
                    ?>"> <i class="glyphicon glyphicon-trash"></i>
				</a></td>
				<td class="name"><span><?php echo $attachment->fileName; ?></span></td>
				<td></td>
			</tr><?php endforeach; ?>
<?php endif; ?></tbody>
	</table>
</div>
