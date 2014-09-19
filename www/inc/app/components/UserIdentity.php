<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity {
	private $_userId;
	public function authenticate() {
		$record=Users::model()->findByAttributes(array('userName'=>$this->username, 'userStatus'=>1));
// 		$record=Users::model()->findBySql("select * from users where userName=:userName and userStatus=:userStatus", array('userName'=>$this->username, 'userStatus'=>1));
		if($record===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($record->userPass!==Users::encrypt($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->_userId=$record->userId;
			$this->setState('userType', $record->userType);
			$this->setState('userName', $record->userName);
			$this->setState('userEmail', $record->userEmail);
			$this->setState('userIsVisible', $record->userIsVisible);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_userId;
	}

}





// class UserIdentity extends CUserIdentity
// {
// 	/**
// 	 * Authenticates a user.
// 	 * The example implementation makes sure if the username and password
// 	 * are both 'demo'.
// 	 * In practical applications, this should be changed to authenticate
// 	 * against some persistent user identity storage (e.g. database).
// 	 * @return boolean whether authentication succeeds.
// 	 */
// 	public function authenticate()
// 	{
// 		$users=array(
// 			// username => password
// 			'demo'=>'demo',
// 			'admin'=>'admin',
// 		);
// 		if(!isset($users[$this->username]))
// 			$this->errorCode=self::ERROR_USERNAME_INVALID;
// 		else if($users[$this->username]!==$this->password)
// 			$this->errorCode=self::ERROR_PASSWORD_INVALID;
// 		else
// 			$this->errorCode=self::ERROR_NONE;
// 		return !$this->errorCode;
// 	}
// }