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
	$ME = Yii::app()->user->name;
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
  <li><a href="/"><?php echo Yii::t('navbar', 'nav.home'); ?></a></li>
  <li><a href="?r=site/page&view=about"><?php echo Yii::t('navbar', 'nav.about'); ?></a>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.wrw'); ?></a></li>
	  <li><a href="?r=site/contact"><?php echo Yii::t('navbar', 'nav.contact'); ?></a></li>
	  <li><a href="/etc/chat/"><?echo Yii::t('widgets', 'live_chat');?></a></li>
	</ul>
    </li>
    <li><a href="#"><?php echo Yii::t('navbar', 'nav.service'); ?></a>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.tickets'); ?></a></li>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.payment'); ?></a></li>
	</ul>
    </li>
    <li><?php echo Yii::t('navbar', 'nav.partners'); ?>
	<ul class="tab-wide partner-logo">
	  <li><a href="http://babilon-m.tj"><img src="images/babilon.png"></a></li>
	  <li><a href="http://tcell.tj"><img src="images/tcell.png"></a></li>
	  <li><a href="http://beeline.tj"><img src="images/beeline.png"></a></li>
	  <li><a href="http://megafon.tj"><img src="images/megafon.png"></a></li>
	</ul>
    </li>
    <li><a href="?r=site/contact"><?php echo Yii::t('navbar', 'nav.contact'); ?></a></li>
    <li><?php echo Yii::t('navbar', 'nav.more'); ?>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.mobiles'); ?></a></li>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.simcard'); ?></a></li>
	</ul>
    </li>
    <li><?php echo Yii::t('navbar', 'nav.links'); ?>
	<ul>
<?php if (!Yii::app()->user->isGuest) { ?>
	  <li><a href="?r=site/settings"><?php echo Yii::t('navbar', 'nav.settings'); ?></a></li>
	  <li><a href="?r=site/admins"><?php echo Yii::t('navbar', 'nav.admins'); ?></a></li>
	  <li><a href="?r=site/messages"><?php echo Yii::t('navbar', 'nav.messages')."($messageCount)"; ?></a></li>
	  <li><a href="?r=site/logout"><?php echo Yii::t('navbar', 'nav.logout'); ?></a></li>
<?php } else { ?>
	<li><a href="?r=site/login"><?php echo Yii::t('links', 'login3'); ?></a></li>
<?php } ?>
     </ul>
   </li>
  </ul>
</div>

<center><a href="/"><img class="banner" src="images/logo.png" /></a></center>

<div class="langbar">
	<select id="langset" class="input-medium bfh-languages">
		<option value="ru">Язык</option>
		<option value="ru">Русский</option>
		<option value="tj">Тоҷики</option>
		<option value="en">English</option>
	</select>
</div>

<div class="loginpan">
  <ul>
    <li><a href="#"><?php echo Yii::t('links', 'login1'); ?></a></li>
    <li><a href="#"><?php echo Yii::t('links', 'login2'); ?></a></li>
<?php if (Yii::app()->user->isGuest) { ?>
	<li><a href="?r=site/login"><?php echo Yii::t('links', 'login3'); ?></a></li>
<?php } else { ?>
	<li><a href="?r=site/logout"><?php echo Yii::t('links', 'logout')."($ME)"; ?></a></li>
<?php } ?>
  </ul>
</div>

<div class="container-fluid" id="page">

	<div class="content-wrap">

	<?php echo $content; ?>

	</div>

	<div class="clear"></div>

</div><!-- page -->

<div id="chat" class="chat" onclick="javascript:switchChat()">
<a href="#" id="gcount" class="chat-alert"><i class="icon-circle"></i></a>
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


	// try kicking admin see if he is really up online
	function kickAdmin() {
		$.get('/etc/chat/notify.php?state=kick', function(resp) {
			//console.log('notify:' + resp);
		});
	}
	setInterval(kickAdmin, 60 * 1000);

	function adminState() {
		$.get('/etc/chat/opready.php', function(resp) {
			console.log('opready:' + resp);
			if (resp > 0) {
				$('#gcount').attr('class','chat-alert-green');
				$('#gcount').css('text-shadow','1px 1px 10px #0f0');
			} else {
				$('#gcount').attr('class','chat-alert');
				$('#gcount').css('text-shadow','1px 1px 10px #f00');
			}
		});
	}
	
	setInterval(adminState, 5 * 1000);
});
</script>
</body>
</html>
