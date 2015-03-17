<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'instorage_id'); ?>
		<?php echo $form->textField($model,'instorage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'purchasing_id'); ?>
		<?php echo $form->textField($model,'purchasing_id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'verifydate'); ?>
		<?php echo $form->textField($model,'verifydate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'expired'); ?>
		<?php echo $form->textField($model,'expired'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'specail_note'); ?>
		<?php echo $form->textArea($model,'specail_note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'weight'); ?>
		<?php echo $form->textField($model,'weight'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nums'); ?>
		<?php echo $form->textField($model,'nums'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->label($model,'deliver_name'); ?>
		<?php echo $form->textField($model,'deliver_name'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->label($model,'deliver_tel'); ?>
		<?php echo $form->textField($model,'deliver_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'storage_id'); ?>
		<?php echo $form->textField($model,'storage_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pics'); ?>
		<?php echo $form->textArea($model,'pics',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->