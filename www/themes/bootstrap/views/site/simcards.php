<!DOCTYPE html>
<html>
<head>
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
</style>
</head>
<body>
  <div id="grid">
  </div>
</body>
</html>
