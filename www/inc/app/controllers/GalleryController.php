<?php
class GalleryController extends Controller {
	public $layout = 'column2';

	/**
	 *
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 *
	 * @return array access control rules
	 */
	public function accessRules() {
		return array (
			array (
				'allow', // allow all users to access 'index' and 'view' actions.
				'actions' => array (
					'index',
					'view'
				),
				'users' => array (
					'*'
				)
			),
			array (
				'allow', // allow authenticated users to access all actions
				'users' => array (
					'@'
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

	public function loadModel($id)
	{
		$model=Gallery::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$m = new Gallery ( 'index' );
		$this->render ( 'index', array (
			'm' => $m
		) );
	}
	public function actionView($id = false) {
		$this->render ( 'view', array (
			'm' => $this->loadModel ( $id )
		) );
	}
}
