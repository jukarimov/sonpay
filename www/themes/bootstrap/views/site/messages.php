<?php
/* @var $this SiteController */
Yii::app()->user->returnUrl = $this->createUrl('/site/messages');

$this->pageTitle=Yii::app()->name . ' - Messages';
$this->breadcrumbs=array(
	'Messages',
);
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css" />
<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
<div class="content">
<h1>Messages</h1>

<div id="messages">
<?php

	$wc = new MessageManager();

	$opt = null;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$opt = $_POST['msgopt'];
	}

	echo $wc->getMessages($opt);

?>
</div>
</div><!-- content -->
<script>

	$(document).ready(function(){

		$('#msgopt').selectpicker();

		$('#chkall').attr('title','All');
		$('#chkall').click(function(){
			if ($('#chkall').attr('checked'))
				$('.chkbox').each(function(e) { this.checked=true; });
			else
				$('.chkbox').each(function(e) { this.checked=null; });
		});
	});
	
</script>
