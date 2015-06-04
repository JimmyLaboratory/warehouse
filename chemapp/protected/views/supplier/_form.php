<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">标有<span class="required">*</span> 符号为必填项</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <label>采购清单编号：</label><?php echo $cg='CG'.date('YmdHi').mt_rand(0, 999) ?>
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <input type="hidden" name="no" value="<?php echo $cg ?>" />
    </div>

    <?php if(isset($_GET['supplier_id'])): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'supplier_name'); ?>
			<?php echo $form->textField($model,'supplier_name',array('size'=>60,'maxlength'=>60)); ?>
			<?php echo $form->error($model,'supplier_name'); ?>
		</div>
	<?php endif; ?>
	<div class="row">

		<?php echo $form->labelEx($model,'website'); ?>
		<?php echo $form->textField($model,'website',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'website'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact'); ?>
		<?php echo $form->textField($model,'contact',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'contact'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel'); ?>
		<?php echo $form->textField($model,'tel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'representative'); ?>
		<?php echo $form->textField($model,'representative',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'representative'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'com_tel'); ?>
		<?php echo $form->textField($model,'com_tel',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'com_tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php if(!isset($_GET['supplier_id']))
				echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存');
			else
				echo CHtml::submitButton('生成采购单'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->