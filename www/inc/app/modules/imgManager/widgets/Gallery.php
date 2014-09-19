<?php
/**
 *Gallery widget class file for frontend usage.
 * Gallery Widget - Gallery.php
 *
 * @author Spiros Kabasakalis <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */

class Gallery extends CWidget
{

	// the gallery id to display.
	public $galleryID;
	public $showGalleryTitle=true;
	public $showGalleryDescription=true;
	public $useInEGalleria=false;

	private  $galModel;
	private $imageItems;
	private $imgOrder;


	/**
	 * Initializes  variables,publishes gallery.css,PrettyPhoto js and css,and builds the image Items for view rendering.
	 */
	public function init()
	{
		Yii::import('imgManager.models.*');
		Yii::import('imgManager.utilities.*');

		//load jquery only if it's not already loaded.
		Yii::app()->clientScript->registerCorescript('jquery');

		//load Gallery Model
		$this->galModel=$this->loadGalModel($this->galleryID);
		//set the Image Order
		$this->imgOrder=unserialize($this->galModel->order);

		if(!$this->useInEGalleria){
			YiiUtil::registerCssAndJs('imgManager.extensions.prettyPhoto_312',
					'/js/jquery.prettyPhoto.js',
					'/css/prettyPhoto.css');
			YiiUtil::registerCss('imgManager.css','gallery.css');
		}


		if(!$this->useInEGalleria) $this->preparePicItems(); else $this->prepareForEGalleria();

	}


	/**
	 * Renders the widget.
	 */

	public function run()
	{

		if(!$this->useInEGalleria) $this->render('gallery',array('imageItems'=>$this->imageItems,'galModel'=>$this->galModel));
		else $this->render('egalleria',array('imageItems'=>$this->imageItems));
	}

	/**
	 * Returns the Gallery model based on the primary key.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the  Gallery model to be loaded
	 */
	private function loadGalModel($id)
	{

		$model=Gal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Gallery was not found.');
		return $model;
	}


	//prepares the image items for rendering,taking into account  the saved order.
	private function preparePicItems()
	{
		if(!$this->imgOrder) return false;
		$order = $this->imgOrder;
		foreach($order as $file_id =>$title)
		{
			$item = Img::model()->findByAttributes(array('file_id'=>$file_id));
			$this->imageItems[$file_id]= Yii::app()->controller->renderPartial('imgManager.widgets.views._imageItem', array('item'=>$item), true);
		}
	}

	//prepares  images for EGalleria,taking into account  the saved order.
	private function prepareForEGalleria()
	{
		if(!$this->imgOrder) return false;
		$order = $this->imgOrder;
		foreach($order as $file_id =>$title)
		{
			$item = Img::model()->findByAttributes(array('file_id'=>$file_id));
			$this->imageItems[$file_id]= CController::renderPartial('_EGalleria_Item', array('item'=>$item), true);
		}
	}



}


