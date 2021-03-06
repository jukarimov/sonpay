<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */
Yii::app()->user->returnUrl = $this->createUrl('/site/admins');
require_once('locale.php');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('titles', 'admins');
$this->breadcrumbs=array('Admins'=>Yii::t('titles', 'admins'));

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css" />
<script type="text/javascript" src="js/bootstrap-select.min.js"></script>

<div class="content">

<h1><?php echo Yii::t('titles', 'admins'); ?></h1>
<h3 class="hero"><?php echo Yii::t('pages', 'admins.info'); ?></h3>

<?php if(Yii::app()->user->hasFlash('admins')): ?>

    <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('admins'),
    )); ?>

<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'users-form',
 	'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
	'validateOnSubmit'=>true,
	),
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textField($model,'user_name',array('placeholder'=>'User name')); ?>
	<?php echo $form->dropDownList($model,'action',
		array(
			'create'=>Yii::t('pages','admins.create'),
			'delete'=>Yii::t('pages','admins.delete')
	)); ?>


	<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Submit',
        )); ?>

<?php if ($model->action == 'delete'):?>
	<div id="formDelete">
	<br>
	<p>Repeat the username to delete:
	<?php echo $form->textField($model,'repeat',array('placeholder'=>'Please repeat')); ?>
	</p>
	</div>
<?php elseif ($model->action == 'create'):?>

	<div id="formCreate">
	<br>
	<p>Password:
	<?php echo $form->PasswordField($model,'password',array('placeholder'=>'Password')); ?>
	<?php echo $form->PasswordField($model,'repeat',array('placeholder'=>'Please repeat')); ?>
	</p>
	<br>
	<p>Email:
	<?php echo $form->textField($model,'email',array('placeholder'=>'User email')); ?>
	</p>
	</div>
<?php endif; ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

</div><!-- content -->

<?php endif;

?>

<script>
	$(document).ready(function(){

		$('#AdminsForm_action').selectpicker();
	});

</script>
