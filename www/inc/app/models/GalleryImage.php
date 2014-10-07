<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property string $imageId
 * @property string $galleryId
 * @property string $imageOrder
 * @property string $imageFileId
 * @property string $imageBaseName
 * @property string $imageExtension
 * @property string $imageTitle
 * @property string $imageDescription
 * @property string $imageSize
 * @property string $imageType
 * @property string $imagePath
 * @property string $imageUrl
 * @property string $imageCreated
 * @property string $imageUpdated
 *
 * The followings are the available model relations:
 * @property Galleries $gallery
 */
class GalleryImage extends CActiveRecord
{
	public $image;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('galleryId, imageOrder', 'required'),
			array('galleryId, imageOrder', 'length', 'max'=>10),
			array('imageFileId', 'length', 'max'=>80),
			array('imageBaseName', 'length', 'max'=>45),
			array('imageExtension', 'length', 'max'=>6),
			array('imageTitle, imagePath, imageUrl', 'length', 'max'=>256),
			array('imageSize, imageType', 'length', 'max'=>20),
			array('imageDescription, imageCreated, imageUpdated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('imageId, galleryId, imageOrder, imageFileId, imageBaseName, imageExtension, imageTitle, imageDescription, imageSize, imageType, imagePath, imageUrl, imageCreated, imageUpdated', 'safe', 'on'=>'search'),
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
			'gallery' => array(self::BELONGS_TO, 'Galleries', 'galleryId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'imageId' => '#',
			'galleryId' => 'Gallery',
			'imageOrder' => 'Image Order',
			'imageFileId' => 'Image File',
			'imageBaseName' => 'файл',
			'imageExtension' => 'File Extension',
			'imageTitle' => 'Заглавие',
			'imageDescription' => 'Текст',
			'imageSize' => 'Размер',
			'imageType' => 'Тип',
			'imagePath' => 'Път',
			'imageUrl' => 'Image Url',
			'imageCreated' => 'Image Created',
			'imageUpdated' => 'Image Updated',
		);
	}

	public static function search($galleryId, $pageSize=false) {
		$pagination = ($pageSize===false) ? false : array('pageSize'=>$pageSize);
		$sql = "
select
  count(*)
from
  images
where
  galleryId = :galleryId
";
		$command= Yii::app()->db->createCommand($sql);
		$command->bindParam(":galleryId",$galleryId);
		$count=$command->queryScalar();

		$sql = "
SELECT
	imageId,
	galleryId,
	imageOrder,
	imageFileId,
	imageBaseName,
	imageExtension,
	imageTitle,
	imageDescription,
	imageSize,
	imageType,
	imagePath,
	imageUrl,
	imageCreated,
	imageUpdated
FROM
	images
WHERE
  galleryId = :galleryId
";
		$dataProvider=new CSqlDataProvider($sql, array(
				'keyField'=>'imageId',
				'totalItemCount'=>$count,
				'sort'=>array(
						'defaultOrder'=>array(
								'imageOrder' => CSort::SORT_DESC,
						),
						'attributes'=>array(
								'imageOrder',
						),
				),
				'pagination'=>$pagination,
				'params'=>array(
						':galleryId'=>$galleryId,
				), //needed if $id is not null
		));
		$dataProvider->setId('imageId');
		return $dataProvider;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() {
		if (!is_null($this->image)) {
			$this->imageFileId=$this->image->getName();
			$this->imageBaseName=$this->image->getName();
			$this->imageExtension='.'.strtolower($this->image->getExtensionName());
			$this->imageSize=$this->image->getSize();
			$this->imageType=$this->image->getType();
			$this->imagePath='/galleries';
			$this->imageUrl=null;
			$this->imageCreated=null; //new CDbExpression('NOW()');
			$this->imageUpdated=null; //new CDbExpression('NOW()');
		}
		// 		Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::beforeSave();
	}

	public function afterSave() {
		if (!is_null($this->image)) {
			$dir = realpath('./').$this->imagePath.'/'.$this->galleryId;
			thumbnailsUtil::CreateThumb($this->image->getTempName(), $dir.'/tmb/'.$this->imageBaseName, 200, 130);
			$this->image->saveAs($dir.'/'.$this->imageBaseName);
		}
		// 		Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::afterSave();
	}

	protected function afterDelete()
	{
		$dir = realpath('./').$this->imagePath.'/'.$this->galleryId;
		@unlink($dir.'/'.$this->imageBaseName);
		@unlink($dir.'/tmb/'.$this->imageBaseName);
		return parent::afterDelete();
	}

}
