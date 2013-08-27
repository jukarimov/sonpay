<?php
/* @var $this SiteController */
/*
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}
 */
Yii::app()->user->returnUrl = $this->createUrl('/site/page&view=about');
require('locale.php');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('pages', 'about.header');
$this->breadcrumbs=array(
	Yii::t('pages', 'about.header'),
);
?>
<div class="content">
<h1><?php echo Yii::t('pages', 'about.header'); ?></h1>
<br>
<div class="hero"><?php echo Yii::t('pages', 'about.location');?></div>
<br>
<div><?php echo Yii::t('pages', 'about.address');?></div>
<br>
<div class="hero"><?php echo Yii::t('pages', 'about.workhours');?></div>
<br>

<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ru/maps?q=38.575212,68.799765&amp;num=1&amp;t=h&amp;hl=en&amp;ie=UTF8&amp;ll=38.575204,68.799766&amp;spn=0.00515,0.006899&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.ru/maps?q=38.575212,68.799765&amp;num=1&amp;t=h&amp;hl=en&amp;ie=UTF8&amp;ll=38.575204,68.799766&amp;spn=0.00515,0.006899&amp;z=14&amp;source=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>

</div>
