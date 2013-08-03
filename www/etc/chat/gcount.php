<?php

/*
 * Gcount - get guest count for admin
 *
 */
require_once('dbcon.php');

if (!isset($_COOKIE['_user']))
	die('Hacking attempt');

// Check if we already have a guest
$s = 'select count(*) as c from livechat_guests where cname not in (select cname from livechat_guests_left);'; 

$query = $db->prepare($s);
$query->execute();

$rows = $query->fetchAll();

$count = $rows[0]['c'];

echo json_encode(array('count'=>$count));


$s = 'select * from livechat_guests_left';
$query = $db->prepare($s);
$query->execute();

$data = $query->fetchAll();

foreach ($data as $row) {

	$cname = $row['cname'];
	// Unregister
	$s = 'delete from livechat_taken where cname = :cname'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));

	$s = 'delete from livechat_guests where cname = :cname'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));

	$s = 'delete from livechat_guests_left where cname = :cname'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));

	// Remove conversations
	$s = 'delete from livechat_admininbox where cname = :cname'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));

	$s = 'delete from livechat_clientinbox where cname = :cname'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$cname));
}

?>
