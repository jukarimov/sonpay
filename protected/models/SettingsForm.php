<?php

/**
 * @From ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class SettingsForm extends CFormModel
{
	public $username;
	public $password;
	public $new_password;
	public $repeat;
	public $email;
	private $_identity;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('password', 'required'),
			array('password', 'authenticate'),
			array('new_password', 'passwordValidate'),
			array('new_password', 'length', 'min'=>8, 'max'=>40),
			array('repeat', 'compare', 'compareAttribute'=>'new_password',
		       		'message'=>'Passwords don\'t match'),
			array('email', 'email'),
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->username = Yii::app()->user->name;
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect password.');
		}
	}

	public function passwordValidate($attribute, $params)
	{
		if ($this->new_password == '') return; // not updating

		if ($this->password === $this->new_password) {
			$this->addError('password','Password matches old password.');
		}
		if ($this->repeat !== $this->new_password) {
			$this->addError('repeat','New password does not match repeated.');
		}
		$goodpass = false;

		$goodleng = (strlen($this->new_password) >= 8);

		$hasAlpha = (preg_match("#[a-z]+#", $this->new_password));
		$hasDigit = (preg_match("#[0-9]+#", $this->new_password));
		$hasALPHA = (preg_match("#[A-Z]+#", $this->new_password));
		$hasSymbol = (preg_match("[!@#$%^&*<>\[\]]", $this->new_password));

		$goodpass = $goodleng && $hasAlpha && ($hasDigit || $hasALPHA || $hasSymbol);

		if (!$goodpass) {
			$this->addError('new_password','Password is too weak.');
		}
	}

	public function updatePassword()
	{
		if($this->hasErrors()) return;

		$dbcon = Yii::app()->db;

		$sqlcd = "UPDATE siteadmins SET password=:password WHERE username = :username";
		$commd = $dbcon->createCommand($sqlcd);
		$commd->bindParam(":password", md5($this->new_password), PDO::PARAM_STR);
		$commd->bindParam(":username", $this->username, PDO::PARAM_STR);
		$commd->execute();

		Yii::log($_SERVER['REMOTE_ADDR'], "warning", "SETTINGS::PASSWORD UPDATED");
	}

	public function updateEmail()
	{
		if($this->hasErrors()) return;

		$dbcon = Yii::app()->db;

		$sqlcd = "UPDATE siteadmins SET email=:email WHERE username = :username";
		$commd = $dbcon->createCommand($sqlcd);
		$commd->bindParam(":email", $this->email, PDO::PARAM_STR);
		$commd->bindParam(":username", $this->username, PDO::PARAM_STR);
		$commd->execute();

		Yii::log($_SERVER['REMOTE_ADDR'], "warning", "SETTINGS::EMAIL UPDATED");
	}
}
