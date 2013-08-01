<?php

/*
 * Glist - load online guests in chat
 *
 */
require_once('dbcon.php');
session_start();

$cname = $_POST['cname'];
if (!$cname) $cname = $_SESSION['user'];

if (!isset($cname))
	die('Hacking attempt');

if ($cname == '')
	die('Hacking attempt');

if (!preg_match("/^([A-Z]|[a-z]|[0-9]|[_]){2,9}$/", $cname))
	die('Hacking attempt');

if ($cname == 'admin' || $cname == 'support')
	die('Hacking attempt');

$_SESSION['user'] = $cname;

$s = 'insert into livechat_guests values (:cname)'; 
$query = $db->prepare($s);
$query->execute(array(
	':cname' => $cname
));

?>
