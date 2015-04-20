
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chemcat-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

<?php
function getName($parent_id){
        $data = Chemcat::getDropListById($parent_id);
        return array_pop($data);
}
?>
		
	<div class="row">
		<?php 
			if(isset($cur_parent_id)){
				echo $form->labelEx($model,'parent_id');
				echo getName($cur_parent_id);
				echo "<input type=hidden name=Chemcat[parent_id] value=".$cur_parent_id.">";
			}

        ?>
        
    </div>
		<?php echo $form->error($model,'parent_id'); ?>
	



	<div class="row">
		<?php echo $form->labelEx($model,'chemcat_name'); ?>
		<?php echo $form->textField($model,'chemcat_name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'chemcat_name'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->