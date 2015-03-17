<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>欢迎使用 <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<br /><br />
<!-- <h1>登录</h1> -->

<div class="narrowPage">
<p>请输入用户名和密码:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<!-- <p class="note">标有<span class="required">*</span> 符号为必填项</p> -->

	<div class="row">
		<?php //echo $form->labelEx($model,'username'); ?>
		<label for="LoginForm_username" class="required">用户名<span class="required">*</span></label>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'password'); ?>
		<label for="LoginForm_password" class="required">密码<span class="required">*</span></label>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

</div><!-- .narrowPage -->