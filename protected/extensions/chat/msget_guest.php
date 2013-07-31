<?php

/*
 * msget_guest - fetch message from user and deliver to admin
 *
 */
require_once('dbcon.php');

if (!isset($_COOKIE['_user']))
	die('Hacking attempt');

if (isset($_GET['msgid'])) {
	$msgid = $_GET['msgid'];
}

$s = 'select cname,admin from livechat_taken where admin=:admin limit 1'; 
$query = $db->prepare($s);
$query->execute(array(':admin'=>$_COOKIE['_user']));

$data = $query->fetchAll();

if (count($data)) {


$row = $data[0];

//echo $row['cname'],$row['admin'];
//
if (isset($msgid)) {
	$s = 'select msgid,msg from livechat where cname=:cname and msgid = :msgid limit 1'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$row['cname'], ':msgid'=>$msgid));
} else {
	$s = 'select msgid,msg from livechat where cname=:cname limit 1'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$row['cname']));
}

$ret = $query->fetch();

echo json_encode(array('id'=>$ret['msgid'], 'msg'=>$ret['msg']));

}

?>
