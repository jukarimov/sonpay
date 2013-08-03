<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
Yii::app()->user->returnUrl = $this->createUrl('/site/settings');
require('locale.php');


$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('titles', 'settings');
$this->breadcrumbs=array(
	Yii::t('titles','settings'),
);

?>

<div class="content">

<h1>
<?php echo Yii::t('titles', 'settings'); ?>
</h1>

<?php if(Yii::app()->user->hasFlash('settings')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('settings'),
    )); ?>

<?php else: ?>

<h2 class="hero">
<?php echo Yii::t('pages', 'settings.info'); ?>
</h2>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'settings-form',
 	'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<p class="note">
<?php echo Yii::t('pages', 'contact.requiredNote'); ?>
</p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->passwordFieldRow($model,'password'); ?>

    <?php echo $form->passwordFieldRow($model,'new_password'); ?>
    <?php echo $form->passwordFieldRow($model,'repeat'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Submit',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div><!-- content -->

<?php endif;

?>

