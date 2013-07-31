<?php

/*
 * Glist - load online guests in chat
 *
 */
require_once('dbcon.php');

if (!isset($_POST['cname']))
	die('Hacking attempt');


$s = 'insert into livechat_guests values (:cname)'; 
$query = $db->prepare($s);
$query->execute(array(
	':cname' => $_POST['cname']
));

?>
