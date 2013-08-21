<?php

$LANG = $_COOKIE['_lang'];

if (!$LANG) $LANG = 'en';

if (isset($_POST['lang']))
	$LANG = $_POST['lang'];

$val = null;

if (isset($_POST['val']))
	$val = $_POST['val'];

if (!$val) die('novalue');


$TJ = array(
	'select operator' => 'Интихоби оператор',
	'select category' => 'Интихоби категория',

	'filter.eq' => 'Баробар',
	'filter.neq' => 'Баробар Не',
	'filter.startswith' => 'Дар аввал',
	'filter.endswith' => 'Дар охир',
	'filter.contains' => 'Иборат',

	'and' => 'Ва',
	'or' => 'Ё',

	'filter' => 'филтр',
	'clear' => 'бекор',

	'show items with value that:' => 'Филтр бо:',

	'Operator' => 'Оператор',
	'Category' => 'Категория',
	'Tarif' => 'Тариф',
	'Number' => 'Номер',
);

$RU = array(
	'select operator' => 'Выберите оператор',
	'select category' => 'Выберите категорию',

	'filter.eq' => 'Равно',
	'filter.neq' => 'Не равно',
	'filter.startswith' => 'Начинается',
	'filter.endswith' => 'Оканчивается',
	'filter.contains' => 'Содержит',

	'and' => 'И',
	'or' => 'Или',

	'filter' => 'применить',
	'clear' => 'сброс',
	'show items with value that:' => 'Отфильтровать по:',

	'Operator' => 'Оператор',
	'Category' => 'Категория',
	'Tarif' => 'Тариф',
	'Number' => 'Номер',

);

$EN = array(
	'select operator' => 'Select operator',
	'select category' => 'Select category',

	'filter.eq' => 'Equals',
	'filter.neq' => 'Not Equals',
	'filter.startswith' => 'Starts with',
	'filter.endswith' => 'Ends with',
	'filter.contains' => 'Contains',

	'and' => 'And',
	'or' => 'Or',
);

$trn = null;

if ($LANG == 'en')
	$trn = $EN[$val];
if ($LANG == 'ru')
	$trn = $RU[$val];
if ($LANG == 'tj')
	$trn = $TJ[$val];



if (!$trn) die('notranslation');

echo $trn;

?>
