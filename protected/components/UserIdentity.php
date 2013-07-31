<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$dbcon = Yii::app()->db;

		$sqlcd = "SELECT * FROM siteadmins WHERE username = :username";
		$commd = $dbcon->createCommand($sqlcd);
		$commd->bindParam(":username", $this->username, PDO::PARAM_STR);
		$commd->execute();

		$data = $commd->queryRow();

		$found = false;
		$passd = false;

		if ($data['password']) {
			$found = true;
			if ($data['password'] == md5($this->password))
				$passd = true;
		}

		if (!$found) {
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			Yii::log('invalid username', 'warning', 'misc');
		}
		elseif (!$passd) {
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			Yii::log('invalid password', 'warning', 'misc');
		} else
			$this->errorCode=self::ERROR_NONE;

		return !$this->errorCode;
	}
}
