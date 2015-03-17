<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'outstorage_id'); ?>
		<?php echo $form->textField($model,'outstorage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'using_id'); ?>
		<?php echo $form->textField($model,'using_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'apply_user_id'); ?>
		<?php echo $form->textField($model,'apply_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'duty_user_id'); ?>
		<?php echo $form->textField($model,'duty_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datetime'); ?>
		<?php echo $form->textField($model,'datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->