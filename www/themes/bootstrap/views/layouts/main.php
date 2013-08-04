<?php /* @var $this Controller */

?>
<?php 
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}

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

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
	/*
	'brand'=>'<img src="images/logo.png" style="height:29px;margin-left:20px;margin-bottom:8px;padding-right:-10px;" /><i style="font-weight: bold;text-shadow: 1px 1px 5px red;">sonpay</i>',
	 */
    'fluid'=>true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>Yii::t('navbar', 'nav.home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('navbar', 'nav.about'),
	       	      'url'=>array('/site/page', 'view'=>'about'), 'visible'=>true
	        ),
		array('label'=>Yii::t('navbar', 'nav.admins'), // if this is admin, display users management page
	       	      'url'=>array('/site/admins'),
		      'visible'=>!Yii::app()->user->isGuest
	        ),
		array('label'=>Yii::t('navbar', 'nav.contact'),
	       	      'url'=>array('/site/contact'),
		      'visible'=>Yii::app()->user->isGuest
	        ),
		array('label'=>Yii::t('navbar','nav.settings'),
	       	      'url'=>array('/site/settings'),
		      'visible'=>!Yii::app()->user->isGuest
	        ),
		array('label'=>Yii::t('navbar', 'nav.login'),
	       	      'url'=>array('/site/login'),
		      'visible'=>Yii::app()->user->isGuest
		),
		array('label'=>Yii::t('navbar', 'nav.logout').'('.Yii::app()->user->name.')',
	       	      'url'=>array('/site/logout'),
		      'visible'=>!Yii::app()->user->isGuest
		),
		array('label'=>Yii::t('navbar', 'nav.messages').'('.new MessageManager().')',
		      'url'=>array('/site/messages'),
		      'visible'=>!Yii::app()->user->isGuest,
		      'itemOptions'=>array('class'=>'msgcnt'),
		),
		// dropdowns
		array('label'=>Yii::t('navbar', 'nav.dd1'),
		      'url'=>array('#'),
		      'visible'=>true,
		      'itemOptions'=>array('class'=>'dropdown bigtab'),
		      'items'=>array(
			      array('label'=>Yii::t('navbar', 'nav.dd1.i1'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i2'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i3'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i4'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i5'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i6'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i7'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i8'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.i9'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j1'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j2'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j3'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j4'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j5'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j6'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j7'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j8'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.j9'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k1'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k2'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k3'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k4'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k5'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k6'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k7'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k8'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.k9'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.l1'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.l2'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.l3'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.l4'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd1.l5'), 'url'=>array('#')),
		      )
	        ),
		// dropdowns
		array('label'=>Yii::t('navbar', 'nav.dd2'),
		      'url'=>array('#'),
		      'visible'=>true,
		      'itemOptions'=>array('class'=>'dropdown bigtab-pics'),
		      'items'=>array(
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
			 array('label'=>'', 'url'=>array('#'),
			       'linkOptions'=>array('style'=>'background-image: url("images/Bugatti.png");background-repeat: no-repeat;'),
			 ),
		      )
	        ),

		// dropdowns
		array('label'=>Yii::t('navbar', 'nav.dd3'),
		      'url'=>array('#'),
		      'visible'=>true,
		      'itemOptions'=>array('class'=>'dropdown'),
		      'items'=>array(
			      array('label'=>Yii::t('navbar', 'nav.dd3.j2'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd3.j3'), 'url'=>array('#')),
			      array('label'=>Yii::t('navbar', 'nav.dd3.j4'), 'url'=>array('#')),
		      )
	        ),

            ),
        ),
		'<div class="container-fluid"><form class="navbar-search pull-right">
			 <input id="navsearch" type="text" class="search-query" placeholder="Search...">
		 </form></div>',
		'
<div class="langopts">
<i id="flag" class="icon-flag icon-white"></i>
<a href="?r=site/locale/en">en</a>
<a href="?r=site/locale/tj">tj</a>
<a href="?r=site/locale/ru">ru</a>
</div>
		'
    ),
)); ?>


<h1 class="logo">
<img src="images/mitsu_logo.png" width="100" style=""/>
Osonpay is real cool
</h1>
<p class="hero" style="color:#fff;">Lots of easy ways to use Font Awesome</p>


<div class="container-fluid" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink' => CHtml::link(Yii::t('titles','bread.home'), Yii::app()->homeUrl),
			/*
			'messagesLink' => CHtml::link(Yii::t('titles','bread.messages'),
				$this->createUrl('site/messages')),*/
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->

<div id="chat" class="chat" onclick="javascript:switchChat()">
<a href="#" id="gcount" class="chat-alert">?</a>
<p class="chatlabel" id="chatlab"><?echo Yii::t('widgets', 'live_chat');?></p>
<img src="images/chat.png">
</div>

<div class="messenger" id="messenger">
<a href="#" title="open" onclick="switchChat();window.open('/etc/chat/index.php?fs=1');">[O]</a>
<a style="float:right;" href="#" onclick="switchChat();" title="close">[X]</a>
<br>
<iframe id="iframechat" height="440" width="440" src=""></iframe>
</div>


<div id="footer">
	Copyright &copy; <?php echo date('Y'); ?> by OSonpay.<br/>
	All Rights Reserved.<br/>
	<?php echo Yii::powered(); ?>
</div><!-- footer -->

<script>

function switchChat() {

	if ($('#messenger').css('visibility') != 'visible') {
		// start chat here
		$('#iframechat').attr('src',"/etc/chat/index.php");
		$('#messenger').css('visibility','visible')
		$('#chat').css('visibility','hidden')
		$('#chat').css('bottom','-100px')

	} else {
		$('#messenger').css('visibility','hidden')
		$('#chat').css('visibility','visible')
		$('#chat').css('bottom','100px')
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
	$('#navsearch').focus(function(){
		$('.navbar-search').css('width','20%');
	});
	$('#navsearch').blur(function(){
		$('.navbar-search').css('width','10%');
	});
	$('.langopts').hover(
		function() {
			$('#flag').attr('class','icon-flag icon-black');
		},
		function() {
			$('#flag').attr('class','icon-flag icon-white');
		}
	);
	$('.brand').remove();

});
</script>
</body>
</html>
