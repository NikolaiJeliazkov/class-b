<?php
/**
 *Gallery Manager gallery  view file.
 *
 * @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */

$gal_title='<h1>'.$galModel->title.'</h1>';
$gal_desc=' <p>'.$galModel->g_desc.'</p>';
?>
<div id="gallery-<?php echo $this->galleryID;?>" class="gallery-wrapper">
	<?php if ($this->showGalleryTitle):?>
	<div class="gallery-title">
		<?php echo $gal_title;?>
	</div>
	<?php endif;?>
	<?php if ($this->showGalleryDescription):?>
	<div class="gallery-description">
		<?php echo $gal_desc;?>
	</div>
	<?php endif;?>
	<div class="thumbs-wrapper">
		<?php if (!empty($imageItems)):?>
		<?php foreach ($imageItems as $file_id=>$image_thumb) echo $image_thumb;?>
		<?php  endif; ?>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {

//BIND PRETTY PHOTO to show a slideshow of the images
// Available Themes 'pp_default' / light_rounded / dark_rounded / light_square / dark_square / facebook
$("a[rel^='prettyPhoto']").prettyPhoto({
	theme: "dark_rounded",
	slideshow:5000,
	autoplay_slideshow:false,
	deeplinking:true,
	social_tools:false //attention,removing this may cause buggy behavior,Firefox specially may hang.
});



});


</script>
