<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'storage-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

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
	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php 
                if(isset($_GET['current_id']) && (int)$_GET['current_id'] > 0){
                        echo $form->dropDownList($model,'parent_id', Storage::getDropListById((int)$_GET['current_id']));
                }
                else{
                        echo $form->dropDownList($model,'parent_id', Storage::getDropList($model->parent_id));
                }
                ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->