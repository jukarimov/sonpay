<?php

/**
 * @From ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class AdminsForm extends CFormModel
{
	public $action;
	public $user_name;
	public $password;
	public $repeat;
	public $email;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('action,user_name', 'required'),
			array('user_name,repeat', 'required', 'on'=>'delete'),
			array('user_name,password,repeat,email', 'required', 'on'=>'create'),
			array('email','email'),
			array('user_name', 'user_nameDeletable', 'on'=>'delete'),
			array('user_name', 'user_nameCreatable', 'on'=>'create'),
			array('password', 'passwordValidate', 'on'=>'create'),
			array('repeat', 'compare', 'compareAttribute'=>'user_name',
		       		'message'=>'User name doesn\'t match', 'on'=>'delete'),
			array('repeat', 'compare', 'compareAttribute'=>'password',
		       		'message'=>'Passwords don\'t match', 'on'=>'create'),
		);
	}

	public function user_nameCreatable()
	{
		$username = $this->user_name;

		if ($this->userExists($username))
			$this->addError('user_name', Yii::t('pages','usernameexists'));
	
		if (!preg_match("/^[a-z][a-z]{2,9}[0-9]{0,3}$/", $this->user_name))
			$this->addError('user_name','Bad user name, try james007 ;)');
	}

	public function user_nameDeletable()
	{
		$username = $this->user_name;

		if ($username === 'admin')
			$this->addError('user_name','This account can not be deleted!');

		if (!$this->userExists($username))
			$this->addError('user_name',Yii::t('pages','err.usernotexist'));
	}

	public function passwordValidate()
	{
		$goodpass = false;

		$goodleng = (strlen($this->password) >= 8);

		$hasAlpha = (preg_match("#[a-z]+#", $this->password));
		$hasDigit = (preg_match("#[0-9]+#", $this->password));
		$hasALPHA = (preg_match("#[A-Z]+#", $this->password));
		$hasSymbol = (preg_match("[!@#$%^&*<>\[\]]", $this->password));

		$goodpass = $goodleng && $hasAlpha && ($hasDigit || $hasALPHA || $hasSymbol);

		if (!$goodpass) {
			$this->addError('password',Yii::t('pages', 'err.passweak'));
		}
	}

	public function userExists($username)
	{
		$dao = Yii::app()->db;

		$sql = "SELECT COUNT(*) as count FROM siteadmins WHERE username=:username";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":username", $username, PDO::PARAM_STR);

		$cmd->execute();

		$row = $cmd->queryRow();

		return $row['count'] > 0;
	}


	/*
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'action'=>Yii::t('pages', 'admins.action'),
			'user_name'=>Yii::t('pages', 'user_name'),
			'password'=>Yii::t('pages', 'password'),
			'repeat' => Yii::t('pages', 'repeat'),
			'email' => Yii::t('pages', 'email'),
		);
	}
}

?>
