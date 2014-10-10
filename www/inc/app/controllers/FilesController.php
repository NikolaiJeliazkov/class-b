<?php

class FilesController extends Controller
{

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actions()
	{
		return array(
			'fileUpload'=>array(
				'class'=>'ext.imperavi-redactor-widget.actions.FileUpload',
				'uploadPath'=>path::normalize($_SERVER['DOCUMENT_ROOT']),
				'uploadUrl'=>'',
				'uploadCreate'=>true,
				'permissions'=>0755,
			),
			'imageUpload'=>array(
				'class'=>'ext.imperavi-redactor-widget.actions.ImageUpload',
				'uploadPath'=>path::normalize($_SERVER['DOCUMENT_ROOT']),
				'uploadUrl'=>'',
				'uploadCreate'=>true,
				'permissions'=>0755,
			),
			'imageList'=>array(
				'class'=>'ext.imperavi-redactor-widget.actions.ImageList',
				'uploadPath'=>path::normalize($_SERVER['DOCUMENT_ROOT']),
				'uploadUrl'=>'',
			),
		);
	}

}
