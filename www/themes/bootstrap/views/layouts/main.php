<?php /* @var $this Controller */ ?>
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

if (isset($_GET['r'])):

if ($_GET['r'] == 'site/simcards') {
       
	/* This is special page */

	Yii::app()->bootstrap->register();
	echo $content;

	return;
}

endif;

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
  <li><a href="?r=site/page&view=about#content"><?php echo Yii::t('navbar', 'nav.about'); ?></a>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.wrw'); ?></a></li>
	  <li><a href="?r=site/contact#content"><?php echo Yii::t('navbar', 'nav.contact'); ?></a></li>
	  <li><a href="/etc/chat/"><?echo Yii::t('widgets', 'live_chat');?></a></li>
	</ul>
    </li>
    <li><a href="#"><?php echo Yii::t('navbar', 'nav.service'); ?></a>
	<ul>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.tickets'); ?></a></li>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.payment'); ?></a></li>
	  <li><a href="#"><?php echo Yii::t('navbar', 'nav.mobiles'); ?></a></li>
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
    <li><a href="?r=site/contact#content"><?php echo Yii::t('navbar', 'nav.contact'); ?></a></li>
    <li><a href="?r=site/simcards"><?php echo Yii::t('navbar', 'nav.simcard'); ?></a></li>
    <li><?php echo Yii::t('navbar', 'nav.links'); ?>
	<ul>
<?php if (!Yii::app()->user->isGuest) { ?>
	  <li><a href="?r=site/settings#content"><?php echo Yii::t('navbar', 'nav.settings'); ?></a></li>
	  <li><a href="?r=site/admins#content"><?php echo Yii::t('navbar', 'nav.admins'); ?></a></li>
	  <li><a href="?r=site/messages#content"><?php echo Yii::t('navbar', 'nav.messages')."($messageCount)"; ?></a></li>
	  <li><a href="?r=site/logout"><?php echo Yii::t('navbar', 'nav.logout'); ?></a></li>
<?php } else { ?>
	<li><a href="?r=site/login#content"><?php echo Yii::t('links', 'login3'); ?></a></li>
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

<div class="informers">

<div id="yaweather">
<font><?php echo Yii::t('pages','layout.weather'); ?><i class="icon-remove" onclick="$('#yaweather').hide();"></i></font>
<a href="http://clck.yandex.ru/redir/dtype=stred/pid=7/cid=1228/*http://pogoda.yandex.ru/dushanbe"><img src="http://info.weather.yandex.net/dushanbe/1.ru.png" border="0" alt=""/><img width="1" height="1" src="http://clck.yandex.ru/click/dtype=stred/pid=7/cid=1227/*http://img.yandex.ru/i/pix.gif" alt="" border="0"/></a>
</div>

<div class="exrate">
<p>
<?php echo Yii::t('pages','layout.exrate'); ?>
<?php echo Yii::t('pages','layout.exrate.on'); ?>
<?php

$nbt_html = Yii::app()->basePath . '/../www/cache/nbt.html';

if (file_exists($nbt_html)) {
	echo date("m/d/Y", filemtime($nbt_html));
} else {
	echo "404";
}

?>
</p>
<i class="icon-remove" onclick="$('.exrate').hide();"></i>
  <div id="USD"></div>
  <div id="EUR"></div>
  <div id="RUS"></div>
</div>

</div><!-- .informers -->

<div class="loginpan">
  <ul>
    <li><a href="#"><?php echo Yii::t('links', 'login1'); ?></a></li>
    <li><a href="#"><?php echo Yii::t('links', 'login2'); ?></a></li>
<?php if (Yii::app()->user->isGuest) { ?>
	<li><a href="?r=site/login#content"><?php echo Yii::t('links', 'login3'); ?></a></li>
<?php } else { ?>
	<li><a href="?r=site/logout"><?php echo Yii::t('links', 'logout')."($ME)"; ?></a></li>
<?php } ?>
  </ul>
</div>

<div class="poll">
<p class="poll-title"><?php echo Yii::t('pages','sitepoll'); ?></p>
<p class="poll-subject"><?php echo Yii::t('pages','sitepoll1.subject'); ?></p>
<form method="POST" action="?r=site/sitepoll">

<div class="option"><input type="radio" name="vote_id" value="1" id="option1"/></div>
<label for="option1"><div class="option-label">&nbsp;<?php echo Yii::t('pages', 'sitepoll1.option1'); ?></div></label>

<div class="option"><input type="radio" name="vote_id" value="2" id="option2"/></div>
<label for="option2"><div class="option-label">&nbsp;<?php echo Yii::t('pages', 'sitepoll1.option2'); ?></div></label>

<div class="option"><input type="radio" name="vote_id" value="3" id="option3"/></div>
<label for="option3"><div class="option-label">&nbsp;<?php echo Yii::t('pages', 'sitepoll1.option3'); ?></div></label>

<input type="hidden" name="poll_id" value="1"/>
<input type="submit" class="btn btn-mini btn-primary" value="vote"/>

<a id="pollHide" class="btn btn-mini btn-danger"><i class="icon-remove"></i></a>

</form>
</div><!-- poll -->

<a name="content"></a>
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

	var locale = document.cookie.search('_lang');
	if (locale == -1) {
		window.location = "?r=site/locale/ru";
	}
	var lang = document.cookie.slice(locale).split('=')[1];
	$('#langset').val(lang);

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


	// exchange rate
	$.get('/cache/nbt.html', function(resp) {
		var row = resp.split('\n');

		var USD = row[0].trim();
		var EUR = row[1].trim();
		var RUS = row[2].trim();

		$('#USD').html(USD);
		$('#EUR').html(EUR);
		$('#RUS').html(RUS);
	});


	$('#pollHide').click(function(){
		$('.poll').hide();
	});
});
</script>
</body>
</html>
