<?php

/*
 * Get - fetch consequent chat msg from one's inbox
 *
 */
require_once('dbcon.php');
session_start();

$msgid  	= null;
$who		= null;
$isGuest	= null;

// Check who is this
if (isset($_COOKIE['_user']))
{
	$isGuest = false;
	$who = $_COOKIE['_user'];
	if (isset($_POST['id'])) $msgid = $_POST['id'];
}
else if (isset($_SESSION['user']))
{
	$isGuest = true;
	$who = $_SESSION['user'];
	if (isset($_POST['id'])) $msgid = $_POST['id'];
} else {
	die('Hacking attempt! I don\'t know who u r, where u r, but I will find you...');
}

// Now get it jimmy
//
if ($isGuest) {

	if ($msgid) {
		$s = 'select id,msg from livechat_clientinbox where cname=:cname and id = :id'; 
		$query = $db->prepare($s);
		$query->execute(array(':cname'=>$who, ':id'=>$msgid));
	} else {
		$s = 'select id,msg from livechat_clientinbox where cname=:cname order by id desc limit 1'; 
		$query = $db->prepare($s);
		$query->execute(array(':cname'=>$who));
	}
} else {

	if ($msgid) {
		$s = 'select id,msg from livechat_admininbox where aname=:aname and id = :id'; 
		$query = $db->prepare($s);
		$query->execute(array(':aname'=>$who, ':id'=>$msgid));
	} else {
		$s = 'select id,msg from livechat_admininbox where aname=:aname order by id desc limit 1'; 
		$query = $db->prepare($s);
		$query->execute(array(':aname'=>$who));
	}
}

$ret = $query->fetch();

echo json_encode(array('id'=>$ret['id'], 'msg'=>$ret['msg']));

?>
