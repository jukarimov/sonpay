<?php

/*
 * Opready - Guest function to see if there's admin available to chat with
 *
 */
require_once('dbcon.php');
session_start();

$cname = 0;

if (isset($_SESSION['user']))
	$cname = $_SESSION['user'];

$s = 'select count(*) as c from livechat_online_admins where aname not in (select aname from livechat_taken);'; 

$query = $db->prepare($s);
$query->execute();

$rows = $query->fetchAll();

$count = $rows[0]['c'];

if ($count == 0 && $cname) {
	// see if it's that we are talking to operator
	$s = 'select count(*) as c from livechat_taken where cname = :cname and aname in';
	// and admin is still online
	$s.= ' (select aname from livechat_online_admins)';

	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));

	$rows = $query->fetchAll();
	$count = $rows[0]['c'];
}

echo $count;
