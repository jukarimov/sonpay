<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="/home/assets/e3ecaab1/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/home/assets/e3ecaab1/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="/home/assets/e3ecaab1/css/yii.css" />
<link rel="stylesheet" type="text/css" href="/home/css/chat.css" />
<script type="text/javascript" src="/home/assets/7e745f75/jquery.js"></script>
<script type="text/javascript" src="/home/assets/e3ecaab1/js/bootstrap.js"></script>

</head>

<body onload="$('#msg').focus();">

<?

require_once('sstart.php');


$SITELANG = $_COOKIE['_lang'];
$LN = $SITELANG;
$SP = '&nbsp;&nbsp;';

$TR = array(
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
	       	<a href="http://localhost/home/index.php?r=site/page&view=policy">policy</a>',
		'ru'=>'Я согласен с 
	       	<a href="http://localhost/home/index.php?r=site/page&view=policy">политикой</a>',
		'tj'=>'Ман бо 
		<a href="http://localhost/home/index.php?r=site/page&view=policy">сиёсат</a>рози хастам'
	)
);

function tr($field) {
	global $SITELANG;
	if (!$SITELANG) $SITELANG = 'en';
	global $TR;
	$ret = $TR[$field][$SITELANG];
	return $ret;
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

		$('#glist').html('Loading...');

		$.post('udrop.php', { cname: GUEST });

	});

	$('#start').click(function() {

		if (!GUEST) return;

		clearInterval(getGuestList_id);
	
		$('#welcome').hide();
		$('.content').show();


		console.log(GUEST);

		$.post('utaken.php', { cname: GUEST },
			function(resp) {
				console.log('UTAKEN:' + resp);
			}
		);

		$('#cn').html('<b>Guest: </b>'+GUEST);

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
				$('#glist').html('None');
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

		$('.conversation').append(
			'<b>' + GUEST + ':</b>' +
			'<p class="msg">' + msg + '</p>'
		);
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

        $('#send').click(function(){
                if ($('#msg').val() == '') return;
		
                postMsg($('#msg').val());
                $('#msg').val('');
                $('.conversation').scrollTop(1000);
        });

       $('#msg').focus();


});
</script>


<div class="admin-greeter">
<font>Hello <b><?php echo $user; ?></b></font>
<font id="cn" style="float:right;"></font>
</div>
<div class="content">

<div class="conversation">
</div>

<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="send" class="inp-send btn btn-primary">send</a>

</div>

<div id="welcome">
<center>
<h1>Welcome <?php echo $_COOKIE['_user']; ?></h1>

<div class="chatlogin-admin">
Guest: <b id="glist">Loading...</b><br>
<a id="start" class="btn btn-primary"><i id="hp" class="icon-headphones icon-white"></i>Start</a>
&nbsp;&nbsp;&nbsp;
<a id="drop" class="btn btn-danger btn-mini"><i id="hp" class="icon-remove icon-white"></i>Drop</a><br>
</div>

</div>

</center>

<?php
} else { // this is guest, customer

if (isset($_POST['name']) || isset($_SESSION['user'])) {

	$user = $_SESSION['user'];

	if (isset($_POST['name'])) {
		$user = $_POST['name'];
		if (strlen($user) >= 2) {
			if ($user !== 'admin' && $user !== 'support')
			    $_SESSION['user'] = $_POST['name'];
			else
			    header('Redirect:index.php');
		}
	}

	echo '<font color="#fff">Hello <b>' . $user . '</b></font>';
?>
<div class="content">

<div class="conversation">
</div>

<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="send" class="inp-send btn btn-primary">send</a>

</div>
<?
} else {
	
	
?>

<div class="content">
<center>
<form action="" method="post" class="chatlogin">
<?echo tr('note');?>
<br>
 <?echo tr('name');?>: <input id="cname" name="name" type="text" placeholder="eg.: Bobin" /><br>
 <?echo tr('email');?>: <input name="email" type="text" placeholder="eg.: bobin@gmail.com"/><br>
 <?echo tr('phone');?>: <input name="phone" type="text" placeholder="eg.: 123 12 34 56"/><br>
 <?echo tr('agree');?>:&nbsp;<input type="checkbox"/><br>
<input id="genter" type="submit" class="btn btn-primary" value="Enter"/>
</form>
</center>
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
var mlist = [];
var msgPoll;
var msgPoll_id;
var getMsg;

$(document).ready(function(){

	$('#genter').click(function(){
		$.post('gadd.php', { cname: $('#cname').val() });
		msgPoll_id = setInterval('msgPoll()', 1500);
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

		$('.conversation').append(
			'<b>support:</b>' +
			'<p class="msg">' + msg + '</p>'
		);
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

	$('#send').click(function(){
		if ($('#msg').val() == '') return;

		postMsg($('#msg').val());
	        $('#msg').val('');
		$('.conversation').scrollTop(1000);
	});

	$('#msg').focus();

<?php if (isset($_SESSION['user'])) { ?>

	if (!msgPoll_id)
		msgPoll_id = setInterval('msgPoll()', 1500);

<?php } ?>

});
</script>
<?php

}
?>
