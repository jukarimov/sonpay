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
<div class="hero"><?php echo Yii::t('pages', 'about.workhours');?></div>
</div>
