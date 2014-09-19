<?php
/**
*Gallery Manager egalleria view file.Just echoing image tags with attributes set to be used in EGalleria.
*
**Renders  all  images to be used in EGalleria.
* @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
* @copyright Copyright &copy; 2011 Spiros Kabasakalis
* @since 1.0
* @license The MIT License
*/
?>
<?php if (!empty($imageItems)):?>
      <?php foreach ($imageItems as $file_id=>$image) echo $image;?>
 <?php  endif; ?>



