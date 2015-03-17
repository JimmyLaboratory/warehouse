<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'achieve-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'achieve_id'); ?>
		<?php echo $form->textField($model,'achieve_id',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'achieve_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
		<?php echo $form->error($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'achiever'); ?>
		<?php echo $form->textField($model,'achiever',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'achiever'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'achieve_info'); ?>
		<?php echo $form->textArea($model,'achieve_info',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'achieve_info'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->