<?php
/**
 * Gallery Manager Controller file
 *
 * @author Kabasakalis Spiros <kabasakalis@gmail.com>,myspace.com/spiroskabasakalis
 * @copyright Copyright &copy; 2011 Spiros Kabasakalis
 * @since 1.0
 * @license The MIT License
 */
class PlController extends Controller
{

	public $breadcrumbs=array();
	public $currentGallery;
	public $imgOrder;
	public $galid;
	public $picItems;
	public $item;

	//  string $pageUrl - page url.
	public $pageUrl;

	/**
	 * Number or records to display on a single page
	 */
	const PAGE_SIZE = 30;

	public function init(){

		// By default we register the robots to 'none'
		Yii::app()->clientScript->registerMetaTag( 'noindex, nofollow', 'robots' );

		// We add a meta 'language' tag based on the currently viewed language
		Yii::app()->clientScript->registerMetaTag( Yii::app()->language, 'language', 'content-language' );

		//sets the layout.
		$this->pageUrl = Yii::app()->request->requestUri;

		$this->loadGalAndOrder();

		parent::init();
		$this->breadcrumbs=array(
				Yii::t('ImgManagerModule.adminimages','Gallery Administration')=>array('/imgManager'),
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'users'=>array('@'),
						'expression'=>'$user->getState("userType") > 2',
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	/**
	 * This method populate $this->arrItems with thumbs.
	 * If no files exists in gallery, will @return false
	 * ' text_field' is identifier class to add jnplace to title (for rename)
	 * even if for visitor thTitleShow is set to false, this must be true for editor and admin - (sort and rename)

	 */
	private function preparePicItems()
	{
		if(!$this->imgOrder) return false;

		$order = $this->imgOrder;

		foreach($order as $file_id =>$title)
		{
			$this->item = Img::model()->findByAttributes(array('file_id'=>$file_id));

			$this->picItems[$file_id]= $this->renderPartial('_imgitem', array('galid'=>$this->galid), true);

		}
	}



	private function loadGalAndOrder(){


		//Handles the gallery selection from the dropdown selection list,
		// sets the gallery id ,the gallery record and  order of images  as
		// public  properties of the controller .
		if (($_POST['galid'] !='') && ($_POST['galid'] != null)){

			//check if the gallery exists,(it may have been deleted in the meantime)
			$gal=Gal::model()->findByPk($_POST['galid'] );
			if (empty( $gal)){
				//no gallery found,so it has been deleted.Set the gallery id to 'no_gal_selected',
				//corresponding to no selection in dropdown list,and also save it in session.
				$this->galid= 'no_gal_selected';
				Yii::app()->session->add('s_galid','no_gal_selected');
			}
			//else,meaning a gallery was found in database
			else
			{
				//set the controller properties
				$this->galid=$_POST['galid'];
				$this->currentGallery=Gal::model()->findByPk($_POST['galid']);
				$this->imgOrder= unserialize($this->currentGallery->order);

				//Save the gallery id in session,so that the page remembers
				// the selected gallery after a page reload.
				Yii::app()->session->add('s_galid', $_POST['galid']);
			}

		}
		//else,if the page is loaded with no selected gallery,(no selection in dropdownlist was made.):
		else
		{
			//get the gallery id from session variable.
			$s_galid=Yii::app()->session->get('s_galid','no_gal_selected');

			//if the session saved variable has value other than 'no_gal_selected',
			//,in other words, a  selected gallery id was saved in session...
			if( $s_galid != 'no_gal_selected'   ){

				//check if there is a Gallery with that id,because in the meantime,
				//we might have deleted the gallery...
				$gal=Gal::model()->findByPk( $s_galid );
				if (empty( $gal)){
					//no gallery found,so it has been deleted.Set the gallery id to 'no_gal_selected',
					//corresponding to no selection in dropdown list,and also save it in session.
					$this->galid= 'no_gal_selected';
					Yii::app()->session->add('s_galid','no_gal_selected');


				}
				//else if the saved gallery id corresponds to an existing gallery...
				else
				{

					//set the  properties of the controller.
					$this->galid=$s_galid;
					$this->currentGallery=Gal::model()->findByPk($s_galid);
					$this->imgOrder= unserialize($this->currentGallery->order);

				}

				// else if $s_galid == 'no_gal_selected',(if gallery id saved in session is 'no_gal_selected'):
			}else{
				//set the gallery id property  to  no_gal_selected,no point in setting the others( currentGallery,imgOrder)
				$this->galid=$s_galid;
			}


		}


		//handle any image sorting
		if(isset($_POST['newImgOrder'])) $this->newSort();

	}



	/** This method is used to prepare new order of pictures before saving them
	 */
	private function newSort(){
		$n = $_POST['newImgOrder'];
		$galid=$_POST['galid'];
		$newOrder = array();
		foreach(explode(",", $n) as $file_id){
			$newOrder[$file_id] =$this->imgOrder[$file_id];
		}

		$this->updateOrder($newOrder,$galid);
	}

	/** This method is used to save new order of pictures
	 * @param array $order - array list with order to be saved
	 * Before save, the list is serialized
	 * After save, the new order is loaded as array in $this->imgsOrder
	 */
	public  function updateOrder($order,$galid)
	{
		$order = serialize($order);
		$record=Gal::model()->findByPk($galid);

		if($record === null){
			$record = new Gal;
			$record->id = $this->galid;
			$record->order = $order;

			if(!$record->save())
				throw new Exception('Image Manager - '.Yii::t('ImgManagerModule.adminimages', 'Could not save image reordering.'));

		}else{

			$attributes = array("order"=> $order);
			$record->saveAttributes($attributes);
		}
		//reload image's order
		$this->imgOrder = unserialize($order);
	}



	//Renders the Gallery Management Page
	public function actionIndex() {


		//------------Gallery Administration Grid----------------------------------------------
		$gal_Model=new Gal('search');
		$gal_Model->unsetAttributes();  // clear any default values
		if(isset($_GET['Gal']))
			$gal_Model->attributes=$_GET['Gal'];

		//---------------------------------------------------------------------------------------------

		//-------------Handle Gallery  Update And Create-----------------

		//if the user submitted the Gallery Form...
		if(isset($_POST['Gal']))
		{
			//...if  we are updating a Gallery...
			if(isset($_POST['Gal']['update_galid'])){
				//load the Gallery
				$model= $this->loadGalModel($_POST['Gal']['update_galid']);
			}
			//..else,if we are creating a new one,instatiate a new Gal model.
			else
			{
				$model=new Gal;
			}
			//set the submitted values
			$model->title=$_POST['Gal']['title'];
			$model->tr_title=$_POST['Gal']['tr_title'];
			$model->g_desc=$_POST['Gal']['g_desc'];
			$model->tr_desc=$_POST['Gal']['tr_desc'];

			//return the JSON result to provide feedback.
			if($model->save()){
				echo json_encode(array('success'=>true));
				exit;
			} else
			{
				echo json_encode(array('success'=>false));
				exit;
			}

		}

		//-----------------------------------------------------------------------------

		$this->preparePicItems();
		$this->render('index', array('gal_Model'=>$gal_Model) );

	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the Gal  model to be validated
	 */
	protected function performAjaxGalValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadGalModel($id)
	{
		$model=Gal::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function actionGalleryDelete()
	{

		$id=$_POST['id'];

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$galToDelete=$this->loadGalModel($id);
			$order= unserialize($galToDelete->order);
			if (!empty($order)){
				foreach ($order as $file_id){
					$img= Img::model()->findByAttributes(array('file_id'=>$file_id), array('select'=>'extension'));
					$ext= $img->extension;
					$this->deleteImgAndThumb($file_id,$ext);
				}

			}

			if(  $galToDelete->delete() )
			{

				//remove the deleted gallery's id from session variable
				$s_galid=Yii::app()->session->get('s_galid');
				if ($s_galid==$id ) Yii::app()->session->add('s_galid','no_gal_selected');

				echo json_encode(array('deleted'=>true));


			}
			else  //if not deleted
			{
				echo json_encode(array('deleted'=>false));
			}

		}
		//else if not Post Request
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	//deletes an image,(file,thumb and database entry).
	private function  deleteImgAndThumb($file_id,$ext)
	{


		$app_root=substr( Yii::app()->baseUrl, 1, strlen(Yii::app()->baseUrl)-1);
		$filetodelete= $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR .
		$app_root.DIRECTORY_SEPARATOR .
		//  'assets'.DIRECTORY_SEPARATOR .
		$this->module->upload_directory. DIRECTORY_SEPARATOR .
		$file_id.   $ext;

		$thumbtodelete= $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR .
		$app_root.DIRECTORY_SEPARATOR .
		//        'assets'.   DIRECTORY_SEPARATOR .
		$this->module->upload_directory. DIRECTORY_SEPARATOR .
		'tmb'. DIRECTORY_SEPARATOR .
		$file_id.'_100_100'. '_thumb'.$ext;


		//delete the image
		if  ( is_file($filetodelete))  unlink( $filetodelete);
		//delete thumb
		if  ( is_file($thumbtodelete))   unlink( $thumbtodelete);
		//remove from database,file_id is unique for each image.

	}

	//this action is called via ajax and renders the update or create form for a Gallery  inside a fancy box pop up.
	public function actionReturnGalForm() {



		//don't reload these scripts or they will mess up the page
		//yiiactiveform.js still needs to be loaded that's why we don't use
		// Yii::app()->clientScript->scriptMap['*.js'] = false;
		$cs=Yii::app()->clientScript;
		$cs->scriptMap=array(
				'jquery.js'=>false,
				'jquery.prettyPhoto.js'=>false,
				'jquery.fancybox-1.3.4.js'=>false,

		);

		//Figure out if we are updating a Gallery Model or creating a new one.
		if(isset($_POST['update_galid']))$model= $this->loadGalModel($_POST['update_galid']);else $model=new Gal;

		// Uncomment the following line if AJAX validation is needed for Gal active Record.
		//    $this->performAjaxGalValidation($model);

		$this->renderPartial('_gallery_form', array('model'=>$model), false, true);
	}

	//This  function is called via ajax after an update in the Gallery Administration Grid.
	public function actionFetchGalSelectionList() {
		$gals=Gal::model()->findAll();
		echo  json_encode(array('options'=>CHtml::listData($gals, 'id', 'title'),'descs'=>CHtml::listData($gals, 'id','g_desc')));
	}






	//this action is  ajax-called when _imgupdateform view is rendered.
	//Fetches image info for the particular image that is being updated
	public function actionFetch_image_info() {

		$rawimg=new Img();
		$img=array();
		$rawimg=Img::model()->find('t.file_id=:fileid', array(':fileid'=>$_POST['file_id']));

		$img['id']=$rawimg->id;
		$img['file_id']=$rawimg->file_id;
		$img['basename']=$rawimg->basename;
		$img['extension']=$rawimg->extension;
		$img['title']=html_entity_decode($rawimg->title);
		$img['tr_title']=html_entity_decode($rawimg->tr_title);
		$img['size']=$rawimg->size;
		$img['type']=$rawimg->type;
		$img['path']=$rawimg->path;
		$img['url']=$rawimg->url;
		$img['desc']=$rawimg->desc;
		$img['tr_desc']=$rawimg->tr_desc;

		echo  (json_encode($img));

	}


	//This action fetches links stored in your CMS structure to populate the Link  dropdownlist for an image.
	//You can associate a URL  with each image and it will be saved in images table.
	//In this way,you can have your images in EGalleria for example pointing to a link (insite or offsite).
	//Dummy  hard coded links are provided for demonstration,you should modify this according to your CMS.
	public function actionGetlinks() {
		$links = array();
		$ops = "<option value='nolink' selected=\"selected\">No Link</option>";
		$links['nolink'] = array('title' => 'No link', 'url' => 'nolink', 'name' => 'nolink');

		//dummy links
		$linksraw=array(
				array('url'=>'http://www.yiiframework.com','title'=>'Yii','id'=>'1'),
				array('url'=>'http://webdeveloperplus.com/','title'=>'Web Developer Plus','id'=>'2'),
				array('url'=>'http://css-tricks.com/','title'=>'CSS Tricks','id'=>'3'),
				array('url'=>'http://www.packtpub.com/','title'=>'Packt','id'=>'4')
		);

		foreach ($linksraw as $l) {
			$ops = $ops . "<option value='" . $l['url'] . "'>" . $l["title"] . "</option>";
			$links[$l['id']] = array('title' => $l['title'], 'url' => $l['url'], 'id' => $l['id']);
		}



		//we call this action either via ajax or not,handle both cases.
		if (Yii::app()->getRequest()->getPost('echojson') == 'true') {
			echo json_encode($links);
		} else {
			return $ops;
		}
	}

	//deletes an image,(file,thumb and database entry).
	public function  actionDelete()
	{



		$app_root=substr( Yii::app()->baseUrl, 1, strlen(Yii::app()->baseUrl)-1);
		$filetodelete= $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR .
		$app_root.DIRECTORY_SEPARATOR .
		//  'assets'.DIRECTORY_SEPARATOR .
		$this->module->upload_directory. DIRECTORY_SEPARATOR .
		$_POST['file_id'].   $_POST['extension'];

		$thumbtodelete= $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR .
		$app_root.DIRECTORY_SEPARATOR .
		//        'assets'.   DIRECTORY_SEPARATOR .
		$this->module->upload_directory. DIRECTORY_SEPARATOR .
		'tmb'. DIRECTORY_SEPARATOR .
		$_POST['file_id'].'_100_100'. '_thumb'.$_POST['extension'];

		//delete the image
		if  ( is_file($filetodelete))  unlink( $filetodelete);
		//delete thumb
		if  ( is_file($thumbtodelete))   unlink( $thumbtodelete);
		//remove from database,file_id is unique for each image.
		Img::model()->deleteAllByAttributes(array('file_id'=>$_POST['file_id']));

		$newOrder=array();

		$gal=Gal::model()->findByPk( $_POST['galid']);
		$oldOrder=$gal->order;


		foreach(unserialize($oldOrder) as $file_id =>$file_id)
			if($file_id !==  $_POST['file_id']) $newOrder[$file_id] =$file_id;

		$this->updateOrder($newOrder, $_POST['galid']);

		echo json_encode($_POST);

	}


	//this action is called via ajax and renders the update form inside fancy box
	public function actionReturnform() {



		//we don't want to reload the js files
		Yii::app()->clientScript->scriptMap['*.js'] = false;

		//get the link options for the select control
		$ops = $this->actionGetlinks();

		$this->renderPartial('_imgupdateform', array('ops' => $ops), false, true);
	}




	//this action updates the title and link of an image,called via ajax
	public function  actionUpdateinfo()
	{
		$image=Img::model()->find('file_id=:unique_id', array(':unique_id'=>$_POST['file_id']));

		$image->title=filter_input(INPUT_POST, $_POST['file_id'].  '_title_input',FILTER_SANITIZE_STRING);
		$image->tr_title=filter_input(INPUT_POST, $_POST['file_id'].  '_tr_title_input',FILTER_SANITIZE_STRING);
		$image->desc=filter_input(INPUT_POST, $_POST['file_id'].  '_desc_input',FILTER_SANITIZE_STRING);
		$image->tr_desc=filter_input(INPUT_POST, $_POST['file_id'].  '_tr_desc_input',FILTER_SANITIZE_STRING);
		$image->url=$_POST[$_POST['file_id'].'_url_select'];

		if($image->save()){

			$response= array('file_id'=>$_POST['file_id'],
					'title'=>filter_input(INPUT_POST, $_POST['file_id'].  '_title_input',FILTER_SANITIZE_STRING),
					'tr_title'=>filter_input(INPUT_POST, $_POST['file_id'].  '_tr_title_input',FILTER_SANITIZE_STRING),
					'desc'=>filter_input(INPUT_POST, $_POST['file_id'].  '_desc_input',FILTER_SANITIZE_STRING),
					'tr_desc'=>filter_input(INPUT_POST, $_POST['file_id'].  '_tr_desc_input',FILTER_SANITIZE_STRING),
					'url'=>$_POST[$_POST['file_id'].'_url_select'],
					'extension'=> $image->extension,

			);

		}
		else{
			$response= array('success'=>'Not saved');
		}

		echo json_encode($response);

	}


	//this action submits the title and link-if any- for newly uploaded images
	public function  actionHandle()
	{


		$new_order=array();
		foreach ($_POST['imginfo_parsed'] as $unique_id=> $fileinfo) {

			$new_order[$unique_id]=$unique_id;

			Img::model()->updateAll(array(
					'title'=> filter_var( $fileinfo['title'],FILTER_SANITIZE_STRING),
					'tr_title'=> filter_var( $fileinfo['tr_title'],FILTER_SANITIZE_STRING),
					'desc'=> filter_var( $fileinfo['desc'],FILTER_SANITIZE_STRING),
					'tr_desc'=> filter_var( $fileinfo['tr_desc'],FILTER_SANITIZE_STRING),
					'url'=>$fileinfo['url'],
					'gid'=> $fileinfo['gid']),
					'file_id=:unique_id',
					array(
							':unique_id'=>$unique_id,
					) ) ;
		}

		$old_order=array();
		$gal=Gal::model()->findByPk($_POST['galid']);
		if (isset($gal->order) && ($gal->order!='' )&&($gal->order!=null))
			$old_order=unserialize($gal->order);

		$order=array_merge($old_order,$new_order);
		$order=serialize($order);

		Gal::model()->updateByPk($_POST['galid'], array('order'=>$order));
	}

	//This action is called from PluploadWidget,uploads images and creates thumbnails.
	//It is a modified version of the upload.php file that comes with Plupload
	public function  actionUpload()
	{

		Yii::import('imgManager.components.image.ImageHelper');



		$filenames=array();

		// HTTP headers for no cache etc
		header('Content-type: text/plain; charset=UTF-8');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// Settings

		$targetDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "plupload";
		$cleanupTargetDir = false; // Remove old files
		$maxFileAge = 60 * 60; // Temp file age in seconds

		// 5 minutes execution time
		@set_time_limit(5 * 60);
		// usleep(5000);

		// Get parameters
		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		// Clean the fileName for security reasons
		$fileName = preg_replace('/[^\w\._\s]+/', '', $fileName);

		// Create target dir
		if (!file_exists($targetDir))
			@mkdir($targetDir);

		// Remove old temp files
		if (is_dir($targetDir) && ($dir = opendir($targetDir))) {
			while (($file = readdir($dir)) !== false) {
				$filePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// Remove temp files if they are older than the max age
				if (preg_match('/\\.tmp$/', $file) && (filemtime($filePath) < time() - $maxFileAge))
					@unlink($filePath);
			}

			closedir($dir);
		} else
			throw new CHttpException (500, Yii::t('app', "Can't open temporary directory."));



		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];

		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];



		if (strpos($contentType, "multipart") !== false) {


			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file

				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");



					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);


					} else
						throw new CHttpException (500, Yii::t('app', "Can't open input stream."));

					fclose($out);




					@unlink($_FILES['file']['tmp_name']);



				} else
					throw new CHttpException (500, Yii::t('app', "Can't open output stream."));
			} else
				throw new CHttpException (500, Yii::t('app', "Can't move uploaded file."));
		} else {


			// Open temp file
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					throw new CHttpException (500, Yii::t('app', "Can't open input stream."));

				fclose($out);
			} else
				throw new CHttpException (500, Yii::t('app', "Can't open output stream."));
		}





		//process the file
		$file_id= substr($fileName, 0, strripos($fileName, '.'));
		$filename=  $_FILES['file']['name'];
		$file_basename=substr($filename, 0, strripos($filename, '.'));
		$file_ext      = substr($filename, strripos($filename, '.'));
		$file_size=$this->display_filesize( $_FILES['file']['size']);
		$file_type=  $_FILES['file']['type'];
		$file_error=  $_FILES['file']['error'];
		$app_root=substr( Yii::app()->baseUrl, 1, strlen(Yii::app()->baseUrl)-1);

		$upload_path=                                         // '/'.
		$app_root.'/' .
		//     'assets'.  '/'.
		$this->module->upload_directory;


		//prepare Img instance  to save in database
		$newimage=new Img();
		$newimage->basename=str_replace(' ','',$file_basename);
		$newimage->extension=$file_ext;
		$newimage->size=$file_size;
		$newimage->type=$file_type;
		$newimage->path=$upload_path;
		$newimage->file_id=$file_id;



		//Return Array
		$ret = array('result' => '1',
				'file_error'=> $file_error,
				'filename'=> str_replace(' ','',$filename),
				'file_id'=> $file_id,
				'file_basename'=> str_replace(' ','',$file_basename),
				'file_ext'=> $file_ext,
				'file_size'=> $file_size,
				'file_type'=> $file_type,
				'upload_path'=> $upload_path,


		);


		if (intval($chunk) + 1 >= intval($chunks)) {


			$originalname = $fileName;


			if (isset($_SERVER['HTTP_CONTENT_DISPOSITION'])) {
				$arr = array();
				preg_match('@^attachment; filename="([^"]+)"@',$_SERVER['HTTP_CONTENT_DISPOSITION'],$arr);
				if (isset($arr[1]))
					$originalname = $arr[1];

			}

			// **********************************************************************************************
			// Do whatever you need with the uploaded file, which has $originalname as the original file name
			// and is located at $targetDir . DIRECTORY_SEPARATOR . $fileName
			// **********************************************************************************************

			$temppath=$targetDir . DIRECTORY_SEPARATOR . $fileName;

			$app_root=substr( Yii::app()->baseUrl, 1, strlen(Yii::app()->baseUrl)-1);


			$dest= $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR .
			$app_root.DIRECTORY_SEPARATOR .
			//      'assets'.     DIRECTORY_SEPARATOR .
			$this->module->upload_directory. DIRECTORY_SEPARATOR .
			$file_id.$file_ext;
			//  var_dump($dest);


			//copy from temporary to final directory
			@copy($temppath, $dest);
			//create thumb,(destination is tmb directory inside upload_directory directory,see ImageHelper.php of
			//image component
			ImageHelper::thumb(100, 100, $dest);
			//save in database
			/// FB::info( $newimage);
			$newimage->save();
		}


		// Return response
		die(json_encode($ret));



	}

	public function filters()
	{
		return array(
				array(
						'imgManager.filters.YXssFilter',
						'clean' => 'all',
						'tags' => 'all',
						'actions' => 'all'
				),
				'accessControl', // perform access control for CRUD operations
		);
	}


	//helper function to format file size
	public    function display_filesize($filesize){

		if(is_numeric($filesize)){
			$decr = 1024; $step = 0;
			$prefix = array('Byte','KB','MB','GB','TB','PB');

			while(($filesize / $decr) > 0.9){
				$filesize = $filesize / $decr;
				$step++;
			}
			return round($filesize,0).' '.$prefix[$step];
		} else {

			return 'NaN';
		}

	}


}