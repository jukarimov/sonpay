<?
Yii::app()->user->returnUrl = $this->createUrl('/site/simcards');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>simcards</title>
<link href="/media/kendoui/styles/kendo.common.min.css" rel="stylesheet">
<link href="/media/kendoui/styles/kendo.default.min.css" rel="stylesheet">
<script src="/media/kendoui/js/jquery.min.js"></script>
<script src="/media/kendoui/js/kendo.web.min.js"></script>
<script src="/js/simcards.kendo.js"></script>
<style>
*.k-state-selected, .k-item.k-state-selected.k-state-focused {
	background-color: #E00;
}
*.k-state-focused {
	color: #fff;
	background-color: #BE1F0A;
}
#grid {
	margin-top: 30px;
}
#grid a {
	text-decoration: none;
}
.k-button:hover {
	color: #fff;
	background-color: #BE1F0A;
}
.k-widget .k-dropdown-wrap:hover {
	background-color: #BE1F0A;
}
.k-widget .k-dropdown-wrap:hover > .k-input {
	color: #fff;
}
.k-item.k-state-hover {
	color: #fff;
	background-color: #BE1F0A;
}
body {
	background-color: maroon;
}

.langbar {
	position: absolute;
	top: 1px;
	right: 1px;
}
#langset {
	height: 25px;
	opacity: 0.5;
	font-size: 11px;
	width: 83px;
}
#langset:hover,#langset:active {
	opacity: 1;
}
</style>
<script>
$(document).ready(function(){
	$('#langset').change(function(){
		var ln = $('#langset').val();
		window.location = "?r=site/locale/" + ln;
	});

	var locale = document.cookie.search('_lang');
	if (locale == -1) {
		window.location = "?r=site/locale/ru";
	}
	var lang = document.cookie.slice(locale).split('=')[1];
	$('#langset').val(lang);
});
</script>
</head>
<body>
<a class="btn btn-small btn-danger link-home">Home</a>
<div class="langbar">
	<select id="langset" class="input-small bfh-languages">
		<option value="ru">Язык</option>
		<option value="ru">Русский</option>
		<option value="tj">Тоҷики</option>
		<option value="en">English</option>
	</select>
</div>
  <div id="grid">
  </div>
</body>
</html>
