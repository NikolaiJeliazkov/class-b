/**
* Gallery Manager
*
* @author Spiros Kabasakalis <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
* @copyright Copyright &copy; 2011 Spiros Kabasakalis
* @since 1.0
* @license The MIT License
*/

OVERVIEW
A module that provides backend Gallery and Image Management for the end user,and
 a native  Gallery widget to render the images on the front end.The Gallery Widget comes with an option to render the images
 in EGalleria,(a  jQuery Slider).It can easily be modified to render the images in the slider of your choice.

FEATURES
Single  Administration Page with tabs for easy management.
Mostly Ajax based operations with page refreshes kept to minimum.
Create,Update,Delete Galleries.Provide title and description.
Bulk Upload of images,(maximum number of images and maximum file size configurable).
Update title,description and link for images,Delete Images.
Drag and Drop Reordering of images.
Render the images on the front end with native widget:
Can be used as stand alone or with the slider of your choice.
The widget comes with an option for usage in EGalleria.

TESTING-DEMO
http://libkal.gr/yii_lab/
In Home Page you see the rendering of the stand alone  Gallery widget which uses PrettyPhoto.
In useInEGalleria  you see the widget rendered in EGalleria.
In Gallery Manager you can test creating,updating and deleting of galleries and images.
Your images will not appear in Home page,only in Management page.
Note that you cannot edit or delete the National Geographic Gallery.


INSTALLATION INSTRUCTIONS


This module  has  CSRF (Cross-Site Request Forgery) validation enabled.POST ajax requests will not work unless
 you configure your  request in  config/main.php to use CSRF validation:

At the top of the config/main.php file (outside of the configuration array):
$current_domain='mydomain.com';

In the configuration array:
...
'request' => array(
                                          'class' => 'CHttpRequest',
                                           'enableCookieValidation' => true,
                                           'enableCsrfValidation' => !isset($_POST['dontvalidate']) ? true : false,
		                           'csrfCookie' => array( 'domain' => '.' . $current_domain )
                                           ),
...

Note: If you are developing with Google Chrome,this browser does not accept cookies with domain .localhost,so
it's better  to set up a virtual host in your local enviroment in this case.

If you have reasons to not use CSRF validation,you can search in the module's code for the YII_CSRF_TOKEN variable
 and remove it from POST  ajax requests.

I have developed this module to serve the needs of a bilingual application.So for every title and description column in the database
 there is a tr_title and tr_description for translated values.The default source language assumed is "en",(not "en_US" which is
 the default in Yii),so if language is "en" title and description will be used,in any other case the translated counterparts will be used.
  Use this information to modify your application accordingly.If you don't need the bilingual feature,just do a code search for
 Yii::app()->language =='en',and remove the language conditional statements.

Exctract  the  downloaded zip and copy imgManager folder to modules folder of your Yii application.
Create  the two tables  in your database using the gallery_manager.sql file found in data  folder.
Create the folder that images will be uploaded to, with a name of your choice,
inside the base folder of your Yii application (:same level as protected).In module configuration (see below)  you will specify
the name of the folder you just created as 'upload_directory'.

In config/main.php of your Yii application  include imgManager in modules array,like so:
( The module is configured with default values.)

'modules'=>array(

    //...other modules...

  'imgManager' => array(
                                     'import' => array('imgManager.*','imgManager.components.*'),
                                     'layout' => 'application.views.layouts.column1',
                                      'upload_directory' => 'gal_images',
                                      'max_file_number' => '10',                  //max number of files for bulk upload.
                                      'max_file_size' => '1mb',
                                                      ),

    //...other modules...
     );



GETTING STARTED

BACKEND

Navigate to the module ( [baseURL]/imgManager ).You should see the administration page.
Click the Gallery Administration tab  and create your first gallery by clicking on the + button on the right.
Select the newly created gallery from the dropdown list,go to Image Uploader tab and upload some images.
Provide titles and descriptions,and save.Go to Uploaded Images tab and rearrange the order of the images with
 drag and drop.Clicking on the thumbnails will show the full sized image in PrettyPhoto.
(In Google Chrome the drag and drop event also fires the click event and opens the full sized image.).
Clicking on the pencil icon will bring up an update form,where you can change title,description and link.
The link can be used in sliders.For example in EGalleria  a link is set by specifying the longdesc attribute of the img tag.
actionGetlinks  in PlController is used to fetch available links to populate the autocomplete dropdown list.For demonstration
 purposes,some hard coded links are returned from this action.You can modify this action to return offsite or onsite links,like links to your application's articles for example.
 
FRONTEND

To show a gallery on the frontend simply include this line in your view file:

<?php  $this->widget('imgManager.widgets.Gallery', array('galleryID' =>[the gallery ID integer])); ?>

You can have multiple instances of this  widget in the same page,for more than one galleries.

You can also use this widget inside EGalleria (see RESOURCES section for link to egalleria extension).
You simply include in your view file the following code:

  <?php
    $this->beginWidget('application.extensions.EGalleria.EGalleria',
                                               array('galleria'=>array(
                                                                                    'width'=>900,
                                                                                    'lightbox'=>true,
                                                                                     'autoplay'=>true
                                                                                  )
                                                                             ));
    ?>
   <?php    $this->widget('imgManager.widgets.Gallery', array('galleryID' =>[the gallery ID integer],'useInEGalleria'=>true));  ?>
   <?php $this->endWidget(); ?>

Note that you can modify the Gallery Widget so that it outputs image tags in the format that your favorite slider expects.
See prepareForEGalleria function in Gallery widget class and _EGalleria_Item in widget/views to give you an idea.

Cheers,Spiros 'drumaddict' Kabasakalis.


RESOURCES

PlUpload Widget for Yii  (image uploader)
http://www.yiiframework.com/extension/pupload

prettyPhoto ,(lightbox clone)
http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/

jQuery UI,for JUI dialog
http://jqueryui.com/download

Fancybox ,(lightbox clone)
 http://fancybox.net/

Image extension (Kohana image library for Yii)
http://www.yiiframework.com/extension/image

Yii Extension to support Galleria JavaScript image gallery.
http://www.yiiframework.com/extension/egalleria/

Galleria Official Site
http://galleria.aino.se/

NOTE: With the exception of egalleria extension,you don't have to download these assets,they are already included
 in module's extension folder.