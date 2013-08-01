<?php /* @var $this Controller */ ?>
<?php 
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}
Yii::log($app->language, "warning", "site lang");
function toLang($ln)
{
	switch($ln)
	{
	case 'tj':
		return 'nav.lang.first';
	case 'ru':
		return 'nav.lang.second';
	case 'en':
		return 'nav.sitelang';
	}
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

<!--
	<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
-->
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'brand'=>'<img src="images/logo.png" style="height:29px;margin-left:20px;margin-bottom:8px;padding-right:-10px;" /><i style="font-weight: bold;text-shadow: 1px 1px 5px red;">sonpay</i>',
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>Yii::t('navbar', 'nav.home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('navbar', 'nav.about'),
	       	      'url'=>array('/site/page',
		      'view'=>'about'),
		      'visible'=>true
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
		// language setter
		array('label'=>Yii::t('navbar', toLang($app->language)),
		      'url'=>array('#'),
		      'visible'=>true,
		      'itemOptions'=>array('class'=>'dropdown'),
		      'items'=>array(
			      array('label'=>Yii::t('navbar',
			      $app->language == 'tj' ? 'nav.sitelang' : 'nav.lang.first'),
			      	'url'=>array('/site/locale/'.Yii::t('lntr',
				  Yii::t('navbar',
				  $app->language == 'tj' ? 'nav.sitelang' : 'nav.lang.first')
			        ))
		              ),
			      array('label'=>Yii::t('navbar',
			        $app->language == 'ru' ? 'nav.sitelang' : 'nav.lang.second'
		      	      ),
			      'url'=>array('/site/locale/'.Yii::t('lntr',
			      Yii::t('navbar',
			        $app->language == 'ru' ? 'nav.sitelang' : 'nav.lang.second'
		      	      )))),
		      ),
	        ),
            ),
        ),

	'<div class="container-fluid"><form class="navbar-search pull-right">
	 <input id="navsearch" type="text" class="search-query" placeholder="Search...">
	 </form></div>',
	 '<a href="https://github.com/jukarimov/sonpay"><img style="position: absolute; top: 0; right: 0; border: 0;margin-top:-10px;margin-right:-10px;width:110px" src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png" alt="Fork me on GitHub"></a>'
    ),
)); ?>

<div class="container-fluid" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
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
<a href="#" title="open" onclick="switchChat();window.open('/etc/chat/index.php');">[O]</a>
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
	$('.navbar-inner').children().attr('class','container-fluid');
	$('#navsearch').focus(function(){
		$('.navbar-search').attr('class','navbar-search pull-left');
		$('.navbar-search').css('width','20%');
	});
	$('#navsearch').blur(function(){
		$('.navbar-search').attr('class','navbar-search pull-right');
		$('.navbar-search').css('width','10%');
	});

});
</script>
</body>
</html>
