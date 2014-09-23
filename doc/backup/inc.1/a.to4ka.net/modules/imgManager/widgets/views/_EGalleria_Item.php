<?php
/**
*Gallery Manager _EGalleriaItem view file.
*
*Renders an image to be used in EGalleria.
* @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
* @copyright Copyright &copy; 2011 Spiros Kabasakalis
* @since 1.0
* @license The MIT License
*/

//render longdesc only if url is set.
if ($item->url!=null&&$item->url!=""&&$item->url!="nolink"){
$longdesc=( substr($item->url,0,7) =='http://')?$item->url:Yii::app()->baseUrl.'/'.$item->url;
}
     echo ('<img src='.$item->path.'/'.$item->file_id.$item->extension.
             '  title="'.$item->title.'"
                 alt= "'.$item->desc.'"'
             .( ($item->url!=null&&$item->url!=""&&$item->url!="nolink")? '"  longdesc="'. $longdesc.'" />':'/>'));

?>
