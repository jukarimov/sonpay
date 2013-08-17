<?php

/* Send - handle chat messages and deliver them to people
 *
 *
 * 
 * */
require_once('dbcon.php');
session_start();


$aname = null;
$cname = null;
$msg = null;

$who = null;
$oponent = null;
$isGuest = null;
$oponent = null;

if (isset($_POST['msg'])) {

	$msg = $_POST['msg'];

	// who is this?
	if ($_COOKIE['_user']) { // if online support

		$who = $_COOKIE['_user'];
		if (!isset($who) || empty($who))
			die('{err: "Livechat Hacking attempt!"}');

		$isGuest = false;
	
		// who we talking to?
		$s = 'select cname,aname from livechat_taken where aname=:aname'; 
		$query = $db->prepare($s);
		$query->execute(array(':aname'=>$who));

		$rows = $query->fetch();

		$oponent = $rows['cname'];

	} else {  // this is guest

		$isGuest = true;
	
		$who = $_SESSION['user'];
		if (!isset($who))
			die('{err: "Livechat Hacking attempt!"}');

	
		// who we talking to?
		$s = 'select cname,aname from livechat_taken where cname=:cname'; 
		$query = $db->prepare($s);
		$query->execute(array(':cname'=>$who));

		$rows = $query->fetch();

		$oponent = $rows['aname'];
	}


	if ($isGuest) { // send it to admin
	
		$s = 'insert into livechat_admininbox(aname, cname, msg) values(:aname, :cname, :msg)';

		$aname 	= $oponent;
		$cname 	= $who;
		$msg	= $_POST['msg'];

		$query = $db->prepare($s);
		$query->execute(array(
			':aname'  	=> $aname,
			':cname' 	=> $cname,
			':msg' 		=> $msg,
		));
	} else {  // msg for guest
	
		$s = 'insert into livechat_clientinbox(cname, aname, msg) values(:cname, :aname, :msg)';

		$aname 	= $who;
		$cname 	= $oponent;
		$msg	= $_POST['msg'];

		$query = $db->prepare($s);
		$query->execute(array(
			':cname' 	=> $cname,
			':aname'  	=> $aname,
			':msg' 		=> $msg,
		));
	}

	echo $db->lastInsertId();

	// log everything now
	// except system messages like [typing]*
	if ($msg != '[typing]') {
		$s = 'insert into livechat_conversation_log(aname, cname, msg, saidAdmin)';
		$s .=' values(:aname, :cname, :msg, :saidAdmin)';
		$query = $db->prepare($s);
		$query->execute(array(
			':aname' 	=> $aname,
			':cname'  	=> $cname,
			':msg' 		=> $msg,
			':saidAdmin'	=> ($isGuest == false)
		));
	}
}


?>
