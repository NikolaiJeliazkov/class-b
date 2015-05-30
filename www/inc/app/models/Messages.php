<?php

class Messages extends CFormModel
{
	public $messageId;
	public $messageStatus;
	public $messageDate;
	public $messageFrom;
	public $messageFromUserId;
	public $messageFromStudent;
	public $messageFromStudentId;
	public $fromVisible;
	public $fromUserType;
	public $messageTo;
	public $messageToUserId;
	public $messageToStudent;
	public $messageToStudentId;
	public $toVisible;
	public $toUserType;
	public $messageSubject;
	public $messageText;
	public $messageParent;
	public $searchField;
	public $ids;
	public $action;

	private $_selectClause;
	private $_sql;
	private $_asRecipientClause;
	private $_asSenderClause;

	public function init() {
		parent::init();
		$this->_selectClause = '
  m.messageId,
  mt.messageStatus,
  m.messageDate,
  coalesce(u.userFullName, u.userName) as messageFrom,
  u.userId as messageFromUserId,
  coalesce(ur.userFullName, ur.userName) as messageTo,
  ur.userId as messageToUserId,
  m.messageSubject,
  m.messageText,
  u.userIsVisible as fromVisible,
  ur.userIsVisible as toVisible,
  u.userType as fromUserType,
  ur.userType as toUserType,
  s.studentName as messageFromStudent,
  u.studentId as messageFromStudentId,
  sr.studentName as messageToStudent,
  ur.studentId as messageToStudentId
';
		$this->_sql = "
select %s
from
  (messages m
  inner join users u on m.messageFrom=u.userId
  inner join messagesto mt on m.messageId=mt.messageId
  inner join users ur on mt.messageTo=ur.userId
  ) left join students s on u.studentId=s.studentId
  left join students sr on ur.studentId=sr.studentId
where
";
		$this->_asRecipientClause = " mt.messageTo=".Yii::app()->user->getId()." and mt.messageStatus<2
";
		$this->_asSenderClause = " m.messageFrom=".Yii::app()->user->getId()."
";
		if ($this->getScenario() == 'outbox') {
			$this->_sql.= $this->_asSenderClause;
		} else {
			$this->_sql.= $this->_asRecipientClause;
		}

	}

