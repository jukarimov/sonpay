<?php

/*
 * Glist - load online guests in chat
 *
 */
require_once('dbcon.php');
session_start();

$leave = false;

if (isset($_POST['leave']))
	$leave = true;

$cname = $_POST['cname'];
if (!$cname) $cname = $_SESSION['user'];

if (!isset($cname))
	die('error');

if ($cname == '')
	die('error');

if (!preg_match("/^([A-Z]|[a-z]|[0-9]|[_]){2,9}$/", $cname)) {
	// check if that's rusky
	if (!preg_match("/^([А-Я]|[а-я]|[0-9]|[_]){2,9}$/u", $cname))
		die('error');
}

// reserved nick names
if ($cname == 'admin' || $cname == 'support')
	die('error');

if ($leave)
{
	$_SESSION['user'] = null;
	unset($_SESSION['user']);

	$s = 'insert into livechat_guests_left values (:cname)'; 
	$query = $db->prepare($s);
	$query->execute(array(
		':cname' => $cname
	));
} else 
{

	$_SESSION['user'] = $cname;

	try {
		$s = 'insert into livechat_guests values (:cname)'; 
		$query = $db->prepare($s);
		$query->execute(array(
			':cname' => $cname
		));

	} catch (Exception $e) {
		echo 'error';
	}

}

?>
