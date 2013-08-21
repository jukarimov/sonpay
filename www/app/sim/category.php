<?php

$RU = array(
	'normal'=>'обычный',
	'golden'=>'золотой',
	'silver'=>'серебряный',
	'symmetric'=>'зеркальный',
	'pretty'=>'красивый',
);

$myrows = array();

if (isset($_COOKIE['_lang'])) {
	if ($_COOKIE['_lang'] == 'ru') {
		$myrows []= array('name'=>$RU['normal'],   'id'=>0);
		$myrows []= array('name'=>$RU['golden'],   'id'=>1);
		$myrows []= array('name'=>$RU['silver'],   'id'=>2);
		$myrows []= array('name'=>$RU['symmetric'],'id'=>3);
		$myrows []= array('name'=>$RU['pretty'],   'id'=>4);
	}
} else {

$myrows []= array('name'=>'normal','id'=>0);
$myrows []= array('name'=>'golden','id'=>1);
$myrows []= array('name'=>'silver','id'=>2);
$myrows []= array('name'=>'symmetric','id'=>3);
$myrows []= array('name'=>'pretty','id'=>4);

}

$data = array(
	'rows' => $myrows,
	'total' => count($myrows)
);

echo json_encode($data);

?>
