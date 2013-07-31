<?php

class RecoveryForm extends CFormModel
{
	public $newpassword = null;
	public $email;
	public $repeat;

	public $verifyCode;

	public function rules()
	{
		return array(
			array('email,repeat', 'required'),
			array('email', 'email'),
			array('repeat', 'compare', 'compareAttribute'=>'email', 'message'=>'email does\'t match'),
			array('repeat', 'emailValidate'),

			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	public function emailValidate($attribute, $params)
	{
		if ($this->email !== $this->repeat) {
			$this->addError("email", "Email");
			$this->addError("repeat", "does not match.");
		}

		$dbcon = Yii::app()->db;

		$sqlex = "SELECT COUNT(*) as found FROM siteadmins WHERE email=:email";
		$commd = $dbcon->createCommand($sqlex);

		$commd->bindParam(":email", $this->email, PDO::PARAM_STR);
		$commd->execute();

		$data = $commd->queryRow();

		$found = ($data['found'] > 0);

		if (!$found)
			$this->addError("email", "Email did not match any user.");

	}

	public function generatePassword()
	{
		$s="345ABCDEFGmnopqrsHIJK6789LMNOPQRtuvwxyzS012TUVWXijklYZabcdefgh";
		$p="";
		for ($i=0; $i<8; $i++) {
			$p .= $s[rand() % strlen($s)];
		}
		return $p;
	}

	public function setPassword()
	{
		$this->newpassword = $this->generatePassword();
	}

	public function getPassword()
	{
		return $this->newpassword;
	}

	public function updatePassword()
	{
		if (!$this->newpassword || !$this->email) {
			Yii::log("No newpassword or email", "warning", "Recovery::updatePassword");
			return 'error';
		}

		$dbcon = Yii::app()->db;

		$sqlcd = "UPDATE siteadmins SET password=:password WHERE email = :email";
		$commd = $dbcon->createCommand($sqlcd);
		$commd->bindParam(":password", md5($this->newpassword), PDO::PARAM_STR);
		$commd->bindParam(":email", $this->email, PDO::PARAM_STR);
		$commd->execute();

		Yii::log($_SERVER['REMOTE_ADDR'], "warning", "Recovery::PASSWORD UPDATED");
	}
}

?>
