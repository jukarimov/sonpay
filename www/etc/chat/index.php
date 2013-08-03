<?

require_once('sstart.php');


$SITELANG = $_COOKIE['_lang'];
$LN = $SITELANG;
$SP = '&nbsp;&nbsp;';

$TR = array(
	'left' => array(
		'en'=>'left',
		'ru'=>'ушел',
		'tj'=>'рафт'
	),
	'support_joined' => array(
		'en'=>'support joined',
		'ru'=>'консультант соединился',
		'tj'=>'консультант пайваст шуд'
	),
	'hello' => array(
		'en'=>'Hello',
		'ru'=>'Привет',
		'tj'=>'Салом'
	),
	'welcome' => array(
		'en'=>'Welcome',
		'ru'=>'Приветствуем',
		'tj'=>'Хуш омадед'
	),
	'guest' => array(
		'en'=>'Guest',
		'ru'=>'Гость',
		'tj'=>'Мизочон'
	),
	'none' => array(
		'en'=>'None',
		'ru'=>'Нет',
		'tj'=>'Нест'
	),
	'title' => array(
			'en'=>'Live Support',
			'ru'=>'Онлайн Консультация',
			'tj'=>'Онлайн Машварат',
	),
	'name' => array(
			'en'=>'Name',
			'ru'=>$SP.'Имя',
			'tj'=>$SP.'Ном'
	),
	'email' => array(
			'en'=>'Email',
			'ru'=>'Почта',
			'tj'=>'Почта'
	),
	'phone' => array(
			'en'=>'Phone',
			'ru'=>$SP.'Моб.',
			'tj'=>$SP.'Моб.'
	),
	'note' => array(
		'en'=>'Welcome to live support<br>Please enter your credentials to start chat with support',
		'ru'=>'Добро пожаловать на онлайн консультацию<br>Пожалуйста введити ваши данные для начала',
		'tj'=>'Хуш омадед бо машварати онлайн<br>Пеш аз хама, лутфан маълумотхои худатонро пурра кунед'
	),
	'agree' => array(
		'en'=>'I\'m agree with the
	       	<a target="tab" href="/index.php?r=site/page&view=policy">policy</a>',
		'ru'=>'Я согласен с 
	       	<a target="tab" href="/index.php?r=site/page&view=policy">политикой</a>',
		'tj'=>'Ман бо 
		<a target="tab" href="/index.php?r=site/page&view=policy">сиёсат</a> рози хастам'
	)
);

