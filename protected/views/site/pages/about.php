<?php
/* @var $this SiteController */
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	Yii::t('pages', 'about.header'),
);
?>
<h1><?php Yii::t('pages', 'about.header'); ?></h1>

<p>This is a "static" page. You may change the content of this page
by updating the file <code><?php echo __FILE__; ?></code>.</p>
