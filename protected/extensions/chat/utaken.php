<?php

/*
 * Utaken - mark user as taken, so that other admin wont talk to him
 *
 */
require_once('dbcon.php');
session_start();

if (!isset($_COOKIE['_user']) || !isset($_POST['cname']))
	die('Hacking attempt');


$s = 'insert into livechat_taken(cname, aname) values (:cname, :aname)'; 
$query = $db->prepare($s);
$query->execute(array(
	':cname' => $_POST['cname'],
	':aname' => $_COOKIE['_user'],
));

?>
