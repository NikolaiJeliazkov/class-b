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
class Images extends CActiveRecord {
	public $image;

	/**
	 *
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'images';
	}

	/**
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array (
			array (
				'galleryId, imageOrder',
				'required'
			),
			array (
				'galleryId, imageOrder',
				'length',
				'max' => 10
			),
			array (
				'imageFileId',
				'length',
				'max' => 80
			),
			array (
				'imageBaseName',
				'length',
				'max' => 45
			),
			array (
				'imageExtension',
				'length',
				'max' => 6
			),
			array (
				'imageTitle, imagePath, imageUrl',
				'length',
				'max' => 256
			),
			array (
				'imageSize, imageType',
				'length',
				'max' => 20
			),
			array (
				'imageDescription, imageCreated, imageUpdated',
				'safe'
			),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array (
				'imageId, galleryId, imageOrder, imageFileId, imageBaseName, imageExtension, imageTitle, imageDescription, imageSize, imageType, imagePath, imageUrl, imageCreated, imageUpdated',
				'safe',
				'on' => 'search'
			),
// 			array (
// 				'image',
// 				'length',
// 				'max' => 255,
// 				'tooLong' => '{attribute} is too long (max {max} chars).',
// 				'on' => 'upload'
// 			),
			array (
				'image',
				'file',
				'types' => 'jpg,jpeg,gif,png',
				'maxSize' => 1024 * 1024 * 2,
				'tooLarge' => 'Size should be less then 2MB !!!',
				'on' => 'upload'
			)
		);
	}

	/**
	 *
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
			'gallery' => array (
				self::BELONGS_TO,
				'Galleries',
				'galleryId'
			)
		);
	}

	/**
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array (
			'imageId' => '#',
			'galleryId' => 'Gallery',
			'imageOrder' => 'Image Order',
			'imageFileId' => 'Image File',
			'imageBaseName' => 'Image Base Name',
			'imageExtension' => 'Image Extension',
			'imageTitle' => 'Image Title',
			'imageDescription' => 'Описание',
			'imageSize' => 'Image Size',
			'imageType' => 'Image Type',
			'imagePath' => 'Image Path',
			'imageUrl' => 'Image Url',
			'imageCreated' => 'Image Created',
			'imageUpdated' => 'Image Updated',
			'image' => 'Зареди файл'
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
	 *         based on the search/filter conditions.
	 */
	public function search() {
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria = new CDbCriteria ();

		$criteria->compare ( 'imageId', $this->imageId, true );
		$criteria->compare ( 'galleryId', $this->galleryId, true );
		$criteria->compare ( 'imageOrder', $this->imageOrder, true );
		$criteria->compare ( 'imageFileId', $this->imageFileId, true );
		$criteria->compare ( 'imageBaseName', $this->imageBaseName, true );
		$criteria->compare ( 'imageExtension', $this->imageExtension, true );
		$criteria->compare ( 'imageTitle', $this->imageTitle, true );
		$criteria->compare ( 'imageDescription', $this->imageDescription, true );
		$criteria->compare ( 'imageSize', $this->imageSize, true );
		$criteria->compare ( 'imageType', $this->imageType, true );
		$criteria->compare ( 'imagePath', $this->imagePath, true );
		$criteria->compare ( 'imageUrl', $this->imageUrl, true );
		$criteria->compare ( 'imageCreated', $this->imageCreated, true );
		$criteria->compare ( 'imageUpdated', $this->imageUpdated, true );

		return new CActiveDataProvider ( $this, array (
			'criteria' => $criteria,
			'sort' => array (
				'defaultOrder' => array (
					'imageOrder' => CSort::SORT_ASC
				),
				'attributes' => array (
					'imageOrder'
				)
			),
			'pagination' => false
		) );
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 *
	 * @param string $className
	 *        	active record class name.
	 * @return Images the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model ( $className );
	}
	public function beforeSave() {
		if (! is_null ( $this->image )) {
			$this->imageFileId = $this->image->getName ();
			$this->imageBaseName = $this->image->getName ();
			$this->imageExtension = '.' . strtolower ( $this->image->getExtensionName () );
			$this->imageSize = $this->image->getSize ();
			$this->imageType = $this->image->getType ();
			$this->imagePath = '/galleries';
			$this->imageUrl = null;
			$this->imageCreated = null; // new CDbExpression('NOW()');
			$this->imageUpdated = null; // new CDbExpression('NOW()');
		}
		// Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::beforeSave ();
	}
	public function afterSave() {
		if (! is_null ( $this->image )) {
			$dir = realpath ( './' ) . $this->imagePath . '/' . $this->galleryId;
			thumbnailsUtil::CreateThumb ( $this->image->getTempName (), $dir . '/tmb/' . $this->imageBaseName, 200, 130 );
			$this->image->saveAs ( $dir . '/' . $this->imageBaseName );
		}
		// Yii::trace(CVarDumper::dumpAsString($this->attributes),'vardump');
		return parent::afterSave ();
	}
	protected function afterDelete() {
		$dir = realpath ( './' ) . $this->imagePath . '/' . $this->galleryId;
		@unlink ( $dir . '/' . $this->imageBaseName );
		@unlink ( $dir . '/tmb/' . $this->imageBaseName );
		return parent::afterDelete ();
	}
}
