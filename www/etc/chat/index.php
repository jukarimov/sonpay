<?

require_once('sstart.php');

$SITELANG_DEFAULT = 'ru';


$SITELANG = $_COOKIE['_lang'];
if (!$SITELANG)
	$SITELANG = $SITELANG_DEFAULT;

$LN = $SITELANG;
$SP = '&nbsp;&nbsp;';

$TR = array(
	'taken' => array(
		'en'=>'taken',
		'ru'=>'занято',
		'tj'=>'гирифтаги'
	),
	'blank' => array(
		'en'=>'is blank',
		'ru'=>'не заполнено',
		'tj'=>'но пурра'
	),
	'left' => array(
		'en'=>'left',
		'ru'=>'ушел',
		'tj'=>'рафт'
	),
	'support_is_offline' => array(
		'en'=>'All operators are busy, please await or use '.
			'<a target="_tab" href="/?r=site/contact">contact form</a> to leave a message, thank you.',

		'ru'=>'Все операторы заняты, пожалуйста подождите или оставьте свое сообщение через '.
			'<a target="_tab" href="/?r=site/contact">контакт форму</a>, спасибо.',

		'tj'=>'Хамаи операторхо банд хастанд, лутфан баъдтар озмоиш кунед ё Шумо метавонед '.
			'<a target="_tab" href="/?r=site/contact">формаи контакт-ро</a> истифода бареду паёматон-ро бо мо монед, ташакур.'
	),
	'support' => array(
		'en'=>'support',
		'ru'=>'консультант',
		'tj'=>'консультант'
	),
	'joined' => array(
		'en'=>'joined',
		'ru'=>'соединился',
		'tj'=>'пайваст шуд'
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
	if (!$ret)
		$ret = $TR[$field]['en'];

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
<script>
var FIX_SCREEN = false;
</script>

</head>

<body>
<?php
if (isset($_GET['fs']))
{
?>
<script>
FIX_SCREEN = true;
</script>
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
var hi_seen = false;

var clear_conversation = false;
var messages_counter = 0;
var conversation_size = 0;

$(function(){

	if (FIX_SCREEN) {
		$('.conversation').css('width','100%');
		//$('.conversation').css('overflow','hidden');
	}

	// tell guests we are up online
	$.get('notify.php?state=up');
	setInterval(function() {
		$.get('notify.php?state=up');
	}, 5 * 1000);


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
				$.post('send.php', { msg:'[hi]' });
			}
		);

		$('#cn').text(GUEST);

		fetchGuestMsg_id = setInterval('fetchGuestMsg()', 1500);
		/*
		setTimeout(function(){
			$.post('send.php',{msg:'[hi]'});
		}, 1500);
		*/
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
				'<b>' + GUEST + '</b> ' + '<?php echo tr('left'); ?><br>'
			);
		} else if (msg == '[hi]') {
			if (hi_seen == false) {
			  $('.conversation').append(
				'<b>' + GUEST + '</b> ' + '<?php echo tr('joined'); ?><br>'
			  );
			  hi_seen = true;
			}
		} else if (msg == '[typing]') {
			$('#typing').css('visibility','visible');
			setTimeout(function(){
				$('#typing').css('visibility','hidden');
			}, 2000);
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

		if (!msg.length) return;

		conversation_size += msg.length;

		if (conversation_size >= 1000) {
			clear_conversation = true;
			conversation_size = 0;
		}

		if (++messages_counter >= 6) {
			clear_conversation = true;
			messages_counter = 0;
		}

		if (clear_conversation) {
			//$('.conversation').html('');
		}
		

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
		$.post('send.php',{msg:'[typing]'});
	        if (e.keyCode == 13) {
	          if (this.value == '') return;

		  if ($('#msg').val().length >= 300) {
			alert('You text is too long, please edit and send again');
		  	return;
		  }

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

		if ($('#msg').val().length >= 300) {
			alert('You text is too long, please edit and send again');
			return;
		}
		
                postMsg($('#msg').val());
                $('#msg').val('');
                $('.conversation').scrollTop(1000);
        });

	$('#msg').focus(function(){
		// automatic notification for client
		//$.post('send.php',{msg:'[hi]'});
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
<a style="float:right;" href="#" onclick="$.get('/?r=site/logout',function(){window.location='';});"><i class="icon-remove icon-white"></i></a>
<font id="gtitle" color="#fff" style="float: right;"><i title="kick" id="ud" class="icon-remove"></i><b id="cn"></b></font>
<div class="admin-greeter">
</div>
<div class="content">

<div id="cover1" style="width: 30px; height: 90%; position: absolute; background-color: #DB0000; right: 0px;"></div>

<div id="cover2" style="top: 80%; width: 100%; height: 28px; position: absolute; background-color: #DB0000; left: 0px;"></div>

<div class="conversation">
</div>

<div class="row-fluid">
<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="send" class="inp-send btn btn-primary">send</a>
<a id="clear" class="inp-send btn btn-danger" title="clear conversation" onclick="$('.conversation').html('');"><i class="icon-remove"></i></a>	
&nbsp;&nbsp;<font id="typing">...<i class="icon-pencil"></i></font>
</div>

</div>

<div id="welcome">
<center>
<h1><?php echo tr('welcome') .' '. $_COOKIE['_user']; ?></h1>

<div class="chatlogin-admin">
<font style="position:absolute;left:130px;"><?php echo tr('guest');?>:</font><b id="glist"><i id="refresh" class="icon-refresh icon-spin"></i></b><br>
<div class="controls">
<a id="start" class="btn btn-primary"><i id="hp" class="icon-headphones icon-white"></i>Start</a>
&nbsp;&nbsp;&nbsp;
<a id="drop" class="btn btn-danger btn-mini"><i id="hp" class="icon-remove icon-white"></i>Drop</a><br>
</div><!-- controls -->
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

	echo '<font color="#fff">'.tr('hello').' <b id="me">' . $user . '</b></font>';
?>
<a id="leave" style="float:right;cursor:pointer" title="exit"><i class="icon-remove icon-white"></i></a>
<div class="content">

<div id="cover1" style="width: 40px; height: 92%; position: absolute; background-color: #DB0000; right: 0px;"></div>

<div id="cover2" style="top: 80%; width: 100%; height: 28px; position: absolute; background-color: #DB0000; left: 0px;"></div>

<div class="conversation">
</div>

<div class="row-fluid">
<input id="msg" class="inp-entry" name="msg" type="text"/>
<a id="clear" class="inp-send btn btn-danger" title="clear"><i class="icon-remove"></i></a>
<a id="send" class="inp-send btn btn-primary">send</a>
&nbsp;&nbsp;<font id="typing">...<i class="icon-pencil"></i></font>
</div>

</div>
<?
} else {
	
	
?>
<div class="content">
<div class="container-fluid">
<center>
<h1 class="hero" style="cursive;color:e90000;">Oson</h1>
<img style="position:absolute;top:10px;right:2px;width:100px;" src="/images/chat.png"/>
<h3 align="left" style="margin-left:5px;" class="hero"><?echo tr('note');?></h3>
<br>
<div class="chatlogin">
<div class="row-fluid">
<i id="cname_err" style="position:absolute;left:70px;top:190px;font-size:12px;color:red;"></i><?echo tr('name');?>: <input id="cname" name="cname" type="text" placeholder="Bobin" /><br>
 <?echo tr('email');?>: <input id="cemail" name="email" type="text" placeholder="bobin@gmail.com"/><br>
 <?echo tr('phone');?>: <input id="cphone" name="phone" type="text" placeholder="123 12 34 56"/><br>
<input id="genter" type="submit" class="btn btn-primary" value="Enter"/>
<span id="policy"><?echo tr('agree');?>:&nbsp;<input type="checkbox"/></span><br>
</div>
</div>
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
var off_seen = false;

$(document).ready(function(){

	if (FIX_SCREEN) {
		$('.conversation').css('width','100%');
	//	$('.conversation').css('overflow','hidden');
	}

	$('#genter').click(function(){

		var elts = [$('#cname'), $('#cemail'), $('#cphone')];

		var errs = false;
		for (i=0; i < elts.length; i++) {
			var v = elts[i];
			if (!$(v).val()) {
				$(v).css('border-color', 'red');
				$(v).attr('placeholder', '<?php echo tr('blank'); ?>');
				errs = true;
			}
			console.log(elts[i]);
		}
		if (errs) return;

		var post_cname = $('#cname').val();

		$.post('gadd.php', { cname: post_cname }, function(resp) {
			if (resp == 'error') {
				console.log('error');
				$('#cname').css('border-color', 'red');
				$('#cname_err').html('<?php echo tr('taken'); ?>');
			} else {
				$.post('send.php', { msg: '[hi]'});
				$.post('index.php', { cname: post_cname }, function() {
					window.location='';
				});
			}
		});
		setTimeout(function(){
			$.post('send.php', { msg: '[hi]'});
		}, 1500);

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

		if (off_seen == false) {
			$.get('opready.php', function(resp) {
				console.log('off_seen:' + parseInt(resp));
				if (!parseInt(resp)) {
					$('.conversation').append(
						'<div class="msg-sys"><?php echo tr('support_is_offline');?></div>'
					);
				}
			});
			off_seen = true;
		}

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
					'<?php echo tr('support');?> <b><?php echo tr('joined'); ?></b><br>'
				);
				hi_seen = true;
			}
		} else if (msg == '[typing]') {
			$('#typing').css('visibility','visible');
			setTimeout(function(){
				$('#typing').css('visibility','hidden');
			}, 2000);
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
	    $.post('send.php',{msg:'[typing]'});
	    if (e.keyCode == 13) {
	          if (this.value == '') return;

		  if ($('#msg').val().length >= 300) {
			alert('You text is too long, please edit and send again');
		  	return;
		  }

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

		if ($('#msg').val().length >= 300) {
			alert('You text is too long, please edit and send again');
			return;
		}

		postMsg($('#msg').val());
	        $('#msg').val('');
		$('.conversation').scrollTop(1000);
	});

	$('#msg').focus(function(){
		$.post('gadd.php', { cname: (me && me != '') ? me : $('#me').text() });
		//$.post('send.php',{msg:'[hi]'});
	});


<?php if (isset($_SESSION['user'])) { ?>

	if (!msgPoll_id)
		msgPoll_id = setInterval('msgPoll()', 1500);

	/*
	setTimeout(function(){
		$.post('send.php',{msg:'[hi]'});
	}, 1500)
	*/

<?php } ?>

});
</script>
<?php

}
?>
