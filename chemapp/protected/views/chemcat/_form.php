<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemcat-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'chemcat_name'); ?>
		<?php echo $form->textField($model,'chemcat_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'chemcat_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php 
                if(isset($_GET['current_id']) && (int)$_GET['current_id'] > 0){
                        echo $form->dropDownList($model,'parent_id', Chemcat::getDropListById((int)$_GET['current_id']));
                }
                else{
                        echo $form->dropDownList($model,'parent_id', Chemcat::getDropList($model->parent_id));
                }
                ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->