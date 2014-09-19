<?php

/**
 * This is the model class for table "gal".
 *
 * The followings are the available columns in table 'gal':
 * @property integer $id
 * @property string $title
 * @property string $tr_title
 * @property string $g_desc
 *  @property string $tr_desc
 * @property string $order
 *
 * The followings are the available model relations:
 * @property Images[] $images
 */
class Gal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Gal the static model class
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
		return 'gal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('title,tr_title', 'length', 'max'=>128),
				array('g_desc,tr_desc', 'length', 'max'=>512),
				array('order', 'safe'),
				array('title', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, title,tr_title,g_desc,tr_dec', 'safe', 'on'=>'search'),
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
				'images' => array(self::HAS_MANY, 'Images', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'title' => Yii::t('ImgManagerModule.adminimages','Title'),
				'tr_title' => Yii::t('ImgManagerModule.adminimages', 'Translated Title'),
				'g_desc' => Yii::t('ImgManagerModule.adminimages', 'Description'),
				'tr_desc' => Yii::t('ImgManagerModule.adminimages', 'Translated Description'),
				'size' => 'Size',
				'order' => 'Order',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('tr_title',$this->tr_title,true);
		$criteria->compare('g_desc',$this->g_desc,true);
		$criteria->compare('tr_desc',$this->tr_desc,true);


		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}