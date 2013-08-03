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

// Check if that is legit guest
$s = 'select distinct cname from livechat_guests_left where cname = :cname limit 1;'; 
$query = $db->prepare($s);
$query->execute(array(':cname'=>$name));

$crows = $query->fetchAll();
if (count($crows) > 0) {
	// auto drop guest
	$s = 'delete from livechat_taken where cname = :cname;'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$name));

	// also from guests
	$s = 'delete from livechat_guests where cname = :cname;'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$name));

	// also from guests_left
	$s = 'delete from livechat_guests_left where cname = :cname;'; 
	$query = $db->prepare($s);
	$query->execute(array(':cname'=>$name));

	// return null
	$name = $crows[0]['cname'];
}


if (!count($rows))
{
	// take one from guest list
	$s = 'select distinct cname from livechat_guests where cname not in (select cname from livechat_taken) and cname not in (select cname from livechat_guests_left) limit 1;'; 
	$query = $db->prepare($s);
	$query->execute();

	$rows = $query->fetchAll();

	$name = $rows[0]['cname'];

}


echo json_encode(array('name'=>$name));


?>