	public function rules()
	{
		return array(
			array('messageTo, messageSubject', 'required'),
			array('messageSubject, messageText', 'safe'),
			array('searchField', 'safe', 'on'=>'search'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'messageId' => '#',
			'messageStatus' => 'Статус',
			'messageDate' => 'Изпратено',
			'messageFrom' => 'Изпращач',
			'messageFromStudent' => 'Ученик',
			'messageTo' => 'Получател',
			'messageToStudent' => 'Ученик',
			'messageSubject' => 'Тема',
			'messageText' => 'Текст',
			'searchField' => '...',
		);
	}

	public function search()
	{
		$sql = $this->_sql;
		if ($this->searchField != '') {
			$sql.="and lower(concat(m.messageSubject,m.messageText,messageFrom)) like lower('%%".$this->searchField."%%')";
		}
		$count=Yii::app()->db->createCommand(sprintf($sql,'count(*)'))->queryScalar();
		$sql=sprintf($sql,$this->_selectClause);
		$dataProvider=new CSqlDataProvider($sql, array(
			'totalItemCount'=>$count,
			'id'=>'messages0',
			'keyField'=>'messageId',
			'sort'=>array(
				'defaultOrder'=>array(
					'messageDate'=>CSort::SORT_DESC,
				),
				'attributes'=>array(
					'messageDate',
				),
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		$dataProvider->setId('messageId');
		return $dataProvider;
	}

	public function loadModel($id)
	{
		$sql = $this->_sql;
		$sql.=" and m.messageId=".$id;
		$all=Yii::app()->db->createCommand(sprintf($sql,$this->_selectClause))->queryRow();
		$a = $this->attributeNames();
		foreach($a as $attr) {
			$this->$attr = null;
			if (isset($all[$attr])) {
				$this->$attr = $all[$attr];
			}
		}
		if ($all['fromVisible']==0) {
			if ($all['fromUserType']==3) {
				$this->messageFrom = 'класен ръководител';
			} else {
				$this->messageFrom = 'родител';
			}
		}
		if ($all['toVisible']==0) {
			if ($all['toUserType']==3) {
				$this->messageTo = 'класен ръководител';
			} else {
				$this->messageTo = 'родител';
			}
		}
	}

	public function markAsRead() {
		$sql = 'update messagesto set messageStatus=1 where messageId=? and messageTo=?';
		$all=Yii::app()->db->createCommand($sql)->execute(array($this->messageId, $this->messageToUserId));
		$this->loadModel($this->messageId);
	}

	public function markAsDeleted($id) {
		$this->loadModel($id);
		$sql = 'update messagesto set messageStatus=2 where messageId=? and messageTo=?';
		$all=Yii::app()->db->createCommand($sql)->execute(array($this->messageId, $this->messageToUserId));
	}

	public function getAddressBook() {
		$userTypes = array('0'=>'ученик','1'=>'родител', '2'=>'учител', '3'=>'класен ръководител');
		$sql = '
select
  u.userId,
  u.userType
from
  users u
  left join students s on u.studentId=s.studentId
where
  u.userType<>100
  and u.userId<>?
order by u.userType desc, s.studentOrder
';
		$all=Yii::app()->db->createCommand($sql)->queryAll(true, array(Yii::app()->user->getId()));
		$q[] = array('id'=>0,'text'=>'Всички');
		foreach($all as $u) {
			$q[] = array('id'=>$u['userId'],'text'=>Users::getUserLabel($u['userId']),'group'=>$userTypes[$u['userType']]);
		}
		return $q;
	}

	public function newMessageSave() {
// 		$sql = '
// select
// 	u.userId,
// 	coalesce(u.userFullName, u.userName) as userName,
// 	u.userType,
// 	u.userIsVisible,
// 	s.studentName,
// 	s.studentOrder
// from
// 	users u
// 	left join students s on u.studentId=s.studentId
// where
// 	u.userId=?
// ';
// 		$row=Yii::app()->db->createCommand($sql)->queryRow(true, array(Yii::app()->user->getId()));
		$utext = Users::getUserLabel();

		$this->messageFrom = Yii::app()->user->getId();
		$this->messageStatus = 0;
		$sql = "select userId, userEmail from users where userType<>100 and userId<>?";
		$binds = array($this->messageFrom);
		if ($this->messageTo > 0) {
			$sql.=" and userId=?";
			array_push($binds, $this->messageTo);
		} else {
			//$sql.=" and userType=1";
		}
		$all=Yii::app()->db->createCommand($sql)->queryAll(true, $binds);
		if (count($all) == 0) {
			print_r($this);
			return false;
		}
		$sql = 'insert into messages(messageParent, messageStatus, messageDate, messageFrom, messageSubject, messageText) values(?, ?, now(), ?, ?, ?)';
		$sql1 = 'insert into messagesto(messageId, messageTo, messageStatus) values(?, ?, ?)';
		$a=Yii::app()->db->createCommand($sql)->execute(array($this->messageParent, $this->messageStatus, $this->messageFrom, $this->messageSubject, $this->messageText));
		$mid = Yii::app()->db->lastInsertID;

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers.= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
		$headers.= 'From: '.Yii::app()->params['adminEmail']."\r\n";
		$headers.= 'Content-Transfer-Encoding: 7bit' . "\r\n";

		$emailSubject = "=?UTF-8?B?" . base64_encode(Yii::app()->params['appName'].' - '.$this->messageSubject) . "?=";
		$emailText = "Получихте ново съобщение от {$utext}, което можете да прочетете на адрес\n";
		$emailText.= Yii::app()->params['appUrl']."/messages/inbox/{$mid}\n\n";
		$emailText.= "ТОВА Е АВТОМАТИЧНО ГЕНЕРИРАНО СЪОБЩЕНИЕ. МОЛЯ, НЕ ОТГОВАРЯЙТЕ!\n\n";

		foreach ($all as $r) {
			$a=Yii::app()->db->createCommand($sql1)->execute(array($mid, $r['userId'], $this->messageStatus));
			if ($r['userEmail'] != '') {
				@mail($r['userEmail'],$emailSubject,$emailText,$headers);
			}
		}
		return true;
	}

	public static function countNew() {
		try {
			$sql = "
select count(*)
from
	messages m
	inner join messagesto mt on m.messageId=mt.messageId
where
	mt.messageTo=? and mt.messageStatus=0
";
			$count=Yii::app()->db->createCommand($sql)->queryScalar(array(Yii::app()->user->getId()));
		} catch (Exception $e) {
			$count = 0;
		}
		return $count;
	}

}