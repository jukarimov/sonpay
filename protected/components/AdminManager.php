<?php

class AdminManager
{
	public function createAdmin($params)
	{
		$username = $params["username"];
		$password = $params["password"];
		$email    = $params["email"];

		$password = md5($password);

		$dao = Yii::app()->db;

		$sql = "insert into siteadmins(username, password, email) ";
		$sql .= "values (:username, :password, :email)";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":username",	$username,	PDO::PARAM_STR);
		$cmd->bindParam(":password",	$password, 	PDO::PARAM_STR);
		$cmd->bindParam(":email",	$email, 	PDO::PARAM_STR);

		$cmd->execute();
	}

	public function deleteAdmin($username)
	{
		$dao = Yii::app()->db;

		$sql = "delete from siteadmins where username = :username";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":username",	$username,	PDO::PARAM_STR);

		$cmd->execute();
	}
}

?>
