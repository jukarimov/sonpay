<?php /* @var $this Controller */


?>
<?php 
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}

if (!Yii::app()->user->isGuest) {
	$mm = new MessageManager();
	$messageCount = $mm->messageCount();
} else
	$messageCount = "err";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.css" />

<!--
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
-->
	<script src="/js/bootbox.min.js"></script>
</head>

<body>

<div class="nav navbar span12">
  <ul>
  <li><a href=""><?php echo Yii::t('navbar', 'nav.home'); ?></a></li>
  <li><a href="#"><?php echo Yii::t('navbar', 'nav.about'); ?></a>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.wrw'); ?></a></li>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.contact'); ?></a></li>
	  <li><a href="#"><?echo Yii::t('widgets', 'live_chat');?></a></li>
	</ul>
    </li>
    <li><a href="#">Service</a>
	<ul>
	  <li><a href="#">Tickets</a></li>
	</ul>
    </li>
    <li>Partners</li>
    <li>Contact</li>
    <li>More</li>
    <li>Links</li>
  </ul>
</div>

<center><img class="banner" src="images/logo.png" /></center>

<div class="langbar">
	<select id="langset" class="input-medium bfh-languages">
		<option value="ru">Язык</option>
		<option value="ru">Русский</option>
		<option value="tj">Точики</option>
		<option value="en">English</option>
	</select>
</div>

<div class="container-fluid" id="page">

	<div class="content-wrap">

	<?php echo $content; ?>

	</div>

	<div class="clear"></div>

</div><!-- page -->

<div id="chat" class="chat" onclick="javascript:switchChat()">
<a href="#" id="gcount" class="chat-alert">?</a>
<p class="chatlabel" id="chatlab"><?echo Yii::t('widgets', 'live_chat');?></p>
<img src="images/chat.png">
</div>

<div class="messenger" id="messenger">
<a href="#" title="open" onclick="switchChat();window.open('/etc/chat/index.php?fs=1');">
<i class="icon-plus-sign"></i></a>
<a style="float:right;" href="#" onclick="switchChat();" title="close">
<i class="icon-remove-sign"></i></a>
<br>
<iframe id="iframechat" height="440" width="440" src=""></iframe>
</div>


<div id="footer">
</div><!-- footer -->

<script>
function switchChat() {

	if ($('#messenger').css('visibility') != 'visible') {
		// start chat here
		$('#iframechat').attr('src',"/etc/chat/index.php");
		$('#messenger').css('visibility','visible')
		$('#chat').css('visibility','hidden')
		$('#chat').css('bottom','-100px')

		$.post('/etc/chat/win.php', { state: 'open' });

	} else {
		$('#messenger').css('visibility','hidden')
		$('#chat').css('visibility','visible')
		$('#chat').css('bottom','100px')

		$.post('/etc/chat/win.php', { state: 'close' });
	}
}
<?php
// Show guest count on support badge
if (!Yii::app()->user->isGuest) 
{
?>
	function gcountPoll() {
	
		$.get('/etc/chat/gcount.php', function(r){
			var count = JSON.parse(r).count;
			$('#gcount').text(count);
		});

		console.log('gcountPoll');
	}
	gcountPoll();
	setInterval('gcountPoll()', 10 * 1000);
<?
}
?>
$(document).ready(function(){
	$('#langset').change(function(){
		var ln = $('#langset').val();
		window.location = "?r=site/locale/" + ln;
	});

	$.get('/etc/chat/win.php?state=wat', function(r){
		if (r == 'open')
			switchChat();
	});

});
</script>
</body>
</html>
