<?

class MessageManager
{
	public function messageCount()
       	{

		$dao = Yii::app()->db;

		$sql = "SELECT COUNT(*) as count FROM sitemessages WHERE unread=true";

		$cmd = $dao->createCommand($sql);

		$cmd->execute();

		$row = $cmd->queryRow();

		return $row['count'];
	}

	public function messageMarkRead($msgid)
	{
		$dao = Yii::app()->db;

		$sql = "UPDATE sitemessages SET unread=false WHERE id=:msgid";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":msgid", $msgid, PDO::PARAM_INT);

		$cmd->execute();
	}

	public function messagePost($name, $email, $subject, $message)
	{
		$dao = Yii::app()->db;

		$sql = "insert into sitemessages(name, email, subject, message) ";
		$sql .= "values (:name, :email, :subject, :message)";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":name",	$name,		PDO::PARAM_STR);
		$cmd->bindParam(":email",	$email, 	PDO::PARAM_STR);
		$cmd->bindParam(":subject",	$subject,	PDO::PARAM_STR);
		$cmd->bindParam(":message",	$message,	PDO::PARAM_STR);

		$cmd->execute();
	}

	public function messageDelete($msgid)
	{
		$dao = Yii::app()->db;

		$sql = "DELETE FROM sitemessages WHERE id=:msgid";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":msgid", $msgid, PDO::PARAM_INT);

		$cmd->execute();
	}

	function __toString() {
		$val = $this->messageCount();
		return (string)$val;
	}

	function setUserEmail($username, $email)
	{
		if (!isset($username) || $username == '')
			return "error";

		if (!isset($email) || $email == '')
			return "error";

		$dao = Yii::app()->db;

		$sql = "UPDATE siteadmins SET email=:email WHERE username=:username";

		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":username", $username, PDO::PARAM_INT);
		$cmd->bindParam(":email", $email, PDO::PARAM_INT);
		$cmd->execute();
	}
	
	function getUserEmail($username)
	{
		if (!isset($username) || $username == '')
			return "error";

		$dao = Yii::app()->db;

		$sql = "SELECT email FROM siteadmins WHERE username=:username";
	
		$cmd = $dao->createCommand($sql);
		$cmd->bindParam(":username", $username, PDO::PARAM_INT);
		$cmd->execute();

		$row = $cmd->queryRow();

		return $row['email'];
	}

	function getMessages($opt=null)
       	{
		$val = $this->messageCount();

		//if (!$val) return "No messages";

		$dao = Yii::app()->db;

		$sql = "SELECT * FROM sitemessages WHERE unread=true";
		if ($opt == 'dump')
			$sql = "SELECT * FROM sitemessages";

		$cmd = $dao->createCommand($sql);

		$cmd->execute();

		$data = $cmd->query();

		$content = "";

		$content .= '<form method="POST" action="">';

		$content .= '<input type="checkbox" id="chkall" />';

		$content .= '<select id="msgopt" name="msgopt">';
		$content .= '<option value="read">Mark read</option>';
		$content .= '<option value="dump">Show all</option>';
		$content .= '<option value="delete">Delete</option>';
		$content .= '</select>';

		$content .= '<button name="submit" type="submit" style="float:right;" class="btn btn-small btn-primary">Go</button>';

		$content .= "<table>";
		while (($row = $data->read()) != false) {
			$content .= '<tr>';

			$content .= '<td><input type="checkbox" value="'.$row['id'].'" name="checkbox[]" class="chkbox" /></td>';

			$content .= '<td class="from">'.$row['name'].'&nbsp;&#60;'.$row['email'].'&#62</td>';
			
			$content .= '<td class="msg"><b class="sbj">'.$row['subject'].'</b><br>'.$row['message'].'</td>';
			
			$content .= '<td>'.$row['postedtime'].'</td>';
			
			$content .= '</tr>';
		}
		$content .= "</table>";
		$content .= '</form>';

		return $content;
	}
};

