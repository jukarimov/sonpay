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
			array('password', 'required',
		       		'message'=>Yii::t('flash', 'password.isempty'),
			),
			array('password', 'authenticate'),
			array('new_password', 'passwordValidate'),
			array('new_password', 'length', 'min'=>8, 'max'=>40,
				'message'=>Yii::t('pages','password.tooshort')
			),
			array('repeat', 'compare', 'compareAttribute'=>'new_password',
		       		'message'=>Yii::t('pages', 'password.dontmatch'),
			),
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
				$this->addError('password',Yii::t('pages','password.incorrect'));
		}
	}

	public function passwordValidate($attribute, $params)
	{
		if ($this->new_password == '') return; // not updating

		if ($this->password === $this->new_password) {
			$this->addError('password',Yii::t('pages','password.matchesold'));
		}
		if ($this->repeat !== $this->new_password) {
			$this->addError('repeat',Yii::t('pages','password.notmatched'));
		}
		$goodpass = false;

		$goodleng = (strlen($this->new_password) >= 8);

		$hasAlpha = (preg_match("#[a-z]+#", $this->new_password));
		$hasDigit = (preg_match("#[0-9]+#", $this->new_password));
		$hasALPHA = (preg_match("#[A-Z]+#", $this->new_password));
		$hasSymbol = (preg_match("[!@#$%^&*<>\[\]]", $this->new_password));

		$goodpass = $goodleng && $hasAlpha && ($hasDigit || $hasALPHA || $hasSymbol);

		if (!$goodpass) {
			$this->addError('new_password',Yii::t('pages','password.weak'));
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

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>Yii::t('pages', 'current_password'),
			'new_password'=>Yii::t('pages', 'new_password'),
			'repeat' => Yii::t('pages', 'repeat'),
			'email' => Yii::t('pages', 'email'),
		);
	}
}
