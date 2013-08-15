<?php
/* @var $this SiteController */
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}

$this->pageTitle=Yii::app()->name;
Yii::app()->user->returnUrl = $this->createUrl('/site/index');
?>


<div class="content">


<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>Yii::t('pages', 'home.welcometo').CHtml::encode(Yii::app()->name),
)); ?>
<br>
<p class="hero" style=""></p>

<!--
<video width="320" height="240" controls>
  <source src="/video/bigbuck.webm" type="video/webm">
</video>
-->

</div><!-- content -->
</div><!-- content -->

<?php $this->endWidget(); ?>

<script>
/*
$(function(){
    $('.carousel').carousel({ interval: 2000 });
});
*/
</script>