function tr($field) {
	global $SITELANG;
	if (!$SITELANG) $SITELANG = 'en';
	global $TR;
	$ret = $TR[$field][$SITELANG];
	return $ret ? $ret : $field;
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="/assets/e3ecaab1/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/assets/e3ecaab1/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="/assets/e3ecaab1/css/yii.css" />
<link rel="stylesheet" type="text/css" href="/css/chat.css" />
<!--<link rel="stylesheet" type="text/css" href="/css/font-awesome/css/font-awesome.css" />-->
<script type="text/javascript" src="/assets/7e745f75/jquery.js"></script>
<script type="text/javascript" src="/assets/e3ecaab1/js/bootstrap.js"></script>
<title><?php echo 'Sopnay - ' . tr('title'); ?></title>

</head>

<body>
<?php
if (isset($_GET['fs']))
{
?>
<a href="/" title="home"><i class="icon-home icon-white"></i></a>
<?php
}
if (isset($_COOKIE['_user'])) {
// if this is our employee or admin
	$user = $_COOKIE['_user'];
?>

<script>
var GUEST;
var GUEST_SID;
var fetchGuestMsg;
var fetchGuestMsg_id;
var getGuestList;
var getGuestList_id;
var postMsg;
var getMsg;
var mlist = [];
$(function(){

	$('#stop').click(function() {
		
		$.post('close.php');
	});

	getGuestList_id = setInterval('getGuestList()', 5000);


	$('#drop').click(function() {

		if (!GUEST) return;

		$('#glist').html('<i id="refresh" class="icon-refresh icon-spin"></i>');

		$.post('udrop.php', { cname: GUEST });

	});
	$('#gtitle').hide();

	$('#start').click(function() {

		if (!GUEST) return;

		clearInterval(getGuestList_id);
	
		$('#welcome').hide();
		$('.content').show();
		$('#gtitle').show();


		console.log(GUEST);

		$.post('utaken.php', { cname: GUEST },
			function(resp) {
				console.log('UTAKEN:' + resp);
			}
		);

		$('#cn').text(GUEST);
		$.post('send.php',{msg:'[hi]'});

		fetchGuestMsg_id = setInterval('fetchGuestMsg()', 1500);
	});

	$('.content').hide();

	getGuestList = function() {
		
		$.get('glist.php', function(resp) {
			var guest, usid;
			console.log('glist.php:' + resp);
			if (resp) {
				try {
					if (JSON.parse(resp)) {
						guest = JSON.parse(resp)['name'];
					}
				} catch(e) {
					console.log('failed to parse:' + resp);
				}
			}
			if (guest) {
				$('#glist').html(guest);
			}
			else {
				$('#glist').html('<?php echo tr("none"); ?>');
				setTimeout(function() {
					$('#glist').html('<i id="refresh" class="icon-refresh icon-spin"></i>');
				}, 2000);
			}
			GUEST = guest;
		});

	}

	fetchGuestMsg = function() {
		$.get('get.php', function(resp){
			console.log('GET.PHP:' + resp);
			if (!resp) {
				console.log('get.php: bad resp:' + resp);
				return;
			} 
			try {
				JSON.parse(resp);
				console.log('parsed OK:' + resp);
			} catch(e) {
				console.log('failed to parse:' + resp);
			}
			
			if (mlist.indexOf(parseInt(JSON.parse(resp).id)) == -1)
		       	{
				mlist.push(parseInt(JSON.parse(resp).id));
				getMsg(JSON.parse(resp).msg);
			} else if (mlist) {
				var msgid = mlist[mlist.length-1]+1;
				$.get('get.php?id=' + msgid+1, function(resp){
					if (!resp) return;
					if (!JSON.parse(resp)) return;
					if (mlist.indexOf(parseInt(JSON.parse(resp).id)) != -1) return;
					mlist.push(parseInt(JSON.parse(resp).id));
					getMsg(JSON.parse(resp).msg);
				});
			}
		});
		return 'ok';
	}

	getMsg = function(msg) {
		if (!msg) return;
		if (!GUEST) return;
		if (!msg.length) return;

		msg = msg.replace('<','\\<');
		msg = msg.replace('>','\\>');
		msg = msg.replace('\\','');

	        console.log('got: ' + msg);

		if (msg == '[bye]') {
			$('.conversation').append(
				'<b>' + GUEST + '</b> ' + '<?php echo tr('left'); ?>'
			);
		} else {
			$('.conversation').append(
				'<b>' + GUEST + ':</b>' +
				'<p class="msg">' + msg + '</p>'
			);
		}
                $('.conversation').scrollTop(1000);
	}

	postMsg = function(msg) {
		if (!msg) return;
		if (!msg.length) return;

		msg = msg.replace('<','\\<');
		msg = msg.replace('>','\\>');
		msg = msg.replace('\\','');

	        console.log('send: ' + msg);

		$('.conversation').append(
			'<b><?echo $user;?>:</b>' +
			'<p class="msg">' + msg + '</p>'
		);

		$.post('send.php', { msg: msg },
			function(resp) {
				console.log(resp);
			}
		);
	}
	if (!fetchGuestMsg_id)
		fetchGuestMsg_id = setInterval('fetchGuestMsg()', 1500);

        $('#msg').keyup(function(e){
	            if (e.keyCode == 13) {
	                      if (this.value == '') return;
                      postMsg(this.value);
                      this.value = '';
                      $('.conversation').scrollTop(1000);
                }
        });


	$('#clear').click(function(){
		$('#msg').val('');
	});


        $('#send').click(function(){
                if ($('#msg').val() == '') return;
		
                postMsg($('#msg').val());
                $('#msg').val('');
                $('.conversation').scrollTop(1000);
        });

	$('#msg').focus(function(){
		// automatic notification for client
		$.post('send.php',{msg:'[hi]'});
	});

	$('#gtitle').hover(
		function() {
			$('#ud').attr('class','icon-remove icon-white');
		},
		function() {
			$('#ud').attr('class','icon-remove icon-black');
		}
	);

	$('#ud').click(function(){
		y = confirm('Are you sure?');
		if (y) {
			$.post('udrop.php', { cname: GUEST }, function() { window.location = ''; });
		}
	});


});
</script>


<font color="#fff"><? echo tr('hello') . ' <b>' . $user; ?></b></font>
<font id="gtitle" color="#fff" style="float: right;"><i title="kick" id="ud" class="icon-remove"></i><b id="cn"></b></font>
<div class="admin-greeter">
</div>
<div class="content">

<div id="cover1" style="width: 30px; height: 90%; position: absolute; background-color: maroon; right: 0px;"></div>

<div id="cover2" style="top: 80%; width: 100%; height: 28px; position: absolute; background-color: maroon; left: 0px;"></div>

<div class="conversation">
</div>

<div class="row-fluid">
<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="send" class="inp-send btn btn-primary">send</a>
</div>

</div>

<div id="welcome">
<center>
<h1><?php echo tr('welcome') .' '. $_COOKIE['_user']; ?></h1>

<div class="chatlogin-admin">
<?php echo tr('guest');?>: <b id="glist"><i id="refresh" class="icon-refresh icon-spin"></i></b><br>
<a id="start" class="btn btn-primary"><i id="hp" class="icon-headphones icon-white"></i>Start</a>
&nbsp;&nbsp;&nbsp;
<a id="drop" class="btn btn-danger btn-mini"><i id="hp" class="icon-remove icon-white"></i>Drop</a><br>
</div>

</div>

</center>

<?php
} else { // this is guest, customer

if (isset($_POST['cname']) || isset($_SESSION['user'])) {

	$user = $_SESSION['user'];

	if (isset($_POST['cname']) && !isset($_SESSION['user'])) {
		$user = $_POST['cname'];
		$user = trim($user);
		if (strlen($user) >= 2 && $user !== 'admin' && $user !== 'support') {
		    $_SESSION['user'] = $user;
		} else
		    $user = 'Guest_'.rand() % 1000;
	} else if (!isset($_SESSION['user'])) {
		$user = 'Guest_'.rand() % 1000;
	}

	$_SESSION['user'] = $user;

	echo '<font color="#fff">Hello <b id="me">' . $user . '</b></font>';
?>
<a id="leave" style="float:right;cursor:pointer" title="exit"><i class="icon-user icon-white"></i></a>
<div class="content">

<div id="cover1" style="width: 40px; height: 92%; position: absolute; background-color: maroon; right: 0px;"></div>

<div id="cover2" style="top: 80%; width: 100%; height: 28px; position: absolute; background-color: maroon; left: 0px;"></div>

<div class="conversation">
</div>

<div class="row-fluid">
<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="clear" class="inp-send btn btn-danger" title="clear"><i class="icon-remove"></i></a>
<a id="send" class="inp-send btn btn-primary">send</a>
</div>

</div>
<?
} else {
	
	
?>
<div class="content">
<div class="container-fluid">
<center>
<h1 class="hero">oSonpay</h1>
<img style="position:absolute;top:10px;right:2px;width:100px;" src="/images/chat.png"/>
<form action="" method="post" class="chatlogin">
<h3 align="left" style="margin-left:5px;" class="hero"><?echo tr('note');?></h3>
<br>
<div class="row-fluid">
 <?echo tr('name');?>: <input id="cname" name="cname" type="text" placeholder="Bobin" /><br>
 <?echo tr('email');?>: <input name="email" type="text" placeholder="bobin@gmail.com"/><br>
 <?echo tr('phone');?>: <input name="phone" type="text" placeholder="123 12 34 56"/><br>
<input id="genter" type="submit" class="btn btn-primary" value="Enter"/>
<span id="policy"><?echo tr('agree');?>:&nbsp;<input type="checkbox"/></span><br>
</div>
</form>
</center>
</div>
</div>

<?php 

}

}

?>

</body>
<?php 
// Guest content
if (!isset($_COOKIE['_user']))
{
?>
<script>
var me = '<?php echo $_SESSION['user']; ?>';
var mlist = [];
var msgPoll;
var msgPoll_id;
var getMsg;
var hi_seen = false;

$(document).ready(function(){

	$('#genter').click(function(){
		if (!$('#cname').val()) return;
		$.post('gadd.php', { cname: (me && me != '') ? me : $('#me').text() });
		msgPoll_id = setInterval('msgPoll()', 1500);
	});

	$.post('gadd.php', { cname: (me && me != '') ? me : $('#me').text() });

	$('#leave').click(function(){
		$.post('send.php', { msg: '[bye]' }, function() { window.location = ''; });
		$.post('gadd.php', { cname: $('#cname').val(), leave: 'y' });
	});

	msgPoll = function() {
		$.get('get.php', function(resp){
			console.log('GET.php:' + resp);
			if (!resp) return;
			console.log(JSON.parse(resp).msg);
			if (mlist.indexOf(parseInt(JSON.parse(resp).id)) == -1)
		       	{
				mlist.push(parseInt(JSON.parse(resp).id));
				getMsg(JSON.parse(resp).msg);
			} else if (mlist) {
				var msgid = mlist[mlist.length-1]+1;
				$.get('get.php?id=' + msgid+1, function(resp){
					if (!JSON.parse(resp)) return;
					if (mlist.indexOf(parseInt(JSON.parse(resp).id)) != -1) return;
					mlist.push(parseInt(JSON.parse(resp).id));
					getMsg(JSON.parse(resp).msg);
				});
			}
		});
	}


	getMsg = function(msg) {
		console.log('getMsg:' + msg);
		if (!msg) return;
		if (!msg.length) return;

		msg = msg.replace('<','\\<');
		msg = msg.replace('>','\\>');
		msg = msg.replace('\\','');

	        console.log('got: ' + msg);

		if (msg == '[hi]') {
			// this is protocol
			if (hi_seen == false)
			{
				$('.conversation').append(
					'<b><?php echo tr('support_joined'); ?></b><br>'
				);
			}
			hi_seen = true;
		} else {
			$('.conversation').append(
				'<b>support:</b>' +
				'<p class="msg">' + msg + '</p>'
			);
		}
                $('.conversation').scrollTop(1000);
	}

	function postMsg(msg) {
		if (!msg) return;
		if (!msg.length) return;

		msg = msg.replace('<','\\<');
		msg = msg.replace('>','\\>');
		msg = msg.replace('\\','');

	        console.log('send: ' + msg);

		$('.conversation').append(
			'<b><?echo $user;?>:</b>' +
			'<p class="msg">' + msg + '</p>'
		);

		$.post('send.php', { msg: msg },
			function(resp) {
				console.log(resp);
			}
		);
	}

	$('#msg').keyup(function(e){
	    if (e.keyCode == 13) {
	          if (this.value == '') return;
		  postMsg(this.value);
	          this.value = '';
		  $('.conversation').scrollTop(1000);
	        }
	});

	$('#clear').click(function(){
		$('#msg').val('');
	});

	$('#send').click(function(){
		if ($('#msg').val() == '') return;

		postMsg($('#msg').val());
	        $('#msg').val('');
		$('.conversation').scrollTop(1000);
	});

	$('#msg').focus(function(){
		$.post('gadd.php', { cname: (me && me != '') ? me : $('#me').text() });
	});

<?php if (isset($_SESSION['user'])) { ?>

	if (!msgPoll_id)
		msgPoll_id = setInterval('msgPoll()', 1500);

<?php } ?>

});
</script>
<?php

}
?>
