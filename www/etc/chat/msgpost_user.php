<?php

/* Send - handle customer chat messages and deliver them to site support service
 *
 *
 * 
 * */
require_once('dbcon.php');
session_start();

if (!isset($_POST['msg']) || !isset($_SESSION['user'])) {
	die('Hacking attempt');
}

	//echo 'got: ' . $_POST['msg'];
	$sid = $_COOKIE['PHPSESSID'];
	$msg = $_POST['msg'];
	$who = $_SESSION['user'];
	if (!$who) $who = $_COOKIE['_user'];

	if (!isset($sid) || !isset($who))
		die('Livechat Hacking attempt!' . $sid .';' . $who);

	$s = 'insert into livechat(phpsid, msg, cname) values(:phpsid, :msg, :who)';
	$query = $db->prepare($s);
	$query->execute(array(
		':phpsid'  	=> $sid,
		':msg' 		=> $msg,
		':who' 		=> $who,
	));

	$ret = array("sid"=>$sid, 'msg'=>$msg, 'who'=>$who);

	echo $db->lastInsertId();
	//echo json_encode($ret);
}


?>
