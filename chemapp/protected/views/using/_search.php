<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'using_id'); ?>
		<?php echo $form->textField($model,'using_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chem_id'); ?>
		<?php echo $form->textField($model,'chem_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timestamp'); ?>
		<?php echo $form->textField($model,'timestamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'applyuse'); ?>
		<?php echo $form->textField($model,'applyuse'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reason'); ?>
		<?php echo $form->textArea($model,'reason',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'use_start'); ?>
		<?php echo $form->textField($model,'use_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'useway'); ?>
		<?php echo $form->textField($model,'useway'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'junk'); ?>
		<?php echo $form->textArea($model,'junk',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'information'); ?>
		<?php echo $form->textArea($model,'information',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->