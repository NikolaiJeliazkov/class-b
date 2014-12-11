<?php
class GalleriesController extends Controller {
	/**
	 *
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 *      using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 *
	 * @return array action filters
	 */
	public function filters() {
		return array (
			'accessControl',
			'postOnly + delete',
			'postOnly + imageDelete'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules() {
		return array (
			array (
				'allow',
				'actions' => array (
					'index',
					'reorder',
					'create',
					'update',
					'delete',
					'imageUpdate',
					'imageDelete',
					'imagesReorder',
					'uploadImage'
				),
				'users' => array (
					'@'
				),
				'roles' => array (
					'galleryEditor'
				)
			),
			array (
				'deny', // deny all users
				'users' => array (
					'*'
				)
			)
		);
	}
	public function actions() {
		return array (
			'reorder' => array (
				'class' => 'booster.actions.TbSortableAction',
				'modelName' => 'Galleries'
			),
			'imagesReorder' => array (
				'class' => 'booster.actions.TbSortableAction',
				'modelName' => 'Images'
			)
		);
	}
	public function actionCreate() {
		// $this->layout = '//layouts/column2';
		$model = new Galleries ( 'create' );
		if (isset ( $_POST ['Galleries'] )) {
			$a = $model->search ()->data;
			// $this->trace($a[0]->galleryOrder + 1);exit;
			$galleryOrder = $a [0]->galleryOrder + 1;
			$model->galleryOrder = $galleryOrder; // new CDbExpression ( 'select max(galleryOrder)+1 from galleries' );
			$model->galleryDate = new CDbExpression ( 'NOW()' );
			$model->userId = Yii::app ()->user->id;
			$model->galleryStatus = 1;
			$model->attributes = $_POST ['Galleries'];
			if ($model->validate ()) {
				$result = $model->save ( false );
				if ($result) {
					$this->redirect ( array (
						'update',
						'id' => $model->galleryId
					) );
				}
			}
		}

		$this->render ( 'create', array (
			'model' => $model
		) );
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		// $this->layout = '//layouts/column2';
		$model = $this->loadModel ( $id );
		if (isset ( $_POST ['Galleries'] )) {
			$model->attributes = $_POST ['Galleries'];
			$model->save ( true );
		}
		if (isset ( $_POST ['Images'] )) {
			$image = new Images ();
			$image->galleryId = $model->galleryId;
			$lastImage = array_pop ( $image->search ()->data );
			$imageOrder = $lastImage->imageOrder + 1;
			$image->imageOrder = $imageOrder;
			$image->attributes = $_POST ['Images'];
			$image->image = CUploadedFile::getInstance ( $image, 'image' );
			$res = $image->save ( true );
			$this->redirect ( array (
				'update',
				'id' => $model->galleryId
			) );
		}

		$this->render ( 'update', array (
			'model' => $model
		) );
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		$this->loadModel ( $id )->delete ();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (! isset ( $_GET ['ajax'] ))
			$this->redirect ( isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
				'admin'
			) );
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$dataProvider = Galleries::model ()->search ();
		$this->render ( 'index', array (
			'dataProvider' => $dataProvider
		) );
	}
	public function actionImageUpdate() {
		if (isset ( $_POST ['name'] ) && $_POST ['name'] == 'imageDescription') {
			$image = Images::model ()->findByPk ( $_POST ['pk'] );
			$image->imageDescription = $_POST ['value'];
			$image->save ();
			// echo CActiveForm::validate($image);
			Yii::app ()->end ();
		}
	}
	public function actionImageDelete($id) {
		Images::model ()->findByPk ( $id )->delete ();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (! isset ( $_GET ['ajax'] ))
			$this->redirect ( isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
				'admin'
			) );
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id
	 *        	the ID of the model to be loaded
	 * @return Galleries the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = Galleries::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param Galleries $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'galleries-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}

	public function actionUploadImage($galleryId) {
		header ( 'Vary: Accept' );
		if (isset ( $_SERVER ['HTTP_ACCEPT'] ) && (strpos ( $_SERVER ['HTTP_ACCEPT'], 'application/json' ) !== false)) {
			header ( 'Content-type: application/json' );
		} else {
			header ( 'Content-type: text/plain' );
		}
		$data = array ();

		$model = new Images ('upload');
		$model->galleryId = $galleryId;
		$lastImage = array_pop ( $model->search ()->data );
		$imageOrder = $lastImage->imageOrder + 1;
		$model->imageOrder = $imageOrder;
		$model->image = CUploadedFile::getInstance ( $model, 'image' );
		//echo json_encode ( CUploadedFile::getInstance ( $model, 'image' ) );exit;
		if ($model->image !== null && $model->validate ( array (
			'image'
		) )) {
// 			$model->image->saveAs ( Yii::getPathOfAlias ( 'frontend.www.files' ) . '/' . $model->image->name );
			$model->imageBaseName = $model->image->name;
			// save picture name
			if ($model->save ()) {
				// return data to the fileuploader
				$data [] = array (
					'name' => $model->image->name,
					'type' => $model->image->type,
					'size' => $model->image->size,
					// we need to return the place where our image has been saved
					'url' => '', //$model->getImageUrl (), // Should we add a helper method?
					                                // we need to provide a thumbnail url to display on the list
					                                // after upload. Again, the helper method now getting thumbnail.
					'thumbnail_url' => '', //$model->getImageUrl ( MyModel::IMG_THUMBNAIL ),
					// we need to include the action that is going to delete the picture
					// if we want to after loading
					'delete_url' => $this->createUrl ( 'my/delete', array (
						'id' => $model->imageId,
						'method' => 'uploader'
					) ),
					'delete_type' => 'POST'
				);
			} else {
				$data [] = array (
					'error' => 'Unable to save model after saving picture'
				);
			}
		} else {
			if ($model->hasErrors ( 'image' )) {
				$data [] = array (
					'error',
					$model->getErrors ( 'image' )
				);
			} else {
				throw new CHttpException ( 500, "Could not upload file " . CHtml::errorSummary ( $model ) );
			}
		}
		// JQuery File Upload expects JSON data
		echo json_encode ( $data );
	}
}
