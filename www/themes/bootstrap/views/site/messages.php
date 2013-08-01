<?php
/* @var $this SiteController */
Yii::app()->user->returnUrl = $this->createUrl('/site/messages');
require_once('locale.php');

$this->pageTitle=Yii::app()->name . ' - Messages';
$this->breadcrumbs=array(
	'Messages',
);
?>
<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css" />
<script type="text/javascript" src="js/bootstrap-select.min.js"></script>
<div class="content">
<h1><?php echo Yii::t('pages', 'messages.title'); ?></h1>

<div id="messages" style="margin-bottom: 50px;">
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
