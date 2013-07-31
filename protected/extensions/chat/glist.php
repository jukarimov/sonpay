<?php

/*
 * Glist - load online guests in chat
 *
 */
require_once('dbcon.php');

if (!isset($_COOKIE['_user']))
	die('Hacking attempt');

// Check if we already have a guest
$s = 'select distinct cname from livechat_taken where aname = :aname limit 1;'; 
$query = $db->prepare($s);
$query->execute(array(':aname'=>$_COOKIE['_user']));

$rows = $query->fetchAll();

$name = $rows[0]['cname'];

if (!count($rows))
{
	// take one from guest list
	$s = 'select distinct name from livechat_guests where name not in (select cname from livechat_taken) limit 1;'; 
	$query = $db->prepare($s);
	$query->execute();

	$rows = $query->fetchAll();

	$name = $rows[0]['name'];

}


echo json_encode(array('name'=>$name));


?>
