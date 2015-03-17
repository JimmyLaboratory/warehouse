<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'chem_id'); ?>
		<?php echo $form->textField($model,'chem_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chemcat_id'); ?>
		<?php echo $form->textField($model,'chemcat_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quality_id'); ?>
		<?php echo $form->textField($model,'quality_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quality_other'); ?>
		<?php echo $form->textField($model,'quality_other',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_package'); ?>
		<?php echo $form->textField($model,'unit_package'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unit_id'); ?>
		<?php echo $form->textField($model,'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nums'); ?>
		<?php echo $form->textField($model,'nums'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'production_date'); ?>
		<?php echo $form->textField($model,'production_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expired'); ?>
		<?php echo $form->textField($model,'expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'producer'); ?>
		<?php echo $form->textField($model,'producer',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'useway'); ?>
		<?php echo $form->textField($model,'useway'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_code'); ?>
		<?php echo $form->textField($model,'supplier_code',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supplier_other'); ?>
		<?php echo $form->textField($model,'supplier_other',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'specail_note'); ?>
		<?php echo $form->textArea($model,'specail_note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'used'); ?>
		<?php echo $form->textField($model,'used'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'storage_id'); ?>
		<?php echo $form->textField($model,'storage_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->