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

<div id="myCarousel" class="carousel slide" style="max-width:900px;border-radius:6px;max-height:300px;overflow:hidden;">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class></li>
    <li data-target="#myCarousel" data-slide-to="1" class></li>
    <li data-target="#myCarousel" data-slide-to="2" class></li>
  </ol>
  <div class="carousel-inner">
    <div class="item active">
      <img src="images/pic1.jpg">
      <div class="container">
        <div class="carousel-caption">
	  <h1><?php echo Yii::t('titles', 'cap1'); ?></h1> 
        </div>
      </div>
    </div>
    <div class="item">
      <img src="images/pic2.jpg" title="test">
      <div class="container">
        <div class="carousel-caption">
	  <h1><?php echo Yii::t('titles', 'cap2'); ?></h1> 
        </div>
      </div>
    </div>
    <div class="item">
      <img src="images/pic3.jpg">
      <div class="container">
        <div class="carousel-caption">
	  <h1><?php echo Yii::t('titles', 'cap3'); ?></h1> 
        </div>
      </div>
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
</div>

<?php $this->layout = 'column2'; ?>

<div class="content">

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>Yii::t('pages', 'home.welcometo').CHtml::encode(Yii::app()->name),
)); ?>
<br>
<p class="hero" style="">Lots of easy ways to use Font Awesome</p>

<!--
<video width="320" height="240" controls>
  <source src="/video/bigbuck.webm" type="video/webm">
</video>
-->

</div><!-- content -->

<?php $this->endWidget(); ?>

<script>
$(function(){
    $('.carousel').carousel({ interval: 2000 });
});
</script>
