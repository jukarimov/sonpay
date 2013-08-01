<?php
/*
 * Udrop - remove customer from all chat fields
 *
 */
require_once('dbcon.php');

if (!isset($_COOKIE['_user']) || !isset($_POST['cname']))
	die('Hacking attempt');

// Unregister
$s = 'delete from livechat_taken where cname = :cname'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$_POST['cname']));

$s = 'delete from livechat_guests where cname = :cname'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$_POST['cname']));

// Remove conversations
$s = 'delete from livechat_admininbox where cname = :cname'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$_POST['cname']));

$s = 'delete from livechat_clientinbox where cname = :cname'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$_POST['cname']));

?>
