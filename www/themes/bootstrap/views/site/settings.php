<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
Yii::app()->user->returnUrl = $this->createUrl('/site/settings');

$this->pageTitle=Yii::app()->name . ' - Settings';
$this->breadcrumbs=array(
	'Settings',
);

?>

<div class="content">

<h1>Settings</h1>

<?php if(Yii::app()->user->hasFlash('settings')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('settings'),
    )); ?>

<?php else: ?>

<p>
Here you can change your account settings
</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'settings-form',
 	'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

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

