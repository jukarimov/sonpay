<?php

/*
 * Gcount - get guest count for admin
 *
 */
require_once('dbcon.php');

if (!isset($_COOKIE['_user']))
	die('Hacking attempt');

// Check if we already have a guest
$s = 'select count(*) as c from livechat_guests'; 

$query = $db->prepare($s);
$query->execute();

$rows = $query->fetchAll();

$count = $rows[0]['c'];

echo json_encode(array('count'=>$count));

?>
