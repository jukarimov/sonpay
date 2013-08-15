<?php

/*
 * Notify - set admin online status for guests
 *
 */
require_once('dbcon.php');
session_start();

$state = 'down';

if (isset($_COOKIE['_user']) && isset($_GET['state'])) {
	$state = $_GET['state'];
}

if ($state == 'up') {

	$s = 'insert into livechat_online_admins(aname) values (:aname)'; 
	$query = $db->prepare($s);
	$query->execute(array(
		':aname' => $_COOKIE['_user'],
	));

	echo 'added';

} else {

	$s = 'delete from livechat_online_admins'; // clean up
	$query = $db->prepare($s);
	$query->execute();

	echo 'kicked';
}

?>
