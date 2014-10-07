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
class Gallery extends CActiveRecord
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
			'userId' => 'User',
			'galleryOrder' => 'Gallery Order',
			'galleryStatus' => 'Статус',
			'galleryDate' => 'Дата',
			'galleryTitle' => 'Заглавие',
			'galleryText' => 'Текст',
			'galleryTags' => 'Tags',
		);
	}

	public static function search($pageSize = 5) {
		$sql = "
select
  count(*)
from
  galleries g
where
  coalesce(g.galleryStatus,0)<>0
";
		$command= Yii::app()->db->createCommand($sql);
		$count=$command->queryScalar();

		$sql = "
select
  g.galleryId, g.galleryTitle, g.galleryOrder
from
  galleries g
where
  coalesce(g.galleryStatus,0)<>0
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'galleryId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'galleryOrder' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'galleryOrder',
						),
				),
				'pagination'=>array(
						'pageSize'=>$pageSize,
				),
		));
		$dataProvider->setId('galleryId');
		return $dataProvider;
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

	public function getTitle() {
		if ($this->scenario=='' || $this->scenario=='index') {
			return 'Снимки';
		}
		return parent::getTitle();
	}

	public function afterSave() {
		$dir = realpath('./').'/galleries/'.$this->galleryId;
		@mkdir($dir);
		@mkdir($dir.'/tmb');
		return parent::afterSave();
	}

	protected function beforeDelete()
	{
		Images::model()->deleteAll('galleryId = '.$this->GalleryId);
		return parent::beforeDelete();
	}

	protected function afterDelete()
	{
		$dir = realpath('./').'/galleries/'.$this->galleryId;
		$d = glob($dir.'/tmb/*');
		foreach($d as $file) unlink($file);
		rmdir($dir.'/tmb');
		$d = glob($dir.'/*');
		foreach($d as $file) unlink($file);
		rmdir($dir);
		return parent::afterDelete();
	}

}
