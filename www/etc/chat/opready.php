<?php

/*
 * Opready - Guest function to see if there's admin available to chat with
 *
 */
require_once('dbcon.php');

$s = 'select count(*) as c from livechat_online_admins where aname not in (select aname from livechat_taken);'; 

$query = $db->prepare($s);
$query->execute();

$rows = $query->fetchAll();

$count = $rows[0]['c'];

echo $count;
