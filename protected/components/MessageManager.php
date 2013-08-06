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
		$content .= '<option value="read">'.Yii::t('pages','messages.mark_read').'</option>';
		$content .= '<option value="dump">'.Yii::t('pages','messages.show_all').'</option>';
		$content .= '<option value="delete">'.Yii::t('pages','messages.delete').'</option>';
		$content .= '</select>';

		$content .= '<button name="submit" type="submit" style="float:right;" class="btn btn-small btn-primary">Go</button>';

		$content .= "<table class=\"mail\">";
		$rc = 0;
		while (($row = $data->read()) != false) {
			$content .= '<tr>';

			$content .= '<td><input type="checkbox" value="'.$row['id'].'" name="checkbox[]" class="chkbox" /></td>';

			$content .= '<td class="from">'.$row['name'].'&nbsp;&#60;'.$row['email'].'&#62</td>';
			
			$content .= '<td onclick="bootbox.alert(this.innerHTML)" class="msg"><b class="sbj">'.$row['subject'].'</b><br>'.$row['message'].'</td>';
			
			$content .= '<td class="msg-time">'.$row['postedtime'].'</td>';
			
			$content .= '</tr>';

			$rc++;
		}
		if (!$rc) {
			$content .= '<h3 class="messages-empty">';
			$content .= Yii::t('pages', 'messages.empty');
			$content .= '</h3>';
		}
		$content .= "</table>";
		$content .= '</form>';

		return $content;
	}
};

