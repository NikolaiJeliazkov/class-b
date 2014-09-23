<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property string $postId
 * @property string $userId
 * @property string $postStatus
 * @property string $postDate
 * @property string $postTitle
 * @property string $postAnonce
 * @property string $postText
 * @property string $postTags
 * @property string $postLastUpdate
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Post extends CActiveRecord
{
	const STATUS_DRAFT=1;
	const STATUS_PUBLISHED=2;
	const STATUS_ARCHIVED=3;

	private $_oldTags;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Posts the static model class
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
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
// 			array('postTitle', 'required'),
// 			array('postAnonce, postText, postTags', 'safe'),
// 			// The following rule is used by search().
// 			// Please remove those attributes that should not be searched.
// 			array('postStatus, postTitle, postAnonce, postText, postTags', 'safe', 'on'=>'search'),

			array('postTitle, postText, postStatus', 'required'),
			array('postAnonce, postText, postTags', 'safe'),
			array('postStatus', 'in', 'range'=>array(1,2,3)),
			array('postTitle', 'length', 'max'=>128),
// 			array('postTags', 'match', 'pattern'=>'/^[a-zа-яA-ZА-Я\s,]+$/', 'message'=>'Tags може да съдържа само букви.'),
			array('postTags', 'normalizeTags'),

			array('postTitle, postStatus', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'postId' => '#',
			'userId' => 'Автор',
			'postStatus' => 'Статус',
			'postDate' => 'Създаден на',
			'postTitle' => 'Заглавие',
			'postAnonce' => 'Резюме',
			'postText' => 'Текст',
			'postTags' => 'Tags',
			'postLastUpdate' => 'Последно обновен на',
		);
	}

	/**
	 * @return string the URL that shows the detail of the post
	 */
	public function getUrl()
	{
		return Yii::app()->createUrl('post/view', array(
				'id'=>$this->postId,
				'title'=>$this->postTitle,
		));
	}

	/**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Tag::string2array($this->postTags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('post/index', 'tag'=>$tag));
		return $links;
	}

	/**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->postTags=Tag::array2string(array_unique(Tag::string2array(mb_strtolower($this->postTags,'UTF-8'))));
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->_oldTags=$this->postTags;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave() {
		if(parent::beforeSave()) {
// 			$this->postTags = mb_strtolower($this->postTags);
			if($this->isNewRecord) {
				$this->postDate=$this->postLastUpdate=new CDbExpression('NOW()');
				$this->userId=Yii::app()->user->id;
			} else {
				$this->postLastUpdate=new CDbExpression('NOW()');
			}
			return true;
		}
		else
			return false;
	}

	protected function beforeValidate() {
// 		$this->postTags = mb_strtolower($this->postTags);
		return parent::beforeValidate();
	}

	/**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
		parent::afterSave();
		Tag::model()->updateFrequency($this->_oldTags, $this->postTags);
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
// 		Comment::model()->deleteAll('post_id='.$this->id);
		Tag::model()->updateFrequency($this->postTags, '');
	}

	public function getAnonceText() {
		if ($this->postAnonce != '') {
			return $this->postAnonce;
		}
		$s = $this->postText;
		$l = Yii::app()->params['PostPreviewSize'];
		$s = preg_replace('/<p>(.*)<\/p>/i',"\\1\n",$s);
		$s = preg_replace('/<[a-z\/][^>]*>/i','',$s);
		$s = (strlen($s)>$l)?substr($s,0,strpos($s,' ',$l)+1)."...":$s;
		$s = str_replace(array("\r\n", "\n\n", "\r"),"\n",$s);
		$s = strip_tags($s);
		return $s;
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

		$criteria->compare('postId',$this->postId,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('postStatus',$this->postStatus,true);
		$criteria->compare('postDate',$this->postDate,true);
		$criteria->compare('postTitle',$this->postTitle,true);
		$criteria->compare('postAnonce',$this->postAnonce,true);
		$criteria->compare('postText',$this->postText,true);
		$criteria->compare('postTags',$this->postTags,true);
		$criteria->compare('postLastUpdate',$this->postLastUpdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	* @param integer the maximum number of comments that should be returned
	* @return array the most recently added comments
	*/
	public function findRecentPosts($limit=10)
	{
		return $this->findAll(array(
				'condition'=>'postStatus='.self::STATUS_PUBLISHED,
				'order'=>'postDate DESC',
				'limit'=>$limit,
		));
	}

}