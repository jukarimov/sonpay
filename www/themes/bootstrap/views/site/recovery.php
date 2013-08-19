<?php
Yii::app()->user->returnUrl = $this->createUrl('/site/recovery');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('pages','recovery.title');

?>

<div class="content">

<h1>
<?php echo Yii::t('pages', 'recovery.title'); ?>
</h1>

<?php if(Yii::app()->user->hasFlash('recovery')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('recovery'),
    )); ?>

<?php else: ?>

<h2 class="hero">
<?php echo Yii::t('pages', 'recovery.info'); ?>
</h2>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'recovery-form',
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

    <?php echo $form->textFieldRow($model,'email'); ?>
    <?php echo $form->textFieldRow($model,'repeat'); ?>


    <?php if(CCaptcha::checkRequirements()): ?>
    <?php echo $form->captchaRow($model,'verifyCode',array(
      'hint'=>'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.',
    )); ?>
    <?php endif; ?>


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


