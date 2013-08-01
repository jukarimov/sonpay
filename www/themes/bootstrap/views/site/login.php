<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
if (
	Yii::app()->user->returnUrl != $this->createUrl('/site/settings') &&
	Yii::app()->user->returnUrl != $this->createUrl('/site/messages') &&
	Yii::app()->user->returnUrl != $this->createUrl('/site/admins'))
   {
	Yii::app()->user->returnUrl = $this->createUrl('/site/login');
   }
require('locale.php');

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('pages', 'login.title');
$this->breadcrumbs=array(
	Yii::t('pages', 'login.title'),
);
?>

<div class="content">
<h1><?php echo Yii::t('pages', 'login.title') ?></h1>

<p class="note">
<?php echo Yii::t('pages', 'login.note'); ?>
</p>


<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

<p class="note">
<?php echo Yii::t('pages', 'contact.requiredNote'); ?>
</p>


	<?php echo $form->textFieldRow($model,'username'); ?>

	<?php echo $form->passwordFieldRow($model,'password'); ?> 

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>


	<div class="form-actions">
	<?php echo $form->errorSummary($model, ''); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Login',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div><!-- content -->
