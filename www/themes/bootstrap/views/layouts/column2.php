<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3 content-sidebar">
        <div id="sidebar">
	  <center><h3 class="news-title"><?php echo Yii::t('pages', 'sidebar.title'); ?></h3></center>
	  <div class="news"> 
	    <p class="hero">Font Awesome</p>
	    <br>
	    <div>News hello world авыаодл цуктуцбьтываывлдоадл</div>
	  </div><!-- news -->
	  <div class="news"> 
	    <p class="hero">Some Cool News</p>
	    <br>
	    <div>News hello world авыаодл цуктуцбьтываывлдоадл</div>
	  </div><!-- news -->
	  <div class="news"> 
	    <p class="hero">More News</p>
	    <br>
	    <div>News hello world авыаодл цуктуцбьтываывлдоадл</div>
	  </div><!-- news -->
        <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'Operations',
            ));
            $this->widget('bootstrap.widgets.TbMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>
