<?php

class MessagesController extends Controller
{
	public $layout='//layouts/column1';

	public function accessRules() {
		return array(
// 			array('allow', // allow authenticated user to perform 'create' and 'update' actions
// 				'actions'=>array('index', 'inbox', 'outbox','send', 'view', 'update', 'delete', 'getvalue'),
// 				'users'=>array('@'),
// 			),
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex() {
		$this->redirect(array('inbox'));
	}

	public function actionInbox($id=null) {
		if(isset($_POST['Messages'])) {
			$model=new Messages();
			$action = $_POST['Messages']['action'];
			$ids = explode(',',$_POST['Messages']['ids']);
			if($action=='delete') {
				foreach ($ids as $id) {
					$model->markAsDeleted($id);
				}
				Yii::app()->user->setFlash('info', 'Съобщенията са изтрити');
			}
			if($action=='read') {
				$model->messageToUserId = Yii::app()->user->getId();
				foreach ($ids as $id) {
					$model->messageId = $id;
					$model->markAsRead();
				}
			}
			$this->redirect(array('inbox'));
		}
		$model=new Messages('inbox');
		if ($id!==null) {
			$model->loadModel($id);
			if($model->messageStatus==0) {
				$model->markAsRead();
			}
			$this->render('view',array('model'=>$model,));
		} else {
			if(isset($_GET['Messages']['searchField']))
				$model->searchField=$_GET['Messages']['searchField'];
			$this->render('index',array('model'=>$model,));
		}
	}

	public function actionOutbox($id=null) {
		$model=new Messages('outbox');
		if ($id!==null) {
			$model->loadModel($id);
			$this->render('view',array('model'=>$model,));
		} else {
			if(isset($_GET['Messages']['searchField']))
				$model->searchField=$_GET['Messages']['searchField'];
			$this->render('index',array('model'=>$model,));
		}
	}

	public function actionSend($id=null) {
		$model=new Messages('send');
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='messages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Messages'])) {
			$model->attributes=$_POST['Messages'];
			if ($model->validate()) {
				if ($model->newMessageSave()) {
					Yii::app()->user->setFlash('info', 'Съобщението е изпратено');
					$this->redirect(array('inbox'));
				} else {
					Yii::app()->user->setFlash('error', 'Съобщението не е изпратено');
				}
			}
		} elseif ($id !== null) {
			$model->loadModel($id);
			$model->messageParent = $model->messageId;
			$model->messageTo = $model->messageFromUserId;
			$model->messageSubject = 'Re: '.$model->messageSubject;
			$s = array();
			foreach(preg_split("/((\r?\n)|(\n?\r))/", $model->messageText) as $line){
				$s[] = '> '.$line;
			}
			$model->messageText = "\n\n\nНа {$model->messageDate} ".Users::getUserLabel(intval($model->messageFromUserId))." написа:\n".implode("\n",$s);
		}
		$this->render('send',array(
			'model'=>$model,
		));
	}

	public function actionNotify($id) {
		$model=new Messages('send');
		$model->loadModel($id);

		$utext = Users::getUserLabel(intval($model->messageFromUserId));

		$email = Users::model()->findByPk($model->messageToUserId)->userEmail;

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers.= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
		$headers.= 'From: '.Yii::app()->params['adminEmail']."\r\n";
		$headers.= 'Content-Transfer-Encoding: 7bit' . "\r\n";

		$emailSubject = "=?UTF-8?B?" . base64_encode(Yii::app()->params['appName'].' - '.$model->messageSubject) . "?=";
		$emailText = "Получихте ново съобщение от {$utext}, което можете да прочетете на адрес\n";
		$emailText.= Yii::app()->params['appUrl']."/messages/inbox/{$id}\n\n";
		$emailText.= "ТОВА Е АВТОМАТИЧНО ГЕНЕРИРАНО СЪОБЩЕНИЕ. МОЛЯ, НЕ ОТГОВАРЯЙТЕ!\n\n";

		if ($email) {
			mail($email,$emailSubject,$emailText,$headers);
		}
	}


	public function actionSuggestUsers() {
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='') {
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}

	public function actionDelete($id) {
		$model=new Messages();
		$model->markAsDeleted($id);
		Yii::app()->user->setFlash('info', 'Съобщението е изтрито');
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('inbox'));
	}









	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
// 	public function actionCreate()
// 	{
// 		$model=new Users;
// 		// Uncomment the following line if AJAX validation is needed
// 		// $this->performAjaxValidation($model);
// 		if(isset($_POST['Users']))
// 		{
// 			$model->attributes=$_POST['Users'];
// 			$model->userStatus = 1;
// 			$model->userType = 1;
// 			$model->studentId = null;
// 			if($model->save())
// 				$this->redirect(array('view','id'=>$model->userId));
// 		}
// 		$this->render('create',array(
// 			'model'=>$model,
// 		));
// 	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
// 	public function actionDelete($id)
// 	{
// 		if(Yii::app()->request->isPostRequest)
// 		{
// 			// we only allow deletion via POST request
// 			$this->loadModel($id)->delete();

// 			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
// 			if(!isset($_GET['ajax']))
// 				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
// 		}
// 		else
// 			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
// 	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetvalue()
	{
		if(isset($_POST['ids']))             // method $_POST can't get any value, code stop at here.
		{
			print_r($_POST['ids']);
			foreach($_POST['ids'] as $val)
			{
				echo $val . '<br/>';
			}
		}
	}

}
