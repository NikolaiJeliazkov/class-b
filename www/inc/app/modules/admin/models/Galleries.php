<?php

/**
 * This is the model class for table "galleries".
 *
 * The followings are the available columns in table 'galleries':
 * @property string $galleryId
 * @property string $userId
 * @property string $galleryOrder
 * @property integer $galleryStatus
 * @property string $galleryDate
 * @property string $galleryTitle
 * @property string $galleryText
 * @property string $galleryTags
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Images[] $images
 */
class Galleries extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'galleries';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, galleryOrder, galleryDate, galleryTitle', 'required'),
			array('galleryStatus', 'numerical', 'integerOnly'=>true),
			array('userId', 'length', 'max'=>20),
			array('galleryOrder', 'length', 'max'=>10),
			array('galleryText, galleryTags', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('galleryId, userId, galleryOrder, galleryStatus, galleryDate, galleryTitle, galleryText, galleryTags', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'userId'),
			'images' => array(self::HAS_MANY, 'Images', 'galleryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'galleryId' => '#',
			'userId' => 'Автор',
			'galleryOrder' => 'Подреждане',
			'galleryStatus' => 'Статус',
			'galleryDate' => 'Създадена на',
			'galleryTitle' => 'Заглавие',
			'galleryText' => 'Текст',
			'galleryTags' => 'Tags',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

// 		$criteria->compare('galleryId',$this->galleryId,true);
// 		$criteria->compare('userId',$this->userId,true);
// 		$criteria->compare('galleryOrder',$this->galleryOrder,true);
// 		$criteria->compare('galleryStatus',$this->galleryStatus);
// 		$criteria->compare('galleryDate',$this->galleryDate,true);
// 		$criteria->compare('galleryTitle',$this->galleryTitle,true);
// 		$criteria->compare('galleryText',$this->galleryText,true);
// 		$criteria->compare('galleryTags',$this->galleryTags,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>
			array(
				'defaultOrder'=>array(
					'galleryOrder' => CSort::SORT_DESC,
				),
				'attributes'=>array('galleryOrder'),
			),
			'pagination'=>false,

		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Galleries the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function afterSave() {
		$dir = realpath('./').'/galleries/'.$this->galleryId;
		@mkdir($dir);
		@mkdir($dir.'/tmb');
		return parent::afterSave();
	}

	protected function beforeDelete()
	{
		Images::model()->deleteAll('galleryId = '.$this->galleryId);
		return parent::beforeDelete();
	}

	protected function afterDelete()
	{
		$dir = realpath('./').'/galleries/'.$this->galleryId;
		$d = glob($dir.'/tmb/*');
		foreach($d as $file) unlink($file);
		// 		array_walk($d, 'unlink');
		rmdir($dir.'/tmb');
		$d = glob($dir.'/*');
		foreach($d as $file) unlink($file);
		// 		array_walk($d, 'unlink');
		rmdir($dir);
		return parent::afterDelete();
	}

}
