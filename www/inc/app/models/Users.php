<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property string $userId
 * @property string $userStatus
 * @property integer $userType
 * @property string $userName
 * @property string $userPass
 * @property string $userFullName
 * @property string $studentId
 * @property string $userEmail
 * @property string $userPhones
 * @property integer $userIsVisible
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Messages[] $messages
 * @property Posts[] $posts
 * @property Students $student
 */
class Users extends CActiveRecord
{
	public $userPass_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userType, userName, userPass', 'required'),
			array('userType, userIsVisible', 'numerical', 'integerOnly'=>true),
			array('userStatus, studentId', 'length', 'max'=>10),
			array('userName, userPass, userFullName', 'length', 'max'=>255),
			array('userPass', 'compare'),
			array('userEmail, userPhones, userFullName, notes', 'safe'),
			array('userPass_repeat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userName, userFullName, userEmail', 'safe', 'on'=>'search'),
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
			'messages' => array(self::MANY_MANY, 'Messages', 'messagesto(messageTo, messageId)'),
			'posts' => array(self::HAS_MANY, 'Posts', 'userId'),
			'student' => array(self::BELONGS_TO, 'Students', 'studentId', 'order'=>'studentOrder'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => '#',
			'userStatus' => 'Статус',
			'userType' => 'Тип',
			'userName' => 'Име',
			'userPass' => 'Парола',
			'userPass_repeat' => 'Повторете паролата',
			'userFullName' => 'Име и Фамилия',
			'studentId' => 'Ученик',
			'userEmail' => 'Email',
			'userPhones' => 'Телефони',
			'userIsVisible' => 'Видим',
			'notes' => 'Бележки',
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
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userFullName',$this->userFullName,true);
		$criteria->compare('userEmail',$this->userEmail,true);
		$criteria->with = 'student';
		if (Yii::app()->user->getState('userType')!=100) {
			$criteria->addCondition('userType<3');
		}

		$sort = new CSort;
		$sort->defaultOrder = 'student.studentOrder ASC';
		$sort->attributes = array(
			'userName' => 'userName',
			'userFullName' => 'userFullName',
			'userEmail' => 'userEmail',
			'student.studentName' => array('asc'=>'student.studentOrder', 'desc'=>'student.studentOrder desc'),
		);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>array( 'pageSize'=>50,),
		));
	}

	public function delete()
	{
		if(!$this->getIsNewRecord() && $this->userId==1) {
			throw new CDbException(Yii::t('yii','User account cannot be deleted because it is an administrator.'));
		}
		return parent::delete();
	}

	/**
	* perform one-way encryption on the password before we store it in
	the database
	*/
	protected function afterValidate()
	{
		parent::afterValidate();
		$this->userPass = self::encrypt($this->userPass);
	}
	public static function encrypt($value)
	{
// 		return $value;
		return md5($value);
	}

	public function getStudentsList() {
		$model = Students::model();
		$a = $model->findAll();
		$q[0]='-';
		foreach($a as $aa) {
			$q[$aa->studentId]=$aa->studentOrder . '. ' . $aa->studentName;
		}
		return $q;
	}
}