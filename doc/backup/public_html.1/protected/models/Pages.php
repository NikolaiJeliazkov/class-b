<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property string $pageId
 * @property string $pageParent
 * @property string $pageStatus
 * @property string $pageTitile
 * @property string $pageDesc
 * @property string $pageText
 * @property string $pageTags
 *
 * The followings are the available model relations:
 * @property Pages $pageParent0
 * @property Pages[] $pages
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
			array('pageTitile', 'required'),
			array('pageParent', 'length', 'max'=>20),
			array('pageStatus', 'length', 'max'=>10),
			array('pageDesc, pageText, pageTags', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageId, pageParent, pageStatus, pageTitile, pageDesc, pageText, pageTags', 'safe', 'on'=>'search'),
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
			'pageParent0' => array(self::BELONGS_TO, 'Pages', 'pageParent'),
			'pages' => array(self::HAS_MANY, 'Pages', 'pageParent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pageId' => 'Page',
			'pageParent' => 'Page Parent',
			'pageStatus' => 'Page Status',
			'pageTitile' => 'Page Titile',
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
		$criteria->compare('pageParent',$this->pageParent,true);
		$criteria->compare('pageStatus',$this->pageStatus,true);
		$criteria->compare('pageTitile',$this->pageTitile,true);
		$criteria->compare('pageDesc',$this->pageDesc,true);
		$criteria->compare('pageText',$this->pageText,true);
		$criteria->compare('pageTags',$this->pageTags,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}