<?php
/**
 * Gallery Manager- ImageManagerModule.php
 *
 * @author Spiros Kabasakalis <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */
class ImgManagerModule extends CWebModule
{

	public $defaultController='pl';

	//The following default values can be changed in config/main.php,
	//in module initialization.


	//Default upload directory,subdirectory of application's  root folder (same level as protected).
	//You have to create this directory.
	public  $upload_directory="gal_images";

	//Maximum number of images that can be uploaded at once.
	public $max_file_number=10;

	//Maximum file size allowed.
	public $max_file_size= '1mb';


	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		Yii::import('imgManager.utilities.*');
		// import the module-level models and components
		$this->setImport(array(
				'imgManager.models.*',
				'imgManager.components.image.CImageComponent',
		));

		//initialize the component that handles image thumbnail creation
		$this->setComponent('image', new CImageComponent);
		$this->image->params=array('directory'=>'/opt/local/bin');



		Yii::app()->clientScript->registerCoreScript('jquery');


		//Registration of js and css files for PrettyPhoto,jqUI,FancyBox and JuiDialog.
		YiiUtil::registerCssAndJs('imgManager.extensions.prettyPhoto_312',
				'/js/jquery.prettyPhoto.js',
				'/css/prettyPhoto.css');

		//jqui is already registaered in main file,comment out when done with extension
		YiiUtil::registerCssAndJs('imgManager.extensions.jqui1819',
				'/js/jquery-ui-1.8.19.custom.min.js',
				'/css/base/jquery-ui.css');
		YiiUtil::registerCssAndJs('imgManager.extensions.fancybox',
				'/jquery.fancybox-1.3.4.js',
				'/jquery.fancybox-1.3.4.css');

		//CSS for management page.
		YiiUtil::registerCss('imgManager.css','gallery.css');


	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{

			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}



}
