<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property string $pageId
 * @property string $pageTitle
 * @property string $pageDesc
 * @property string $pageText
 * @property string $pageTags
 */
class Pages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pageId, pageTitle', 'required'),
			array('pageId', 'length', 'max'=>255),
			array('pageDesc, pageText, pageTags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageId, pageTitle, pageDesc, pageText, pageTags', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pageId' => 'Page',
			'pageTitle' => 'Page Titile',
			'pageDesc' => 'Page Desc',
			'pageText' => 'Page Text',
			'pageTags' => 'Page Tags',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pageId',$this->pageId,true);
		$criteria->compare('pageTitle',$this->pageTitle,true);
		$criteria->compare('pageDesc',$this->pageDesc,true);
		$criteria->compare('pageText',$this->pageText,true);
		$criteria->compare('pageTags',$this->pageTags,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}