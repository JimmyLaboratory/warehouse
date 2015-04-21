<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'storage-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<?php
	function getName($parent_id){
	        $data = Storage::getDropListById($parent_id);
	        return array_pop($data);
	}
	?>
	<div class="row">
		<?php 
                if(isset($sid)){
				echo $form->labelEx($model,'parent_id');
				echo getName($sid);
				echo "<input type=hidden name=Storage[parent_id] value=".$sid.">";
			}
		?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'storage_name'); ?>

		<?php echo $form->textField($model,'storage_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'storage_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->