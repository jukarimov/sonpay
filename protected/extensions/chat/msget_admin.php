<?php

/*
 * msget_admin - fetch message from admin and deliver to guest
 *
 */
require_once('dbcon.php');
session_start();

//echo $_SESSION['user'];

if (!isset($_SESSION['user']))
	die('Hacking attempt');


$s = 'select cname,admin from livechat_taken where cname=:cname'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$_SESSION['user']));

$data = $query->fetch();


if (count($data) != 0 && $data[0]) {

	$row = $data[0];

	//echo $row['cname'],$row['admin'];

	$s = 'select msgid,msg from livechat where admin=:admin limit 1'; 
	$query = $db->prepare($s);
	$query->execute(array(':admin'=>$row['admin']));

	$ret = $query->fetch();

	echo json_encode(array('id'=>$ret['msgid'], 'msg'=>$ret['msg']));
}

?>
