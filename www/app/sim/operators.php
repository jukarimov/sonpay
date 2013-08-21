<?php

$myrows = array();

$myrows []= array('name'=>'Babilon-M','id'=>1);
$myrows []= array('name'=>'Beeline','id'=>2);
$myrows []= array('name'=>'Megafon','id'=>3);
$myrows []= array('name'=>'Tcell','id'=>4);

$data = array(
	'rows' => $myrows,
	'total' => 99
);

echo json_encode($data);

?>
