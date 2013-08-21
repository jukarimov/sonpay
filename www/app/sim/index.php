<?php

$ops = array();

$oplist = array(
	'Babilon-M'=>0,
	'Beeline'=>1,
	'Megafon'=>2,
	'Tcell'=>3
);

$ops []= 'Babilon-M';
$ops []= 'Beeline';
$ops []= 'Megafon';
$ops []= 'Tcell';

		//echo '{rows:[],total:0}';
		$myrows = array();

		$total = 100;
		$limit = 10;
		$start = 0;
		$page = 0;

		if (isset($_GET['page'])) {
			$page = $_GET['page'];
			$start = ($page - 1) * $limit;
		}

		if (isset($_GET['rows'])) {
			$rows = $_GET['rows'];
			$limit = $rows;
			$start = ($page - 1) * $limit;
		}

		/* Process filters */
		if (isset($_GET['sqlc'])) {
			$sqlc = trim($_GET['sqlc']);
			$items = explode(",", $sqlc);

			if ($items[0] == 'operator') {
				if ($items[1] == 'eq') {
					$myop = $items[2];
				}
			}
		}

		for($i=$start,$c=0; $i<$total; $i++) {
			if ($myop)
				$op = $myop;
			else
				$op = $ops[rand() % count($ops)];
			$myrows[]=array(
				'id'=>$i,
				'operator'=>$op,
				'category'=>'category'.$i,
				'tarif'=>'tarif'.$i,
				'number'=>$i.'112233',
			);
			if (++$c > $limit) break;
		}
		if ($sqlc) {
			$total = $c;
		}

		$data = array(
			'rows' => $myrows,
			'total' => $total
		);
		echo json_encode($data);
?>
