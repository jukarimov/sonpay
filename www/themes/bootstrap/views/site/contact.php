<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
Yii::app()->user->returnUrl = $this->createUrl('/site/contact');
require('locale.php');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('pages', 'contact.header');
$this->breadcrumbs=array(
	Yii::t('pages', 'contact.header'),
);
?>

<div class="content">
<h1><?php echo Yii::t('pages', 'contact.title'); ?></h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>

<?php else: ?>

<p>
<?php
//echo Yii::t('pages', 'contact.blablink');
?>
<h2 class="hero">
<?php
echo Yii::t('pages', 'contact.greeting');
?>
</h2>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
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


    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <div class="control-group">
	    <div class="controls">
    <?php echo $form->dropDownList($model,'message_type',
	 array(
		'comp'=>Yii::t('pages','contactForm.msgtype.comp'),
		'prop'=>Yii::t('pages', 'contactForm.msgtype.prop'),
	 ),
	 array('prompt' => Yii::t('pages','contactForm.msgtype'))
    ); ?>
	    </div>
    </div>

    <?php echo $form->textFieldRow($model,'subject'); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>6, 'class'=>'span8')); ?>

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

